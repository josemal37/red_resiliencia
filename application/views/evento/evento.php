<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="evento">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu"); ?>

	<div class="contenido">

		<div class="container text-center">

			<h2 class="titulo-evento"><?= $titulo ?></h2>

			<hr>

			<img src="<?= base_url($path_evento . $evento->imagen) ?>" class="img-responsive img-center img-evento">

			<hr>

			<div class="row">

				<div class="col-md-4 text-right">

					<h3 class="subtitulo">Nombre</h3>

					<p><?= $evento->nombre ?></p>

					<?php if ($evento->direccion): ?>

						<h3 class="subtitulo">Lugar</h3>

						<?= $evento->direccion ?><?php if ($evento->ciudad): ?>, <?= $evento->ciudad->nombre ?><?php endif; ?><?php if ($evento->pais): ?>, <?= $evento->pais->nombre ?><?php endif; ?>

					<?php endif; ?>

					<?php if ($evento->fecha_inicio && $evento->fecha_fin): ?>

						<h3 class="subtitulo">Fecha</h3>

						<p>De <span class="fecha"><?= $evento->fecha_inicio ?></span> a <?= $evento->fecha_fin ?></p>

					<?php endif; ?>

					<?php if ($evento->url): ?>

						<h3 class="subtitulo">Sitio web</h3>

						<a href="<?= $evento->url ?>">Ir al sitio web</a>

					<?php endif; ?>

					<?php if ($evento->instituciones): ?>

						<h3 class="subtitulo">Instituciones encargadas</h3>

						<p><?= listar_array_de_stdclass($evento->instituciones, "nombre", ", ") ?></p>

					<?php endif; ?>

					<?php if ($evento->categorias): ?>

						<h3 class="subtitulo">Categorias</h3>

						<p><?= listar_array_de_stdclass($evento->categorias, "nombre", ", ") ?></p>

					<?php endif; ?>

				</div>

				<div class="col-md-8">

					<?php if ($evento->descripcion): ?>

						<h3 class="subtitulo">Descripción</h3>

						<p class="text-justify"><?= $evento->descripcion ?></p>

					<?php endif; ?>

				</div>

			</div>
			
			<?php $this->load->view("base/social", array("item" => $evento)); ?>

		</div>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>