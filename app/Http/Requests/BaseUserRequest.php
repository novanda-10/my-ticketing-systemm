<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
{

    public function mappedAttributes(){
        $attributeMap = [
            'data.attributes.name' => 'name',
            'data.attributes.email' => 'email',
            'data.attributes.isManager' => 'is_manager',
            'data.attributes.password' => 'password',

        ];

       // dd($attributeMap);

        $attributesToUpdate=[];
        foreach ($attributeMap as $index => $attribute) {//important loop
            if ($this->has($index)) {

                $value = $this->input($index);
                if($attribute ==='password'){
                    $value = bcrypt($value);
                }

                $attributesToUpdate[$attribute] = $value;
            }
        }

        return $attributesToUpdate;
    }   



}
