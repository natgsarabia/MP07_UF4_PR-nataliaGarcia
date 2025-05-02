<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //actualizamos a true para permitir lo pueda usar cualquier usuario autenticado
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //actualizamos con las reglas de validación de los atributos que debe de tener los productos
        return [
            'name'  => 'required|string|max:255',
            'category'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ];
    }
}
