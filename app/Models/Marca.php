<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return $regras = [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required'
        ];
    }

    public function feedback() {
        return $feedback = [
            'required' => 'O campo :attribute é obrigatório',
            'marca.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome deve ter no minimo 3 caracteres'
        ];
    }
}
