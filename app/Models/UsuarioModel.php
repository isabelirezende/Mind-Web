<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table         = 'usuarios';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nome', 'email', 'senha', 'role'];

    protected $useTimestamps  = false;

    protected $validationRules = [
        'email' => 'required|valid_email',
        'senha' => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'email' => ['required' => 'E-mail obrigatório.', 'valid_email' => 'E-mail inválido.'],
        'senha' => ['required' => 'Senha obrigatória.', 'min_length' => 'Senha deve ter no mínimo 6 caracteres.'],
    ];

    /**
     * Busca usuário por e-mail e valida a senha.
     * Retorna o array do usuário ou false.
     */
    public function autenticar(string $email, string $senha): array|false
    {
        $usuario = $this->where('email', $email)->first();

        if (! $usuario) {
            return false;
        }

        if (! password_verify($senha, $usuario['senha'])) {
            return false;
        }

        return $usuario;
    }

    public function listarPacientes(): array
    {
        return $this->where('role', 'paciente')
                    ->orderBy('nome', 'ASC')
                    ->findAll();
    }
}