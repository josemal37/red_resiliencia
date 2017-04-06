<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="contenido">

	<?php if ($herramientas): ?>

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

					<?php foreach ($herramientas as $herramienta): ?>

						<div class="col-md-<?= $n_col_md ?> col-sm-<?= $n_col_sm ?> text-center">

							<div class="item">

								<a href="<?= base_url("herramienta/ver_herramienta/" . $herramienta->id) ?>">

									<img src="<?= base_url($path_herramientas . $herramienta->imagen) ?>" class="img-responsive img-center">

								</a>

								<label class="nombre"><?= $herramienta->nombre ?></label>

								<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

									<div>

										<a href="<?= base_url("herramienta/ver_herramienta/" . $herramienta->id) ?>" class="btn btn-default btn-xs">Ver</a>

										<a href="<?= base_url("herramienta/modificar_herramienta/" . $herramienta->id) ?>" class="btn btn-default btn-xs">Modificar</a>

										<a href="<?= base_url("herramienta/eliminar_herramienta/" . $herramienta->id) ?>" class="btn btn-default btn-xs">Eliminar</a>

									</div>

								<?php endif; ?>

							</div>

						</div>

						<?php if ($i % $n_items_md == 0 || $i % $n_items_sm == 0): ?>

							<div class="clearfix <?php if ($i % $n_items_md == 0): ?>visible-md<?php endif; ?> <?php if ($i % $n_items_sm == 0): ?>visible-sm<?php endif; ?>"></div>

						<?php endif; ?>

						<?php $i += 1; ?>

					<?php endforeach; ?>

				</div>

			</div>

		</div>

	<?php else: ?>

		<div class="container-fluid">

			<p>No se registraron herramientas.</p>

		</div>

	<?php endif; ?>

	<div class="acciones">

		<a href="<?= base_url("herramienta/registrar_herramienta") ?>" class="btn btn-default">Registrar herramienta</a>

	</div>

</div>