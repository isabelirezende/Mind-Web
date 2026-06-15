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

    public function historicoCompleto(int $usuarioId): array
    {
        return $this->where('usuario_id', $usuarioId)
                    ->orderBy('criado_em', 'DESC')
                    ->findAll();
    }

    /**
     * Retorna os últimos N registros formatados para gráfico
     * (data + valor numérico de 1 a 5).
     */
    public function dadosParaGrafico(int $usuarioId, int $limite = 14): array
    {
        $registros = $this->where('usuario_id', $usuarioId)
                        ->orderBy('criado_em', 'ASC')
                        ->findAll();

        // Pega só os últimos N, mas mantém ordem cronológica (mais antigo → mais novo)
        $registros = array_slice($registros, -$limite);

        $escala = [
            'pessimo'   => 1,
            'ruim'      => 2,
            'neutro'    => 3,
            'bom'       => 4,
            'excelente' => 5,
        ];

        $labels = [];
        $valores = [];

        foreach ($registros as $r) {
            $labels[]  = date('d/m', strtotime($r['criado_em']));
            $valores[] = $escala[$r['nivel']] ?? 3;
        }

        return [
            'labels'  => $labels,
            'valores' => $valores,
        ];
    }

    /**
     * Calcula quantos dias consecutivos (incluindo hoje ou ontem)
     * o usuário tem registro de humor.
     */
    public function calcularStreak(int $usuarioId): int
    {
        $registros = $this->select('DISTINCT DATE(criado_em) as dia')
                        ->where('usuario_id', $usuarioId)
                        ->orderBy('dia', 'DESC')
                        ->findAll();

        if (empty($registros)) {
            return 0;
        }

        $dias = array_map(fn($r) => $r['dia'], $registros);

        $streak = 0;
        $dataEsperada = date('Y-m-d'); // hoje

        foreach ($dias as $dia) {
            if ($dia === $dataEsperada) {
                $streak++;
                $dataEsperada = date('Y-m-d', strtotime($dataEsperada . ' -1 day'));
            } elseif ($dia === date('Y-m-d', strtotime($dataEsperada . ' +0 day')) && $streak === 0) {
                // Caso o primeiro registro seja de ontem (ainda não registrou hoje)
                $streak++;
                $dataEsperada = date('Y-m-d', strtotime($dia . ' -1 day'));
            } else {
                break;
            }
        }

        return $streak;
    }
}