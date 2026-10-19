<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Parcelamento • DFLG Investments</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS próprio -->
    <link href="<?= URL_BASE ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>

    <?php require __DIR__ . '/../partials/header.php'; ?>

    <div class="container pb-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Editar Parcelamento</h2>
            <a href="<?= URL_BASE ?>/parcelamentos" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <form action="<?= URL_BASE ?>/parcelamentos/atualizar" method="post">

                    <input type="hidden" name="id" value="<?= $parcelamento->getId() ?>">

                    <div class="row g-3">

                        <div class="col-md-8">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao"
                                value="<?= htmlspecialchars($parcelamento->getDescricao()) ?>">
                            <?php if (isset($erros['descricao'])): ?>
                                <div class="text-danger small"><?= $erros['descricao'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label for="categoriaId" class="form-label">Categoria</label>
                            <select class="form-select" id="categoriaId" name="categoriaId">
                                <option value="">Sem categoria</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria->getId() ?>" <?= $parcelamento->getCategoriaId() == $categoria->getId() ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($categoria->getNome()) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="valorTotal" class="form-label">Valor total (R$)</label>
                            <input type="number" step="0.01" min="0.01" class="form-control" id="valorTotal" name="valorTotal"
                                value="<?= $parcelamento->getValorTotal() ?>">
                            <?php if (isset($erros['valorTotal'])): ?>
                                <div class="text-danger small"><?= $erros['valorTotal'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-3">
                            <label for="quantidadeParcelas" class="form-label">Qtd. de parcelas</label>
                            <input type="number" min="1" step="1" class="form-control" id="quantidadeParcelas" name="quantidadeParcelas"
                                value="<?= $parcelamento->getQuantidadeParcelas() ?>">
                            <?php if (isset($erros['quantidadeParcelas'])): ?>
                                <div class="text-danger small"><?= $erros['quantidadeParcelas'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-3">
                            <label for="parcelasPagas" class="form-label">Parcelas já pagas</label>
                            <input type="number" min="0" step="1" class="form-control" id="parcelasPagas" name="parcelasPagas"
                                value="<?= $parcelamento->getParcelasPagas() ?>">
                            <?php if (isset($erros['parcelasPagas'])): ?>
                                <div class="text-danger small"><?= $erros['parcelasPagas'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-3">
                            <label for="dataPrimeiraParcela" class="form-label">Data da 1ª parcela</label>
                            <input type="date" class="form-control" id="dataPrimeiraParcela" name="dataPrimeiraParcela"
                                value="<?= htmlspecialchars($parcelamento->getDataPrimeiraParcela()) ?>">
                            <?php if (isset($erros['dataPrimeiraParcela'])): ?>
                                <div class="text-danger small"><?= $erros['dataPrimeiraParcela'] ?></div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle"></i> Atualizar
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
