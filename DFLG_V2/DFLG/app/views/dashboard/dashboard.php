<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard • DFLG Investments</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS próprio -->
    <link href="<?= URL_BASE ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>

    <?php require __DIR__ . '/../partials/header.php'; ?>

    <div class="container">
        <h4 class="mb-1">Olá, <?= htmlspecialchars($usuario->getNome()) ?></h4>
        <p class="text-muted">@<?= htmlspecialchars($usuario->getNickname()) ?></p>

        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted small mb-1">Nível</p>
                        <h3 class="mb-0"><?= $gamificacao ? $gamificacao->getNivel() : 1 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted small mb-1">XP Total</p>
                        <h3 class="mb-0"><?= $gamificacao ? $gamificacao->getXpTotal() : 0 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted small mb-1">Sequência atual</p>
                        <h3 class="mb-0"><?= $gamificacao ? $gamificacao->getStreakAtual() : 0 ?> dias</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <a href="<?= URL_BASE ?>/metas" class="text-decoration-none">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="mb-1"><i class="bi bi-bullseye me-2 text-primary"></i>Metas</h5>
                            <p class="text-muted small mb-0">Cadastre e acompanhe seus objetivos financeiros.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= URL_BASE ?>/transacoes" class="text-decoration-none">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="mb-1"><i class="bi bi-cash-stack me-2 text-success"></i>Finanças</h5>
                            <p class="text-muted small mb-0">Registre receitas e despesas e acompanhe seu saldo.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?= URL_BASE ?>/parcelamentos" class="text-decoration-none">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="mb-1"><i class="bi bi-credit-card-2-front me-2 text-danger"></i>Parcelamentos</h5>
                            <p class="text-muted small mb-0">Controle suas compras a prazo e o quanto falta pagar.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
