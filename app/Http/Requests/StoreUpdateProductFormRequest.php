<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductFormRequest extends FormRequest
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
        //unique:<tabela>,<campo>,<valor_comparacao>,<campo_comparacao>
        //recupera id pelo segmento da url
        $id = $this->segment(3);
        
        return [
            'name'          => "required|min:3|max:100|unique:products,name,{$id},id",
            'url'           => "required|min:3|max:100|unique:products,url,{$id},id",
            'price'         => 'required',
            'description'   => 'max:9000',
            'category_id'   => 'required|exists:categories,id',
        ];
    }
    
    public function messages() 
    {
        return [
            'category_id.required' => 'O campo Categoria é de preenchimento obrigatório.'
        ];
    }
}
