<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'user_id' => 'required|integer|exists:users,id',
            
        ];
        return $rules;
    }
  
   public function messages(): array
   {
       return [
           'image_id.required' => "don't have image",
           'user_id.required' => "don't have user",
        
       ];
   }
}
