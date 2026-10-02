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

        $this->verificaStreak();

        $data = [];
        $data['usuario'] = $usuario;
        $data['gamificacao'] = $this->gamificacaoService->getGamificacao($usuario->getId());

        $this->view('dashboard/dashboard', $data);
    }

    public function verificaStreak(){

    
        //pega a data de hoje
        //se 
            //a data da ultima interacao for igual a data de atual: ja contabilzou a streak

        //senao

            //verfica se a data de hoje eh igual a data da ultima interacao + 1
            
            // se verdadadeiro: atualiza a data da ultima iteracao e incremeta a streak
            // se falso: zera a streak e atualiza a data
        if ($usuarioComum->getUltimoAcesso() === $ontem) {

        $usuarioComum->setStreakAtual($usuarioComum->getStreakAtual() + 1);

        } else {
            $usuarioComum->setStreakAtual(1); // reinicia contando hoje como dia 1
        }
    }

    
}
