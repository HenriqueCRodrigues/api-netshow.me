<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        return [
            'name' => 'required', 
            'email' => 'required|email', 
            'message' => 'required',
            'file' => 'required|file|max:500|mimes:pdf,doc,docx,odt,txt',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.', 
            'email.required' => 'O email é obrigatório.', 
            'email.email' => 'O email não do tipo email.', 
            'message.required' => 'A mensagem é obrigatória.', 
            'file.required' => 'O arquivo é obrigatório.', 
            'file.file' => 'Não é um arquivo válido.', 
            'file.max' => 'O arquivo não pode ultrapassar os 500kb.', 
            'file.mimes' => 'Só é suportado arquivo do tipo pdf,doc,docx,odt ou txt.', 
        ];
    }
}
