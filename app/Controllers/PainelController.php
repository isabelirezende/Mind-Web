<?php

namespace App\Controllers;

use App\Models\HumorModel;

class PainelController extends BaseController
{
    public function index()
    {
        $usuarioId  = session()->get('usuario_id');
        $humorModel = new HumorModel();

        $ultimoHumor = $humorModel->where('usuario_id', $usuarioId)
                                  ->orderBy('criado_em', 'DESC')
                                  ->first();

        return view('painel/index', [
            'ultimoHumor' => $ultimoHumor,
        ]);
    }
}