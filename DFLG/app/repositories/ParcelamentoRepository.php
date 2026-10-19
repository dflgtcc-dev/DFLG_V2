<?php

namespace app\repositories;

use app\database\ConnectionFactory;
use app\models\Parcelamento;
use PDO;

class ParcelamentoRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionFactory::getConnection();
    }

    public function getParcelamentosPorUsuario(int $usuarioId): array
    {
        $sql = "SELECT p.*, c.nome AS nome_categoria FROM parcelamentos p " .
            "LEFT JOIN categorias c ON c.id = p.categoria_id " .
            "WHERE p.usuario_id = :usuarioId ORDER BY p.data_primeira_parcela DESC, p.id DESC";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':usuarioId', $usuarioId);
        $stmt->execute();

        $parcelamentos = [];

        foreach ($stmt->fetchAll() as $parcelamento) {
            $parcelamentos[] = Parcelamento::arrayParaObjeto($parcelamento);
        }

        return $parcelamentos;
    }

    // sempre filtra pelo dono, pra um usuário não acessar o parcelamento de outro
    public function getParcelamento(int $id, int $usuarioId)
    {
        $sql = "SELECT p.*, c.nome AS nome_categoria FROM parcelamentos p " .
            "LEFT JOIN categorias c ON c.id = p.categoria_id " .
            "WHERE p.id = :id AND p.usuario_id = :usuarioId";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':usuarioId', $usuarioId);
        $stmt->execute();

        $parcelamento = $stmt->fetch();

        if ($parcelamento == null) {
            return false;
        }

        return Parcelamento::arrayParaObjeto($parcelamento);
    }

    public function saveParcelamento(Parcelamento $parcelamento): bool
    {
        $sql = "INSERT INTO parcelamentos (usuario_id, categoria_id, descricao, valor_total, quantidade_parcelas, parcelas_pagas, data_primeira_parcela) " .
            "VALUES (:usuarioId, :categoriaId, :descricao, :valorTotal, :quantidadeParcelas, :parcelasPagas, :dataPrimeiraParcela)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':usuarioId', $parcelamento->getUsuarioId());
        $stmt->bindValue(':categoriaId', $parcelamento->getCategoriaId());
        $stmt->bindValue(':descricao', $parcelamento->getDescricao());
        $stmt->bindValue(':valorTotal', $parcelamento->getValorTotal());
        $stmt->bindValue(':quantidadeParcelas', $parcelamento->getQuantidadeParcelas());
        $stmt->bindValue(':parcelasPagas', $parcelamento->getParcelasPagas());
        $stmt->bindValue(':dataPrimeiraParcela', $parcelamento->getDataPrimeiraParcela());

        return $stmt->execute();
    }

    public function updateParcelamento(Parcelamento $parcelamento): bool
    {
        $sql = "UPDATE parcelamentos SET categoria_id = :categoriaId, descricao = :descricao, valor_total = :valorTotal, " .
            "quantidade_parcelas = :quantidadeParcelas, parcelas_pagas = :parcelasPagas, data_primeira_parcela = :dataPrimeiraParcela " .
            "WHERE id = :id AND usuario_id = :usuarioId";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':categoriaId', $parcelamento->getCategoriaId());
        $stmt->bindValue(':descricao', $parcelamento->getDescricao());
        $stmt->bindValue(':valorTotal', $parcelamento->getValorTotal());
        $stmt->bindValue(':quantidadeParcelas', $parcelamento->getQuantidadeParcelas());
        $stmt->bindValue(':parcelasPagas', $parcelamento->getParcelasPagas());
        $stmt->bindValue(':dataPrimeiraParcela', $parcelamento->getDataPrimeiraParcela());
        $stmt->bindValue(':id', $parcelamento->getId());
        $stmt->bindValue(':usuarioId', $parcelamento->getUsuarioId());

        return $stmt->execute();
    }

    public function deleteParcelamento(int $id, int $usuarioId): bool
    {
        $sql = "DELETE FROM parcelamentos WHERE id = :id AND usuario_id = :usuarioId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':usuarioId', $usuarioId);

        return $stmt->execute();
    }
}
