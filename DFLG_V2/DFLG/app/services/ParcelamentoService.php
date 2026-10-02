<?php

namespace app\services;

use app\models\Parcelamento;
use app\repositories\ParcelamentoRepository;

class ParcelamentoService
{
    private ParcelamentoRepository $repository;
    private array $erros = [];

    public function __construct()
    {
        $this->repository = new ParcelamentoRepository();
    }

    public function getParcelamentos(int $usuarioId): array
    {
        return $this->repository->getParcelamentosPorUsuario($usuarioId);
    }

    public function getParcelamento(int $id, int $usuarioId)
    {
        return $this->repository->getParcelamento($id, $usuarioId);
    }

    public function saveParcelamento(Parcelamento $parcelamento): bool
    {
        if (!$this->validar($parcelamento)) {
            return false;
        }

        return $this->repository->saveParcelamento($parcelamento);
    }

    public function updateParcelamento(Parcelamento $parcelamento): bool
    {
        if (!$this->repository->getParcelamento($parcelamento->getId(), $parcelamento->getUsuarioId())) {
            $this->erros['parcelamento'] = "Parcelamento não encontrado";

            return false;
        }

        if (!$this->validar($parcelamento)) {
            return false;
        }

        return $this->repository->updateParcelamento($parcelamento);
    }

    public function deleteParcelamento(int $id, int $usuarioId): bool
    {
        return $this->repository->deleteParcelamento($id, $usuarioId);
    }

    public function getErros(): array
    {
        return $this->erros;
    }

    private function validar(Parcelamento $parcelamento): bool
    {
        $this->erros = [];

        if ($parcelamento->getValorTotal() <= 0) {
            $this->erros['valorTotal'] = "O valor total deve ser maior que zero";
        }

        if ($parcelamento->getQuantidadeParcelas() < 1) {
            $this->erros['quantidadeParcelas'] = "O parcelamento deve ter pelo menos uma parcela";
        }

        if ($parcelamento->getParcelasPagas() < 0) {
            $this->erros['parcelasPagas'] = "As parcelas pagas não podem ser negativas";
        } elseif ($parcelamento->getParcelasPagas() > $parcelamento->getQuantidadeParcelas()) {
            $this->erros['parcelasPagas'] = "As parcelas pagas não podem ultrapassar o total de parcelas";
        }

        if (!$parcelamento->getDataPrimeiraParcela()) {
            $this->erros['dataPrimeiraParcela'] = "Informe a data da primeira parcela";
        }

        return empty($this->erros);
    }
}
