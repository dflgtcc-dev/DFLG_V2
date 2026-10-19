<?php

namespace app\repositories;

use app\database\ConnectionFactory;
use app\models\Usuario;
use PDO;

class UsuarioRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionFactory::getConnection();
    }

    public function saveUsuario(Usuario $usuario): bool
    {
        $sql = "INSERT INTO usuarios (nome, nickname, email, senha, data_nascimento, perfil) " .
            "VALUES (:nome, :nickname, :email, :senha, :dataNascimento, :perfil)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nome', $usuario->getNome());
        $stmt->bindValue(':nickname', $usuario->getNickname());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':senha', password_hash($usuario->getSenha(), PASSWORD_BCRYPT));
        $stmt->bindValue(':dataNascimento', $usuario->getDataNascimento());
        $stmt->bindValue(':perfil', $usuario->getPerfil());

        return $stmt->execute();
    }

    public function getUsuarioById(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $usuario = $stmt->fetch();

        if ($usuario == null) {
            return false;
        }

        return Usuario::arrayParaObjeto($usuario);
    }

    public function getUsuarioByEmail(string $email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch();

        if ($usuario == null) {
            return false;
        }

        return Usuario::arrayParaObjeto($usuario);
    }

    public function getUsuarioByNickname(string $nickname)
    {
        $sql = "SELECT * FROM usuarios WHERE nickname = :nickname";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nickname', $nickname);
        $stmt->execute();
        $usuario = $stmt->fetch();

        if ($usuario == null) {
            return false;
        }

        return Usuario::arrayParaObjeto($usuario);
    }

    public function updateUsuario(Usuario $usuario): bool
    {
        $sql = "UPDATE usuarios SET nome = :nome, nickname = :nickname, email = :email, " .
            "data_nascimento = :dataNascimento WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nome', $usuario->getNome());
        $stmt->bindValue(':nickname', $usuario->getNickname());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':dataNascimento', $usuario->getDataNascimento());
        $stmt->bindValue(':id', $usuario->getId());

        return $stmt->execute();
    }

    public function updateFoto(int $id, ?string $foto): bool
    {
        $sql = "UPDATE usuarios SET foto = :foto WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':foto', $foto);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}