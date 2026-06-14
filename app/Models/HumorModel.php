<?php

namespace App\Models;

use CodeIgniter\Model;

class HumorModel extends Model
{
    protected $table         = 'humores';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['usuario_id', 'nivel', 'observacao'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'usuario_id' => 'required|integer',
        'nivel'      => 'required|in_list[excelente,bom,neutro,ruim,pessimo]',
    ];

    protected $validationMessages = [
        'nivel' => ['required' => 'Selecione um humor.', 'in_list' => 'Humor inválido.'],
    ];

    /**
     * Busca os últimos N registros de um usuário.
     */
    public function ultimosRegistros(int $usuarioId, int $limite = 5): array
    {
        return $this->where('usuario_id', $usuarioId)
                    ->orderBy('criado_em', 'DESC')
                    ->limit($limite)
                    ->findAll();
    }
}