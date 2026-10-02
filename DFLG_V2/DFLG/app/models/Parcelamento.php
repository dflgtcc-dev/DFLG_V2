<?php

namespace app\models;

class Parcelamento
{
    private int $id;
    private int $usuarioId;
    private ?int $categoriaId;
    private string $descricao;
    private float $valorTotal;
    private int $quantidadeParcelas;
    private int $parcelasPagas;
    private string $dataPrimeiraParcela;
    private ?string $nomeCategoria;

    public function __construct(
        int $id,
        int $usuarioId,
        ?int $categoriaId,
        string $descricao,
        float $valorTotal,
        int $quantidadeParcelas,
        int $parcelasPagas = 0,
        string $dataPrimeiraParcela = '',
        ?string $nomeCategoria = null
    ) {
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->categoriaId = $categoriaId;
        $this->descricao = $descricao;
        $this->valorTotal = $valorTotal;
        $this->quantidadeParcelas = $quantidadeParcelas;
        $this->parcelasPagas = $parcelasPagas;
        $this->dataPrimeiraParcela = $dataPrimeiraParcela;
        $this->nomeCategoria = $nomeCategoria;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    public function getCategoriaId(): ?int
    {
        return $this->categoriaId;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getValorTotal(): float
    {
        return $this->valorTotal;
    }

    public function getQuantidadeParcelas(): int
    {
        return $this->quantidadeParcelas;
    }

    public function getParcelasPagas(): int
    {
        return $this->parcelasPagas;
    }

    public function getDataPrimeiraParcela(): string
    {
        return $this->dataPrimeiraParcela;
    }

    public function getNomeCategoria(): ?string
    {
        return $this->nomeCategoria;
    }

    public function getValorParcela(): float
    {
        if ($this->quantidadeParcelas <= 0) {
            return 0.0;
        }

        return round($this->valorTotal / $this->quantidadeParcelas, 2);
    }

    public function getValorRestante(): float
    {
        $restantes = $this->quantidadeParcelas - $this->parcelasPagas;

        return round($this->getValorParcela() * $restantes, 2);
    }

    // percentual de parcelas já quitadas, usado nas barras de progresso das views
    public function getProgresso(): float
    {
        if ($this->quantidadeParcelas <= 0) {
            return 0.0;
        }

        $progresso = ($this->parcelasPagas / $this->quantidadeParcelas) * 100;

        return $progresso > 100 ? 100.0 : round($progresso, 2);
    }

    public function eQuitado(): bool
    {
        return $this->parcelasPagas >= $this->quantidadeParcelas;
    }

    public function getDataProximaParcela(): ?string
    {
        if ($this->eQuitado()) {
            return null;
        }

        $data = new \DateTimeImmutable($this->dataPrimeiraParcela);

        return $data->modify("+{$this->parcelasPagas} months")->format('Y-m-d');
    }

    public static function arrayParaObjeto(array $parcelamento): self
    {
        return new self(
            $parcelamento['id'],
            $parcelamento['usuario_id'],
            $parcelamento['categoria_id'] !== null ? (int) $parcelamento['categoria_id'] : null,
            $parcelamento['descricao'],
            (float) $parcelamento['valor_total'],
            (int) $parcelamento['quantidade_parcelas'],
            (int) $parcelamento['parcelas_pagas'],
            $parcelamento['data_primeira_parcela'],
            $parcelamento['nome_categoria'] ?? null
        );
    }
}
