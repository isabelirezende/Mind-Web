<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\HumorModel;
use App\Models\AlimentacaoModel;
use App\Models\DiarioModel;
use App\Models\AlertaModel;

class PacienteController extends BaseController
{
    public function detalhes(int $id)
    {
        $usuarioModel     = new UsuarioModel();
        $humorModel       = new HumorModel();
        $alimentacaoModel = new AlimentacaoModel();
        $diarioModel      = new DiarioModel();
        $alertaModel      = new AlertaModel();

        $paciente = $usuarioModel->find($id);

        // Garante que o ID pertence a um paciente válido
        if (! $paciente || $paciente['role'] !== 'paciente') {
            return redirect()->to('/dashboard')->with('erro', 'Paciente não encontrado.');
        }

        $historicoHumor       = $humorModel->historicoCompleto($id);
        $dadosGrafico         = $humorModel->dadosParaGrafico($id, 14);
        $historicoAlimentacao = $alimentacaoModel->historicoCompleto($id, 10);
        $historicoDiario      = $diarioModel->historicoCompleto($id, 10);
        $streak               = $humorModel->calcularStreak($id);

        // Conta alertas de pânico desse paciente
        $totalAlertas = $alertaModel->where('usuario_id', $id)->countAllResults();

        return view('paciente/detalhes', [
            'paciente'             => $paciente,
            'historicoHumor'       => $historicoHumor,
            'dadosGrafico'         => $dadosGrafico,
            'historicoAlimentacao' => $historicoAlimentacao,
            'historicoDiario'      => $historicoDiario,
            'streak'               => $streak,
            'totalAlertas'         => $totalAlertas,
        ]);
    }
}