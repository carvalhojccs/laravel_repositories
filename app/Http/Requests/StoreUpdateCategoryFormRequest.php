<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCategoryFormRequest extends FormRequest
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
        //recupera o segmento com o id do item a ser editado
        $id = $this->segment(3);
        return [
            //define que o campo é único na tabela categories e adiciona uma exceção caso este não seja editado
            //unique:<tabela>,<coluna>,{<id_do_item},<id_do_item_na_tabela>,
            'title'         => "required|min:3|max:60|unique:categories,title,{$id},id",
            //'url'           => "required|min:3|max:60|unique:categories,url,{$id},id",
            'description'   => 'max:2000',
            
        ];
    }
}
