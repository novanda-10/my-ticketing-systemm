<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplaceTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\TicketPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorTicketsController extends ApiController
{
    protected $policyClass = TicketPolicy::class;

    public function index($author_id){

        return TicketResource::collection(Ticket::where('user_id' , $author_id)->paginate());
    }


    public function store(StoreTicketRequest $request ,$author_id)
    {
 

        try {
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));


            $this->isAble('store', Ticket::class);
           // $this->isAble('store' , Ticket::class);

        } catch (ModelNotFoundException $exeption) {
          return   $this->ok('user not found',[
                'error' => 'the provided user id does not exists'
            ]);
        } catch(AuthorizationException $ex){
            return $this->error('you are not authorize to update that resource',401);
        }



        return new TicketResource(Ticket::create($request->mappedAttributes()));
    }


    public function replace(ReplaceTicketRequest $request,$author_id, $ticket_id){

        try {
            $ticket = Ticket::findOrFail($ticket_id);


            if($ticket->user_id == $author_id){
        

            //policy
            $this->isAble('replace' , $ticket);

                $ticket->update($request->mappedAttributes());
        
                return new TicketResource($ticket);
            }



        } catch (ModelNotFoundException $exeption) {
            return $this->error("ticket not found" , 404);
        } catch(AuthorizationException $ex){
            return $this->error('you are not authorize to update that resource',401);
        }



    }


    public function update(UpdateTicketRequest $request,$author_id, $ticket_id){

        try {
            $ticket = Ticket::findOrFail($ticket_id);


            if($ticket->user_id == $author_id){

            //policy
            $this->isAble('update' , $ticket);
        
                $ticket->update($request->mappedAttributes());
        
                return new TicketResource($ticket);
            }



        } catch (ModelNotFoundException $exeption) {
            return $this->error("ticket not found" , 404);
        } catch(AuthorizationException $ex){
            return $this->error('you are not authorize to update that resource',401);
        }



    }

    public function destroy($author_id , $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);


            if ($ticket->user_id == $author_id) {

                $this->isAble('delete' , $ticket);
                $ticket->delete();
                return $this->ok('ticket succesfully deleted');
            }

            return $this->error("ticket not found" , 404);

        } catch (ModelNotFoundException $exeption) {
            return $this->error("ticket not found" , 404);
        } catch(AuthorizationException $ex){
            return $this->error('you are not authorize to update that resource',401);
        }
    }
}
