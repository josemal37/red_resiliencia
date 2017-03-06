<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center header">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<div class="row publicacion">

		<div class="col-md-4">

			<img src="<?= base_url($path_publicacion . $publicacion->imagen) ?>" class="img-responsive img-center">

		</div>

		<div class="col-md-8">

			<h4>Título</h4>

			<p class="text-justify"><?= $publicacion->nombre ?></p>

			<?php if ($publicacion->autores): ?>

				<h4>Autor(es)</h4>

				<p><?= listar_array_de_stdclass($publicacion->autores, "nombre_completo", ", ") ?></p>

			<?php endif; ?>

			<?php if ($publicacion->instituciones): ?>

				<h4>Institución(es)</h4>

				<p><?= listar_array_de_stdclass($publicacion->instituciones, "nombre", ", ") ?></p>

			<?php endif; ?>

			<?php if ($publicacion->descripcion): ?>

				<h4>Resumen</h4>

				<p class="text-justify"><?= $publicacion->descripcion ?></p>

			<?php endif; ?>

			<?php if ($publicacion->modulos): ?>

				<h4>Modulo(s)</h4>

				<ol>

					<?php foreach ($publicacion->modulos as $modulo): ?>

						<li><?= $modulo->nombre ?></li>

					<?php endforeach; ?>

				</ol>

			<?php endif; ?>

			<?php if ($publicacion->categorias): ?>

				<h4>Categoria(s)</h4>

				<p><?= listar_array_de_stdclass($publicacion->categorias, "nombre", ", ") ?></p>

			<?php endif; ?>

			<?php if ($publicacion->url): ?>

				<h4>Descargar</h4>

				<a href="<?= base_url($path_publicacion . $publicacion->url) ?>">Descargar documento</a>

			<?php endif; ?>

		</div>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>