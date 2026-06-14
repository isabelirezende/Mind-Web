<?php

namespace App\Controllers;

use App\Models\AlimentacaoModel;

class AlimentacaoController extends BaseController
{
    public function index()
    {
        $usuarioId = session()->get('usuario_id');
        $model     = new AlimentacaoModel();

        $ultimoRegistro = $model->ultimoRegistro($usuarioId);

        return view('alimentacao/form', ['ultimoRegistro' => $ultimoRegistro]);
    }

    public function salvar()
    {
        $usuarioId = session()->get('usuario_id');

        $dados = [
            'usuario_id' => $usuarioId,
            'cafe_manha' => $this->request->getPost('cafe_manha'),
            'almoco'     => $this->request->getPost('almoco'),
            'jantar'     => $this->request->getPost('jantar'),
            'lanches'    => $this->request->getPost('lanches'),
        ];

        $model = new AlimentacaoModel();
        $model->insert($dados);

        return redirect()->to('/painel')
            ->with('sucesso', 'Alimentação registrada com sucesso!');
    }
}