<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->slug){
            $this->merge(['slug'=>make_slug($this->slug)]);
        }else{
            $this->merge(['slug'=>make_slug($this->title)]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:2|max:255',
            'slug' => [
                'nullable',
                'min:3',
                'max:255',
                Rule::unique('categories','slug')->ignore(request()->category)
            ],
            'description' => 'nullable|min:8|max:500',
            'meta_description' => 'nullable|min:8|max:500',
            'meta_keywords' => 'nullable|min:2|max:500',
            'parent_id' => 'required|numeric',
        ];
    }
}
