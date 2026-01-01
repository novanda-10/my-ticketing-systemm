<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'ticket',
            'id' => $this->id,
            'attributes' =>[
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'createdAt' =>$this->created_at,
                'updatedAt' =>$this->updated_at,
            ],
            'relationships'=>[
                'author'=>[
                    'type' => 'user',
                    'id' => $this->user_id, 
                ],
                'links' =>[
                    'self' => route('authors.show' , ['author' =>$this->user_id])
                ]
            ],         
           // dd($this),  
            'includes' => [
                'user' =>[
                    'name' =>$this->user->name ,
                    'id' =>$this->user_id,
                ]
            ],

            'links' => [

                'self' => route('tickets.show' , ['ticket' =>$this->id])

            ]
            
        ];
    }
}
