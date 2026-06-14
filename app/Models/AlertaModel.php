<?php

namespace App\Models;

use CodeIgniter\Model;

class AlertaModel extends Model
{
    protected $table         = 'alertas';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['usuario_id', 'tipo', 'visualizado'];

    protected $useTimestamps = false;

    /**
     * Busca alertas não visualizados com nome do paciente (para o dashboard).
     */
    public function alertasNaoVistos(): array
    {
        return $this->db->table('alertas a')
            ->select('a.*, u.nome as paciente_nome')
            ->join('usuarios u', 'u.id = a.usuario_id')
            ->where('a.visualizado', 0)
            ->orderBy('a.criado_em', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Busca todos os alertas com nome do paciente.
     */
    public function todosAlertas(int $limite = 20): array
    {
        return $this->db->table('alertas a')
            ->select('a.*, u.nome as paciente_nome')
            ->join('usuarios u', 'u.id = a.usuario_id')
            ->orderBy('a.criado_em', 'DESC')
            ->limit($limite)
            ->get()
            ->getResultArray();
    }
}