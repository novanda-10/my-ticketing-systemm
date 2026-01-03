<?php

namespace App\Permissions;

use App\Models\User;

final class Abilities{
    public const CreateTicket = 'ticket:create';
    public const UpdateTicket = 'ticket:update';
    public const ReplaceTicket = 'ticket:Replace';
    public const DeleteTicket = 'ticket:delete';


    public const CreateOwnTicket = 'ticket:Own:create';
    public const UpdateOwnTicket = 'ticket:Own:update';
    public const DeleteOwnTicket = 'ticket:Own:delete';

    public const CreateUser = 'user:create';
    public const UpdateUser = 'user:update';
    public const ReplaceUser = 'user:Replace';
    public const DeleteUser = 'user:delete';



    public static function getAbilities(User $user){



        if ($user->is_manager){
            return [
                self::CreateTicket,
                self::UpdateTicket,
                self::ReplaceTicket,
                self::DeleteTicket,
                
                self::CreateUser,
                self::UpdateUser,
                self::ReplaceUser,
                self::DeleteUser,



 

            ];
        }else {
            return [
                self::CreateOwnTicket,
                self::UpdateOwnTicket,
                self::DeleteOwnTicket,

            ];
        }
    }

}