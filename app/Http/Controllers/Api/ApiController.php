<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Policies\TicketPolicy;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponses;
    use AuthorizesRequests;

    protected $policyClass;//for knowing which policy we are using TicketPolicy or UserPolicy

    //

    public function isAble($ability , $targetModel){
        return $this->authorize($ability , [$targetModel , $this->policyClass]);
        //example
        //$this->authorize('update' , [$ticket , TicketPolicy::class])
    }
}
