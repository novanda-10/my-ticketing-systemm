<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplaceTicketRequest;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function Laravel\Prompts\error;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TicketResource::collection(Ticket::paginate());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));
        } catch (ModelNotFoundException $exeption) {
          return   $this->ok('user not found',[
                'error' => 'the provided user id does not exists'
            ]);
        }


        $model = [
            "title" => $request->input('data.attributes.title'),
            "description" => $request->input('data.attributes.description'),
            "status" => $request->input('data.attributes.status'),
            "user_id" => $request->input('data.relationships.author.data.id'),
        ];


        return new TicketResource(Ticket::create($model));//TicketResource just for better output
    }

    /**
     * Display the specified resource.
     */
    public function show($ticket_id)
    {



        try {
            $ticket = Ticket::findOrFail($ticket_id);
            return new TicketResource($ticket);

        } catch (ModelNotFoundException $exeption) {
            return $this->error("ticket not found" , 404);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        //
    }

    public function replace(ReplaceTicketRequest $request , $ticket_id){

        try {
            $ticket = Ticket::findOrFail($ticket_id);


            $model = [
                "title" => $request->input('data.attributes.title'),
                "description" => $request->input('data.attributes.description'),
                "status" => $request->input('data.attributes.status'),
                "user_id" => $request->input('data.relationships.author.data.id'),
            ];
    
            $ticket->update($model);
    
            return new TicketResource($ticket);




        } catch (ModelNotFoundException $exeption) {
            return $this->error("ticket not found" , 404);
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->delete();

            return $this->ok('ticket succesfully deleted');

        } catch (ModelNotFoundException $exeption) {
            return $this->error("ticket not found" , 404);
        }
    }
}
