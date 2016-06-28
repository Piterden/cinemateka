<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'      => 'required|min:2|max:255',
            'slug'       => 'min:2|max:255',
            'category_id' => 'required',
            // 'meta'     => 'json',
            // 'images'    => 'json',
            // 'actors'    => 'json',
            // 'awards'    => 'json',
            // 'videos'    => 'json',
            // 'properties'    => 'json',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
