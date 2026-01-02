<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{

    public function mappedAttributes(){
        $attributeMap = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.relationships.author.data.id' => 'user_id',
        ];

       // dd($attributeMap);

        $attributesToUpdate=[];
        foreach ($attributeMap as $index => $attribute) {//important loop
            if ($this->has($index)) {
                $attributesToUpdate[$attribute] = $this->input($index);
            }
        }

        return $attributesToUpdate;
    }   



    public function messages()
    {
        return [

            'data.attributes.status' => 'data.attributes.status is invalid please use A,C,H,X.'
        ];
    }
}
