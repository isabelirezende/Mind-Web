<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    public function index()
    {
        // Se já está logado, redireciona
        if (session()->has('usuario_id')) {
            return $this->redirecionarPorRole(session()->get('role'));
        }

        return view('auth/login');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        if (empty($email) || empty($senha)) {
            return redirect()->back()->with('erro', 'Preencha e-mail e senha.');
        }

        $model   = new UsuarioModel();
        $usuario = $model->autenticar($email, $senha);

        if (! $usuario) {
            return redirect()->back()->with('erro', 'E-mail ou senha incorretos.')->withInput();
        }

        // Salva na sessão
        session()->set([
            'usuario_id'   => $usuario['id'],
            'usuario_nome' => $usuario['nome'],
            'role'         => $usuario['role'],
            'logado'       => true,
        ]);

        return $this->redirecionarPorRole($usuario['role']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('sucesso', 'Você saiu com segurança.');
    }

    private function redirecionarPorRole(string $role)
    {
        return $role === 'profissional'
            ? redirect()->to('/dashboard')
            : redirect()->to('/painel');
    }
}