<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postagens extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo','data','local','imagem','descricao'
    ];
}
