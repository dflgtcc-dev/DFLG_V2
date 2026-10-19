<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Calculadora de investimentos • DFLG</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= URL_BASE ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>
	<?php require __DIR__ . '/../partials/header.php'; ?>

	<main class="container pb-5">
		<div class="row g-4 align-items-start">
			<section class="col-lg-8">
				<div class="card shadow-sm">
					<div class="card-body p-4">
						<h1 class="h3 mb-4">Que aplicação rende mais?</h1>

						<?php if (!empty($erros)): ?>
							<div class="alert alert-danger">
								<?php foreach ($erros as $erro): ?>
									<div><?= htmlspecialchars($erro) ?></div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<form method="post" action="<?= URL_BASE ?>/calculadora/calcular">
							<div class="row g-3">
								<div class="col-md-6">
									<label for="investimentoInicial" class="form-label">Investimento inicial</label>
									<input type="number" step="0.01" min="0" class="form-control" id="investimentoInicial" name="investimentoInicial" value="<?= htmlspecialchars($dados['investimentoInicial'] ?? '') ?>" required>
								</div>
								<div class="col-md-6">
									<label for="aporteMensal" class="form-label">Aporte mensal</label>
									<input type="number" step="0.01" min="0" class="form-control" id="aporteMensal" name="aporteMensal" value="<?= htmlspecialchars($dados['aporteMensal'] ?? '') ?>" required>
								</div>
								<div class="col-md-6">
									<label for="periodoMeses" class="form-label">Período em meses</label>
									<input type="number" min="1" class="form-control" id="periodoMeses" name="periodoMeses" value="<?= htmlspecialchars($dados['periodoMeses'] ?? '') ?>" required>
								</div>
								<div class="col-md-6">
									<label for="tipoInvestimento" class="form-label">Tipo de investimento</label>
									<select class="form-select" id="tipoInvestimento" name="tipoInvestimento" required>
										<option value="">Selecione uma opção</option>
										<?php foreach ($investimentos as $codigo => $investimento): ?>
											<option value="<?= htmlspecialchars($codigo) ?>" <?= ($dados['tipoInvestimento'] ?? '') === $codigo ? 'selected' : '' ?>>
												<?= htmlspecialchars($investimento['nome']) ?> (<?= number_format($investimento['taxa'], 2, ',', '.') ?>% a.a.)
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<button type="submit" class="btn btn-primary mt-4">Calcular rendimento</button>
						</form>

						<?php if (!empty($resultado)): ?>
							<div class="alert alert-info mt-4 mb-0">
								<strong><?= htmlspecialchars($resultado['tipoInvestimento']) ?></strong>
								com taxa estimada de <?= number_format($resultado['taxaAnual'], 2, ',', '.') ?>% ao ano.
							</div>
							<div class="row g-3 mt-4">
								<div class="col-md-4">
									<div class="card h-100 bg-light border-0">
										<div class="card-body">
											<small class="text-muted">Total investido</small>
											<h2 class="h5 mt-2">R$ <?= number_format($resultado['totalInvestido'], 2, ',', '.') ?></h2>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card h-100 bg-light border-0">
										<div class="card-body">
											<small class="text-muted">Rendimento</small>
											<h2 class="h5 mt-2 text-success">R$ <?= number_format($resultado['rendimento'], 2, ',', '.') ?></h2>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card h-100 bg-light border-0">
										<div class="card-body">
											<small class="text-muted">Montante final</small>
											<h2 class="h5 mt-2">R$ <?= number_format($resultado['montanteFinal'], 2, ',', '.') ?></h2>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>

			<aside class="col-lg-4">
				<div class="card border-0 bg-light h-100">
					<div class="card-body p-4">
						<h2 class="h4">Calculadora de renda fixa</h2>
						<p class="text-muted mb-0">Simule quanto seu dinheiro pode render usando uma taxa anual e aportes mensais.</p>
					</div>
				</div>
			</aside>
		</div>
	</main>
</body>

</html>
