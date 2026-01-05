<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplaceUserRequest;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends ApiController
{
    protected $policyClass = UserPolicy ::class;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::paginate());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {

            $this->isAble('store', User::class);
           // $this->isAble('store' , User::class);

        }catch(AuthorizationException $ex){
            return $this->error('you are not authorize to update that resource',401);
        }


        return new UserResource(User::create($request->mappedAttributes()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);


            //policy
        //$this->authorize('update' , [$ticket , TicketPolicy::class]);
        //this two lines work the same just handeld TicketPolicy::class or UserPolicy::class in ApiController
            $this->isAble('update' , $user);


            $user->update($request->mappedAttributes());
    
            return new UserResource($user);




        } catch (ModelNotFoundException $exeption) {
            return $this->error("user not found" , 404);
        } catch(AuthorizationException $ex){
            return $this->error('you are not authorize to update that resource',401);
        }
    }

    public function replace(ReplaceUserRequest $request , $user_id){

        try {
            $user = User::findOrFail($user_id);



            //policy
            $this->isAble('replace' , $user);

    
            $user->update($request->mappedAttributes());
    
            return new UserResource($user);




        } catch (ModelNotFoundException $exeption) {
            return $this->error("user not found" , 404);
        }



    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        try {
            $user = User::findOrFail($user_id);


            //policy
            $this->isAble('delete' , $user);

            $user->delete();

            return $this->ok('user succesfully deleted');

        } catch (ModelNotFoundException $exeption) {
            return $this->error("user not found" , 404);
        }
    }
}
