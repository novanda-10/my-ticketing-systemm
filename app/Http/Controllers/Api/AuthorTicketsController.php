<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplaceTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorTicketsController extends ApiController
{

    public function index($author_id){

        return TicketResource::collection(Ticket::where('user_id' , $author_id)->paginate());
    }


    public function store($author_id, StoreTicketRequest $request)
    {
        


        $model = [
            "title" => $request->input('data.attributes.title'),
            "description" => $request->input('data.attributes.description'),
            "status" => $request->input('data.attributes.status'),
            "user_id" => $author_id,
        ];


        return new TicketResource(Ticket::create($model));//TicketResource just for better output
    }


    public function replace(ReplaceTicketRequest $request,$author_id, $ticket_id){

        try {
            $ticket = Ticket::findOrFail($ticket_id);


            if($ticket->user_id == $author_id){
                $model = [
                    "title" => $request->input('data.attributes.title'),
                    "description" => $request->input('data.attributes.description'),
                    "status" => $request->input('data.attributes.status'),
                    "user_id" => $request->input('data.relationships.author.data.id'),
                ];
        
                $ticket->update($model);
        
                return new TicketResource($ticket);
            }



        } catch (ModelNotFoundException $exeption) {
            return $this->error("ticket not found" , 404);
        }



    }


    public function destroy($author_id , $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);


            if ($ticket->user_id == $author_id) {
                $ticket->delete();
                return $this->ok('ticket succesfully deleted');
            }

            return $this->error("ticket not found" , 404);

        } catch (ModelNotFoundException $exeption) {
            return $this->error("ticket not found" , 404);
        }
    }
}
