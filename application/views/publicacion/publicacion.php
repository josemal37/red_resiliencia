<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="publicacion">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu") ?>

	<div id="publicacion" class="contenido">

		<div class="container">

			<div class="text-center">

				<h2 class="titulo-publicacion"><?= $publicacion->nombre ?></h2>

			</div>

			<hr>

			<div class="row">

				<div class="col-md-6">

					<img src="<?= base_url($path_publicacion . $publicacion->imagen) ?>" class="img-responsive img-center imagen">

				</div>

				<div class="col-md-6">

					<h3 class="subtitulo">Autor(es)</h3>

					<?php if ($publicacion->autores): ?>

						<p class="text-justify lead"><?= listar_array_de_stdclass($publicacion->autores, "nombre_completo", ", ") ?></p>

					<?php else: ?>

						<p class="text-justify lead">No se registraron autores para esta publicación.</p>

					<?php endif; ?>

					<h3 class="subtitulo">Institución(es)</h3>

					<?php if ($publicacion->instituciones): ?>

						<p class="text-justify lead"><?= listar_array_de_stdclass($publicacion->instituciones, "nombre", ", ") ?></p>

					<?php else: ?>

						<p class="text-justify lead">No se registraron instituciones para esta publicación.</p>

					<?php endif; ?>

					<h3 class="subtitulo">Resumen</h3>

					<?php if ($publicacion->descripcion): ?>

						<p class="text-justify lead"><?= $publicacion->descripcion ?></p>

					<?php else: ?>

						<p class="text-justify lead">Esta publicación no tiene registrado un resumen.</p>

					<?php endif; ?>

					<?php if ($publicacion->modulos): ?>

						<h3 class="subtitulo">Contenido</h3>

						<div class="panel-group" id="contenido_publicacion">

							<?php $i = 1; ?>

							<?php foreach ($publicacion->modulos as $modulo): ?>

								<div class="panel panel-default">

									<div class="panel-heading">

										<h3 class="panel-title">

											<a data-toggle="collapse" data-parent="#contenido_publicacion" href="#collapse<?= $i ?>"><?= $i . ". " . $modulo->nombre ?></a>

										</h3>

									</div>

									<div id="collapse<?= $i ?>" class="panel-collapse collapse">

										<div class="panel-body">

											<?php if ($modulo->descripcion): ?>

												<p class="text-justify"><?= $modulo->descripcion ?></p>

											<?php else: ?>

												<p class="text-justify">Este módulo no tiene descripción.</p>

											<?php endif; ?>

										</div>

									</div>

								</div>

								<?php $i += 1; ?>

							<?php endforeach; ?>

						</div>

					<?php endif; ?>

					<?php if ($publicacion->url): ?>

						<h3 class="subtitulo">Documento</h3>

						<a href="<?= base_url($path_publicacion . $publicacion->url) ?>">Descargar</a>

					<?php endif; ?>

				</div>

			</div>

			<?php $this->load->view("base/social", array("item" => $publicacion)); ?>

		</div>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>