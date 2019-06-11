<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'title'       => 'required|min:5|max:200|umique:blog_posts',
          'slug'        => 'max:200',
          'description' => 'required|string|min:5|max:10000',
          'parent_id'   => 'required|integer|exists:blog_categories,id',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
      return [
        'title.required'  => 'Введите заголовок статьи',
        'content_raw.min' => 'Минимальная длина статьи [:min] символов',
      ];
    }

    /**
    * Get custom atributes for validator errors.
    *
    * @return array
    */
    public function attibutes()
    {
      return [
        'title' => 'Заголовок',
      ];
    }
}
