<?php

namespace app\controllers;

use app\core\Controller;
use app\services\GamificacaoService;

class DashboardController extends Controller
{
    private GamificacaoService $gamificacaoService;

    public function __construct()
    {
        $this->gamificacaoService = new GamificacaoService();
    }

    public function index()
    {
        
        $this->autenticacaoRequired();

        $usuario = $_SESSION['usuario_logado'];

        // RF 09 / RN 03: registra o acesso do dia e atualiza a sequência (streak)
        $this->gamificacaoService->verificarEAtualizarStreak($usuario->getId());

        $data = [];
        $data['usuario'] = $usuario;
        $data['gamificacao'] = $this->gamificacaoService->getGamificacao($usuario->getId());

        $this->view('dashboard/dashboard', $data);
    }
}