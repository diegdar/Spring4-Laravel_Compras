<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/*
🗒️NOTAS:
1: Este método Authorize() se utiliza para indicar qué usuarios tienen acceso, pero esto ya se puede manejar con las políticas, por lo que es mejor dejar la devolución verdadera.
2: valida los datos recibidos por el formulario.
3: Personaliza los mensajes de validación.
4: Personalice los nombres de los atributos en el formulario.*/

class validationProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;// nota 1
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [//nota 2
            'description'=>'required|string|min:4',
            'measurement_unit'=>'required|string|in:Kilogramo,Gramo,Litro,Unidad',
            'category'=>'required|string|in:Alimentacion,Limpieza,Higiene personal,Hogar',
        ];
    }
    public function messages(): array //nota 3 
    {
        return[
            // description
                'description.required'=> 'Este campo es obligatorio',
                'description.min'=> 'Debe tener al menos 4 letras',
                'description.regex'=> 'Se admite solo letras',
            // measurement_unit
                'measurement_unit.required'=> 'Este campo es obligatorio',
                'measurement_unit.in'=> 'Debes elegir un valor',
            // category
                'category.required'=> 'Este campo es obligatorio',
                'category.string'=> 'Se admite solo letras',
                'category.in'=> 'Debes escoger un valor',
        ];
    }
    public function attributes():array//nota 4 
    {
        return[
            'description'=>'descripcion del producto',
            'unit_price'=>'precio unitario del producto',
            'category'=>'categoria del producto, pudiendo ser solo: Alimentacion, Higiene personal o Hogar',
        ];
    }


}
