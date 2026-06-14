<?php

namespace App\Models;

use CodeIgniter\Model;

class DiarioModel extends Model
{
    protected $table         = 'diarios';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['usuario_id', 'conteudo'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'usuario_id' => 'required|integer',
        'conteudo'   => 'required|min_length[3]',
    ];

    protected $validationMessages = [
        'conteudo' => ['required' => 'Escreva algo antes de salvar.'],
    ];
}