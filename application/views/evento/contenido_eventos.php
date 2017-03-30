<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="contenido">

	<?php if ($eventos): ?>

		<div class="items">

			<div class="container-fluid">

				<div class="row">

					<?php
					$i = 1;
					$n_col = 12; //numero de columnas bootstrap
					$n_items_md = 4; //numero de items por fila md
					$n_items_sm = 2; //numero de items por fila sm
					$n_col_md = $n_col / $n_items_md; //numero de columnas que ocupa cada item md
					$n_col_sm = $n_col / $n_items_sm; //numero de columnas que ocupa cada item sm
					?>

					<?php foreach ($eventos as $evento): ?>

						<div class="col-md-<?= $n_col_md ?> col-sm-<?= $n_col_sm ?>">

							<div class="item">

								<a href="<?= base_url("evento/ver_evento/" . $evento->id) ?>">

									<div style="background-image: url('<?= base_url($path_evento . $evento->imagen) ?>');" class="img-item"></div>

								</a>

								<div class="text-center">

									<h4 class="titulo-item"><?= $evento->nombre ?></h4>

									<p><?= $evento->fecha_inicio ?> - <?= $evento->fecha_fin ?></p>

									<p><?= $evento->ciudad->nombre . ", " . $evento->pais->nombre ?></p>

								</div>

								<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

									<div class="text-center">

										<a href="<?= base_url("evento/ver_evento/" . $evento->id) ?>" class="btn btn-default btn-xs">Ver</a>

										<a href="<?= base_url("evento/modificar_evento/" . $evento->id) ?>" class="btn btn-default btn-xs">Modificar</a>

										<a href="<?= base_url("evento/eliminar_evento/" . $evento->id) ?>" class="btn btn-default btn-xs">Eliminar</a>

									</div>

								<?php endif; ?>

							</div>

						</div>

					<?php endforeach; ?>

				</div>

			</div>

		</div>

	<?php else: ?>

		<div class="container-fluid">

			<p>No se registraron eventos.</p>

		</div>

	<?php endif; ?>

	<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

		<div class="acciones">

			<a href="<?= base_url("evento/registrar_evento") ?>" class="btn btn-default btn-resiliencia">Registrar evento</a>

		</div>

	<?php endif; ?>

</div>