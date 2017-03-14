<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="titulo text-center">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<div>

		<?php $this->load->view("base/busqueda", array("fuente" => "articulo", "criterio" => $criterio)); ?>

	</div>

	<?php if ($articulos): ?>

		<?php foreach ($articulos as $articulo): ?>

			<div class="row contenido-pagina">

				<div class="col-md-3">

					<img src="<?= base_url($path_articulos . $articulo->imagen) ?>" class="img-responsive">

				</div>

				<div class="col-md-9">

					<h4><?= $articulo->nombre ?></h4>

					<p class="text-justify"><?= $articulo->descripcion ?></p>

					<div class="row">

						<?php if ($articulo->autores): ?>

							<div class="col-md-4">

								<h4>Autores</h4>

								<ul>

									<?php foreach ($articulo->autores as $autor): ?>

										<li><?= $autor->nombre_completo ?></li>

									<?php endforeach; ?>

								</ul>

							</div>

						<?php endif; ?>

						<?php if ($articulo->categorias): ?>

							<div class="col-md-4">

								<h4>Categorias</h4>

								<ul>

									<?php foreach ($articulo->categorias as $categoria): ?>

										<li><?= $categoria->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							</div>

						<?php endif; ?>

						<?php if ($articulo->instituciones): ?>

							<div class="col-md-4">

								<h4>Instituciones</h4>

								<ul>

									<?php foreach ($articulo->instituciones as $institucion): ?>

										<li><?= $institucion->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							</div>

						<?php endif; ?>

					</div>

					<a href="<?= base_url("articulo/ver_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Ver</a>

					<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

						<a href="<?= base_url("articulo/modificar_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>

						<a href="<?= base_url("articulo/eliminar_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>

					<?php endif; ?>

				</div>

			</div>

		<?php endforeach; ?>

		<?php if (!$criterio): ?>

			<div class="text-center">

				<ul class="pagination">

					<?php for ($i = 1; $i <= $nro_paginas; $i ++): ?>

						<li <?php if ($nro_pagina == $i): ?>class="active"<?php endif; ?>><a href="<?= base_url("articulo/articulos/" . $i) ?>"><?= $i ?></a></li>

					<?php endfor; ?>

				</ul>

			</div>

		<?php endif; ?>

	<?php else: ?>

		<div class="contenido">

			<p>No se registraron articulos.</p>

		</div>

	<?php endif; ?>

	<?php if ($this->session->flashdata("error")): ?><p><?= $this->session->flashdata("error") ?></p><?php endif; ?>

	<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

		<a href="<?= base_url("articulo/registrar_articulo") ?>" class="btn btn-default btn-resiliencia">Registrar articulo</a>

	<?php endif; ?>

</div>

<?php $this->load->view("base/footer"); ?>