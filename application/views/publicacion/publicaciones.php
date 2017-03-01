<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center header">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div id="publicaciones" class="container">

	<div class="container">

		<?php $this->load->view("base/busqueda", array("fuente" => "publicacion", "criterio" => $criterio)); ?>

	</div>

	<?php if ($publicaciones): ?>

		<?php foreach ($publicaciones as $publicacion): ?>

			<div class="row">

				<div class="col-md-3">

					<?php if ($publicacion->imagen != ""): ?>

						<img src="<?= base_url($path_publicaciones . $publicacion->imagen) ?>" alt="<?= $publicacion->nombre ?>" class="img-responsive">

					<?php endif; ?>

				</div>

				<div class="col-md-9">

					<h4><?= $publicacion->nombre ?></h4>

					<p class="text-justify"><?= $publicacion->descripcion ?></p>

					<?php if ($publicacion->modulos): ?>

						<h4>Modulos</h4>

						<ol>

							<?php foreach ($publicacion->modulos as $modulo): ?>

								<li><?= $modulo->nombre ?></li>

							<?php endforeach; ?>

						</ol>

					<?php endif; ?>

					<?php if ($publicacion->url != ""): ?>

						<h4>Documento</h4>

						<a href="<?= base_url($path_publicaciones . $publicacion->url) ?>">Descargar documento</a>

					<?php endif; ?>

					<div class="row">

						<?php if ($publicacion->autores): ?>

							<div class="col-md-4">

								<h4>Autores</h4>

								<ul>

									<?php foreach ($publicacion->autores as $autor): ?>

										<li><?= $autor->nombre_completo ?></li>

									<?php endforeach; ?>

								</ul>

							</div>

						<?php endif; ?>

						<?php if ($publicacion->categorias): ?>

							<div class="col-md-4">

								<h4>Categorias</h4>

								<ul>

									<?php foreach ($publicacion->categorias as $categoria): ?>

										<li><?= $categoria->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							</div>

						<?php endif; ?>

						<?php if ($publicacion->instituciones): ?>

							<div class="col-md-4">

								<h4>Instituciones</h4>

								<ul>

									<?php foreach ($publicacion->instituciones as $institucion): ?>

										<li><?= $institucion->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							</div>

						<?php endif; ?>

						<div class="clearfix visible-md-block visible-lg-block"></div>

					</div>
						
					<a href="<?= base_url("publicacion/ver_publicacion/" . $publicacion->id) ?>">Ver</a>

					<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

						<a href="<?= base_url("publicacion/modificar_publicacion/" . $publicacion->id) ?>">Modificar</a>

					<?php endif; ?>

					<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

						<a href="<?= base_url("publicacion/eliminar_publicacion/" . $publicacion->id) ?>">Eliminar</a>

					<?php endif; ?>

				</div>

				<div class="clearfix visible-md-block visible-lg-block"></div>

			</div>

		<?php endforeach; ?>

		<?php if (!$criterio): ?>

			<div class="text-center">

				<ul class="pagination">

					<?php for ($i = 1; $i <= $nro_paginas; $i ++): ?>

						<li <?php if ($nro_pagina == $i): ?>class="active"<?php endif; ?>><a href="<?= base_url("publicacion/publicaciones/" . $i) ?>"><?= $i ?></a></li>

					<?php endfor; ?>

				</ul>

			</div>

		<?php endif; ?>

	<?php else: ?>

		<p>No se registraron publicaciones.</p>

	<?php endif; ?>

	<?php if ($this->session->flashdata("error")): ?><p><?= $this->session->flashdata("error") ?></p><?php endif; ?>

	<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

		<a href="<?= base_url("publicacion/registrar_publicacion") ?>">Registrar publicación</a>

	<?php endif; ?>

</div>

<?php $this->load->view("base/footer"); ?>