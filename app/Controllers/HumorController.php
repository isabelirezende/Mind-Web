<?php

namespace App\Controllers;

use App\Models\HumorModel;

class HumorController extends BaseController
{
    public function index()
    {
        $usuarioId  = session()->get('usuario_id');
        $humorModel = new HumorModel();

        $historico = $humorModel->ultimosRegistros($usuarioId, 7);
        $dadosGrafico = $humorModel->dadosParaGrafico($usuarioId, 14);

        return view('humor/form', [
            'historico' => $historico,
            'dadosGrafico' => $dadosGrafico,
        ]);
    }

    public function salvar()
    {
        $usuarioId = session()->get('usuario_id');

        $dados = [
            'usuario_id' => $usuarioId,
            'nivel'      => $this->request->getPost('nivel'),
            'observacao' => $this->request->getPost('observacao'),
        ];

        $model = new HumorModel();

        if (! $model->insert($dados)) {
            return redirect()->back()
                ->with('erro', 'Selecione um nível de humor antes de salvar.')
                ->withInput();
        }

        return redirect()->to('/painel')
            ->with('sucesso', 'Humor registrado! Obrigado por compartilhar como está se sentindo.');
    }
}