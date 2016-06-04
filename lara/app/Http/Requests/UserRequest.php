<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request as Req;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Req $request)
    {
        $rules = [
            'name'  => 'required',
            'email' => 'required|email',
        ];
        if (is_null($request->id)) {
            $rules['password'] = 'required';
        }

        return $rules;
    }


}
