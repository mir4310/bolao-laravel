<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    // 1. Libera os campos para serem salvos
    protected $fillable = ['nome', 'sigla'];

    // 2. Truque: Cria um atributo virtual chamado 'bandeira'
    public function getBandeiraAttribute()
    {
        // Converte a sigla para minúsculo e adiciona o .png
        // Exemplo: se a sigla for BRA, ele retorna: http://localhost/img/bandeiras/bra.png
        return "https://flagcdn.com/w160/" . strtolower($this->slug) . ".png";
    }
}
