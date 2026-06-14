<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Se não está logado, redireciona para login
        if (! $session->has('usuario_id')) {
            return redirect()->to('/login')->with('erro', 'Faça login para continuar.');
        }

        // Verifica o role se foi passado como argumento
        if ($arguments) {
            $roleExigido = $arguments[0];
            if ($session->get('role') !== $roleExigido) {
                // Redireciona para o lugar certo conforme o role real
                if ($session->get('role') === 'profissional') {
                    return redirect()->to('/dashboard');
                }
                return redirect()->to('/painel');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}