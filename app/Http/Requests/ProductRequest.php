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
        $qty = 'numeric';
        $price = 'numeric';
        $status = '';
        $weight = 'numeric';

        if ($this->method() == 'PUT')
        {
            $type = '';
            $sku = 'required|unique:products,sku,'. $this->get('id');
            $name = 'required|unique:products,name,'. $this->get('id');
            $status = 'required';
            
            if ($this->get('type') == 'simple') {
                $qty .= '|required';
                $price .= '|required';
                $weight .= '|required';
            }
        } else {
            $type = 'required';
            $sku = 'required|unique:products,sku';
            $name = 'required|unique:products,name';
        }

        return [
            'type' => $type,
            'sku' => $sku,
            'name' => $name,
            'price' => $price,
            'qty' => $qty,
            'status' => $status,
            'weight' => $weight,
        ];
    }
}
