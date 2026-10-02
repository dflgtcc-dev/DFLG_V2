<?php

namespace app\controllers;

use app\core\Controller;
use app\services\CalculadoraService;

class CalculadoraController extends Controller
{
    private CalculadoraService $service;

    public function __construct()
    {
        $this->service = new CalculadoraService();
    }

    public function index()
    {
        $this->view('calculadora/Calculadora', [
            'investimentos' => $this->service->getInvestimentos(),
        ]);
    }

    public function calcular()
    {
        $dados = [
            'investimentoInicial' => $_POST['investimentoInicial'] ?? '',
            'aporteMensal' => $_POST['aporteMensal'] ?? '',
            'periodoMeses' => $_POST['periodoMeses'] ?? '',
            'tipoInvestimento' => $_POST['tipoInvestimento'] ?? '',
        ];

        $resultado = $this->service->calcular($dados);

        if ($resultado === false) {
            $this->view('calculadora/Calculadora', [
                'dados' => $dados,
                'erros' => $this->service->getErros(),
                'investimentos' => $this->service->getInvestimentos(),
            ]);

            return;
        }

        $this->view('calculadora/Calculadora', [
            'dados' => $dados,
            'resultado' => $resultado,
            'investimentos' => $this->service->getInvestimentos(),
        ]);
    }
}