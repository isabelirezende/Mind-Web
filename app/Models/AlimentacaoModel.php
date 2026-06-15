<?php

namespace App\Models;

use CodeIgniter\Model;

class AlimentacaoModel extends Model
{
    protected $table         = 'alimentacoes';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['usuario_id', 'cafe_manha', 'almoco', 'jantar', 'lanches'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'usuario_id' => 'required|integer',
    ];

    public function ultimoRegistro(int $usuarioId): array|null
    {
        return $this->where('usuario_id', $usuarioId)
                    ->orderBy('criado_em', 'DESC')
                    ->first();
    }

    public function historicoCompleto(int $usuarioId, int $limite = 10): array
    {
        return $this->where('usuario_id', $usuarioId)
                    ->orderBy('criado_em', 'DESC')
                    ->limit($limite)
                    ->findAll();
    }
}