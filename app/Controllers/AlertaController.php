<?php

namespace App\Controllers;

use App\Models\AlertaModel;

class AlertaController extends BaseController
{
    public function index()
    {
        return view('alerta/panico');
    }

    public function salvar()
    {
        $usuarioId = session()->get('usuario_id');

        $dados = [
            'usuario_id' => $usuarioId,
            'tipo'       => 'panico',
            'visualizado' => 0,
        ];

        $model = new AlertaModel();
        $model->insert($dados);

        return redirect()->to('/panico/ok');
    }

    public function confirmacao()
    {
        return view('alerta/confirmacao');
    }

    public function marcarVisto(int $id)
    {
        $model = new AlertaModel();
        $model->update($id, ['visualizado' => 1]);

        return redirect()->to('/dashboard')
            ->with('sucesso', 'Alerta marcado como visto.');
    }
}