<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AuthorTicketsController extends Controller
{
    public function index($author_id){

        return TicketResource::collection(Ticket::where('user_id' , $author_id)->paginate());
    }
}
