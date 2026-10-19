<?php

namespace app\services;

use app\models\Usuario;
use app\repositories\UsuarioRepository;
use app\repositories\UsuarioComumRepository;
use DateTimeImmutable;

class UsuarioService
{
    private const IDADE_MINIMA = 16;

    private UsuarioRepository $repository;
    private UsuarioComumRepository $usuarioComumRepository;
    private array $erros = [];

    public function __construct()
    {
        $this->repository = new UsuarioRepository();
        $this->usuarioComumRepository = new UsuarioComumRepository();
    }

    public function cadastrar(Usuario $usuario): bool
    {
        if (!$this->validar($usuario)) {
            return false;
        }

        if (!$this->repository->saveUsuario($usuario)) {
            return false;
        }

        $usuarioCriado = $this->repository->getUsuarioByEmail($usuario->getEmail());
        $this->usuarioComumRepository->criarParaUsuario($usuarioCriado->getId());

        return true;
    }

    public function getUsuarioById(int $id)
    {
        return $this->repository->getUsuarioById($id);
    }

    public function updateUsuario(Usuario $usuario): bool
    {
        if (!$this->validar($usuario)) {
            return false;
        }

        return $this->repository->updateUsuario($usuario);
    }

    public function updateFoto(int $id, ?string $foto): bool
    {
        return $this->repository->updateFoto($id, $foto);
    }

    public function getErros(): array
    {
        return $this->erros;
    }

    private function validar(Usuario $usuario): bool
    {
        $this->erros = [];

        $nascimento = DateTimeImmutable::createFromFormat('Y-m-d', $usuario->getDataNascimento());

        if (!$nascimento) {
            $this->erros['dataNascimento'] = "Informe uma data de nascimento válida";
        } elseif ($nascimento > new DateTimeImmutable('today')) {
            $this->erros['dataNascimento'] = "A data de nascimento não pode ser no futuro";
        } elseif ($nascimento->diff(new DateTimeImmutable('today'))->y < self::IDADE_MINIMA) {
            $this->erros['dataNascimento'] = "É preciso ter pelo menos " . self::IDADE_MINIMA . " anos para se cadastrar";
        }

        $usuarioComEmail = $this->repository->getUsuarioByEmail($usuario->getEmail());

        // na edição, o e-mail do próprio usuário não conta como duplicado
        if ($usuarioComEmail && $usuarioComEmail->getId() !== $usuario->getId()) {
            $this->erros['email'] = "Este e-mail já está cadastrado";
        }

        $usuarioComNickname = $this->repository->getUsuarioByNickname($usuario->getNickname());

        if ($usuarioComNickname && $usuarioComNickname->getId() !== $usuario->getId()) {
            $this->erros['nickname'] = "Este nickname já está em uso";
        }

        return empty($this->erros);
    }
}