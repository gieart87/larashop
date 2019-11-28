<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
    public function rules()
    {
        if ($this->method() == 'PUT')
        {
            $sku = 'required|unique:products,sku,'. $this->get('id');
            $name = 'required|unique:products,name,'. $this->get('id');
        } else {
            $sku = 'required|unique:products,sku';
            $name = 'required|unique:products,name';
        }

        return [
            'sku' => $sku,
            'name' => $name,
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required',
        ];
    }
}
