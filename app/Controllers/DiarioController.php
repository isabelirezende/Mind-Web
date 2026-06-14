<?php

namespace App\Controllers;

use App\Models\DiarioModel;

class DiarioController extends BaseController
{
    public function index()
    {
        return view('diario/form');
    }

    public function salvar()
    {
        $usuarioId = session()->get('usuario_id');

        $dados = [
            'usuario_id' => $usuarioId,
            'conteudo'   => $this->request->getPost('conteudo'),
        ];

        $model = new DiarioModel();

        if (! $model->insert($dados)) {
            return redirect()->back()
                ->with('erro', 'Escreva algo antes de salvar.')
                ->withInput();
        }

        return redirect()->to('/painel')
            ->with('sucesso', 'Sua entrada foi salva no diário.');
    }
}