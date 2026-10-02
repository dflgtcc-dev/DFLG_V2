<?php

namespace app\services;

use app\repositories\UsuarioComumRepository;
use DateTimeImmutable;

class GamificacaoService
{
    private UsuarioComumRepository $repository;

    public function __construct()
    {
        $this->repository = new UsuarioComumRepository();
    }

    public function adicionarPontos(int $usuarioId, int $pontos = 10): bool
    {
        $usuarioComum = $this->repository->getPorUsuarioId($usuarioId);

        if (!$usuarioComum) {
            return false;
        }

        $hoje = (new DateTimeImmutable())->format('Y-m-d');

        if ($usuarioComum->getDataUltimoXp() === $hoje) {
            return false;
        }

        $usuarioComum->setXpTotal($usuarioComum->getXpTotal() + $pontos);
        $usuarioComum->setNivel($this->calcularNivel($usuarioComum->getXpTotal())); 
        $usuarioComum->setDataUltimoXp($hoje);

        return $this->repository->atualizarXp($usuarioComum);
    }

    private function calcularNivel(int $xpTotal): int 
    {
        $nivel = 1;
        $xpRestante = $xpTotal;

        while ($xpRestante >= $nivel * 100) {
            $xpRestante -= $nivel * 100;
            $nivel++;
        }

        return $nivel;
    }

    public function getGamificacao(int $usuarioId)
    {
        return $this->repository->getPorUsuarioId($usuarioId);
    }

    public function verificarEAtualizarStreak(int $usuarioId): void
{
    $usuarioComum = $this->repository->getPorUsuarioId($usuarioId);

    if (!$usuarioComum) {
        return;
    }

    $hoje = (new DateTimeImmutable())->format('Y-m-d');
    $ontem = (new DateTimeImmutable('-1 day'))->format('Y-m-d');

    if ($usuarioComum->getUltimoAcesso() === $hoje) {
        return; // já processado hoje
    }

    if ($usuarioComum->getUltimoAcesso() === $ontem) {
        $usuarioComum->setStreakAtual($usuarioComum->getStreakAtual() + 1);
    } else {
        $usuarioComum->setStreakAtual(1); // quebrou a sequência, recomeça
    }

    if ($usuarioComum->getStreakAtual() > $usuarioComum->getMaiorStreak()) {
        $usuarioComum->setMaiorStreak($usuarioComum->getStreakAtual());
    }

    $usuarioComum->setUltimoAcesso($hoje);
    $this->repository->atualizarStreak($usuarioComum);

    $this->adicionarPontos($usuarioId, 5); // XP do acesso diário, conforme Quadro 5
}
}