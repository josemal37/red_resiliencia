<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="contenido">

	<?php if ($articulos): ?>

		<div class="items">

			<div class="container-fluid">

				<?php foreach ($articulos as $articulo): ?>

					<div class="item">

						<div class="row">

							<div class="col-md-3">

								<div style="background-image: url(<?= base_url($path_articulos . $articulo->imagen) ?>);" class="img-item"></div>

							</div>

							<div class="col-md-9">

								<h3 class="titulo-item"><?= $articulo->nombre ?></h3>

								<hr>

								<p class="text-justify"><?= $articulo->descripcion ?></p>

								<a href="<?= base_url("articulo/ver_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Ver</a>

								<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

									<a href="<?= base_url("articulo/modificar_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>

									<a href="<?= base_url("articulo/eliminar_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>

								<?php endif; ?>

							</div>

						</div>

					</div>

				<?php endforeach; ?>

			</div>

		</div>

	<?php else: ?>

		<div class="container-fluid">

			<p>No se registraron articulos.</p>

		</div>

	<?php endif; ?>

	<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

		<div class="acciones">

			<a href="<?= base_url("articulo/registrar_articulo") ?>" class="btn btn-default btn-resiliencia">Registrar articulo</a>

		</div>

	<?php endif; ?>

</div>