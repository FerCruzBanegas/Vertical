<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaterialRequest extends FormRequest
{
    protected $units = ['amarro', 'barra', 'bolsa', 'caja', 'cajón', 'carga', 'dm³', 'fajo', 'fardo', 'g', 'galón', 'glb', 'ha', 'juego', 'kg', 'l', 'lata', 'lb', 'm', 'm²', 'm³', 'mm', 'perfil', 'pie', 'pie²', 'placa', 'plomo', 'pqte', 'pto', 'pza', 'resma', 'rollo', 't', 'tubo', 'turril', 'unds'];

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:60|unique:materials,name',
            'unity' => ['required', Rule::in($this->units)],
            'description' => 'nullable|min:5|max:120',
            'price' => 'nullable|max:9|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'material_type_id' => 'required|integer'
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['name'] .= ',' . $this->id;
        }

        return $rules;
    }
}
