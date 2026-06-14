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

        return view('dashboard/index', [
            'totalPacientes'   => $totalPacientes,
            'totalAlertas'     => $totalAlertas,
            'alertasNaoVistos' => $alertasNaoVistos,
            'alertasRecentes'  => $alertasRecentes,
            'humoresRecentes'  => $humoresRecentes,
        ]);
    }
}