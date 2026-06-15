<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\AlertaModel;
use App\Models\HumorModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $usuarioModel    = new UsuarioModel();
        $alertaModel     = new AlertaModel();
        $humorModel      = new HumorModel();

        // Contagem de pacientes
        $totalPacientes = $usuarioModel->where('role', 'paciente')->countAllResults();

        // Alertas não visualizados
        $alertasNaoVistos = $alertaModel->alertasNaoVistos();
        $totalAlertas     = count($alertasNaoVistos);

        // Todos os alertas recentes (para a tabela)
        $alertasRecentes = $alertaModel->todosAlertas(10);

        // Registros de humor recentes (todos os pacientes)
        $humoresRecentes = $humorModel
            ->db->table('humores h')
            ->select('h.*, u.nome as paciente_nome')
            ->join('usuarios u', 'u.id = h.usuario_id')
            ->orderBy('h.criado_em', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
            
        $dadosGrafico = $this->dadosGraficoGeral();
        $pacientes = $usuarioModel->listarPacientes();

        return view('dashboard/index', [
            'totalPacientes'   => $totalPacientes,
            'totalAlertas'     => $totalAlertas,
            'alertasNaoVistos' => $alertasNaoVistos,
            'alertasRecentes'  => $alertasRecentes,
            'humoresRecentes'  => $humoresRecentes,
            'dadosGrafico'     => $dadosGrafico,
            'pacientes'        => $pacientes,
        ]);
    }

    private function dadosGraficoGeral(): array
    {
        $humorModel = new \App\Models\HumorModel();

        $escala = [
            'pessimo'   => 1,
            'ruim'      => 2,
            'neutro'    => 3,
            'bom'       => 4,
            'excelente' => 5,
        ];

        // Busca registros dos últimos 14 dias, agrupados por dia
        $registros = $humorModel->select('nivel, DATE(criado_em) as dia')
                                ->where('criado_em >=', date('Y-m-d', strtotime('-14 days')))
                                ->orderBy('criado_em', 'ASC')
                                ->findAll();

        $porDia = [];
        foreach ($registros as $r) {
            $valor = $escala[$r['nivel']] ?? 3;
            $porDia[$r['dia']][] = $valor;
        }

        $labels  = [];
        $valores = [];

        foreach ($porDia as $dia => $valoresDia) {
            $labels[]  = date('d/m', strtotime($dia));
            $valores[] = round(array_sum($valoresDia) / count($valoresDia), 1);
        }

        return ['labels' => $labels, 'valores' => $valores];
    }
}