<?php

namespace App\Http\Requests;

use App\Permissions\Abilities;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends BaseTicketRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'data.attributes.title' => 'sometimes|string',
            'data.attributes.description' => 'sometimes|string',
            'data.attributes.status' => 'sometimes|string|in:A,C,X,H',
            'data.relationships.author.data.id' => 'sometimes|integer',
        ];


        if($this->user()->tokenCan(Abilities::UpdateOwnTicket)){
            $rules ['data.relationships.author.data.id'] = 'prohibited';//forbid from sending author id
        }


        return $rules;
    }
}
