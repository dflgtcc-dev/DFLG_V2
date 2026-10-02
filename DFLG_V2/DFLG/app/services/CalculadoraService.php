<?php

namespace app\services;

class CalculadoraService
{
    private array $erros = [];

    public function getInvestimentos(): array
    {
        return [
            'cdb' => ['nome' => 'CDB', 'taxa' => 13.65],
            'tesouro_selic' => ['nome' => 'Tesouro Selic', 'taxa' => 13.65],
            'poupanca' => ['nome' => 'Poupança', 'taxa' => 8.29],
            'lci_lca' => ['nome' => 'LCI/LCA', 'taxa' => 11.60],
            'tesouro_prefixado' => ['nome' => 'Tesouro Prefixado', 'taxa' => 14.00],
            'fundo_di' => ['nome' => 'Fundo DI', 'taxa' => 13.40],
        ];
    }

    public function calcular(array $dados): array|false
    {
        $this->erros = [];

        $investimentoInicial = $this->numero($dados['investimentoInicial'] ?? '');
        $aporteMensal = $this->numero($dados['aporteMensal'] ?? '');
        $periodoMeses = filter_var($dados['periodoMeses'] ?? '', FILTER_VALIDATE_INT);
        $tipoInvestimento = $dados['tipoInvestimento'] ?? '';
        $investimentos = $this->getInvestimentos();
        $investimento = $investimentos[$tipoInvestimento] ?? null;
        $taxaAnual = $investimento['taxa'] ?? null;

        if ($investimentoInicial === null || $investimentoInicial < 0) {
            $this->erros['investimentoInicial'] = 'Informe um investimento inicial válido.';
        }

        if ($aporteMensal === null || $aporteMensal < 0) {
            $this->erros['aporteMensal'] = 'Informe um aporte mensal válido.';
        }

        if ($periodoMeses === false || $periodoMeses <= 0) {
            $this->erros['periodoMeses'] = 'O período deve ser maior que zero.';
        }

        if ($investimento === null) {
            $this->erros['tipoInvestimento'] = 'Selecione um tipo de investimento válido.';
        }

        if (!empty($this->erros)) {
            return false;
        }

        $taxaMensal = pow(1 + ($taxaAnual / 100), 1 / 12) - 1;
        $montanteInicial = $investimentoInicial * pow(1 + $taxaMensal, $periodoMeses);
        $montanteAportes = $taxaMensal > 0
            ? $aporteMensal * ((pow(1 + $taxaMensal, $periodoMeses) - 1) / $taxaMensal)
            : $aporteMensal * $periodoMeses;
        $montanteFinal = $montanteInicial + $montanteAportes;
        $totalInvestido = $investimentoInicial + ($aporteMensal * $periodoMeses);

        return [
            'tipoInvestimento' => $investimento['nome'],
            'taxaAnual' => $taxaAnual,
            'totalInvestido' => $totalInvestido,
            'rendimento' => $montanteFinal - $totalInvestido,
            'montanteFinal' => $montanteFinal,
        ];
    }

    public function getErros(): array
    {
        return $this->erros;
    }

    private function numero(mixed $valor): ?float
    {
        if ($valor === '' || !is_numeric($valor)) {
            return null;
        }

        return (float) $valor;
    }
}