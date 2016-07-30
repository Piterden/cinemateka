<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class StoreEventRequest extends CrudRequest
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
    // public function rules()
    // {
    //     return [
    //         'title'       => ['required', 'unique:events', 'max:255'],
    //         'slug'        => ['required', 'url'],
    //         'category_id' => ['required'],
    //     ];
    // }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    // public function attributes()
    // {
    //     return [
    //         'title', 'slug', 'category_id'
    //     ];
    // }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    // public function messages()
    // {
    //     return [
    //         'title.required'       => 'Необходимо указать заголовок',
    //         'slug.required'        => 'Необходимо указать псевдоним',
    //         'category_id.required' => 'Необходимо указать категорию',
    //     ];
    // }
}
