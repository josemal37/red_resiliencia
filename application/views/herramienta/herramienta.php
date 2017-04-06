<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="herramienta">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu"); ?>

	<div class="contenido">

		<div class="container">

			<div class="text-center">

				<h2 class="titulo-herramienta"><?= $titulo ?></h2>

			</div>

			<hr>

			<?php if ($herramienta->video): ?>

				<div class="row">

					<div class="col-md-2"></div>

					<div class="col-md-8">

						<div class="embed-responsive embed-responsive-16by9">

							<iframe width="560" height="315" align="middle" src="https://www.youtube.com/embed/<?= youtube_id_from_url($herramienta->video) ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

						</div>

					</div>

					<div class="col-md-2"></div>

				</div>

			<?php else: ?>

				<img src="<?= base_url($path_herramientas . $herramienta->imagen) ?>" class="img-responsive img-center imagen">

			<?php endif; ?>

			<?php if (isset($herramienta->autores) && $herramienta->autores): ?>

				<h3 class="subtitulo">Autores</h3>

				<p><?= listar_array_de_stdclass($herramienta->autores, "nombre_completo", ", ") ?></p>

			<?php endif; ?>

			<?php if (isset($herramienta->instituciones) && $herramienta->instituciones): ?>

				<h3 class="subtitulo">Instituciones</h3>

				<p><?= listar_array_de_stdclass($herramienta->instituciones, "nombre", ", ") ?></p>

			<?php endif; ?>

			<?php if ($herramienta->descripcion): ?>

				<h3 class="subtitulo">Descripción</h3>

				<p><?= $herramienta->descripcion ?></p>

			<?php endif; ?>

			<?php if ($herramienta->url): ?>

				<h3 class="subtitulo">Enlace</h3>

				<a href="<?= $herramienta->url ?>">Ir a la página de la herramienta</a>

			<?php endif; ?>

			<?php if (isset($herramienta->categorias) && $herramienta->categorias): ?>

				<div class="text-right">

					<p><label class="subtitulo">Categorías:</label> <?= listar_array_de_stdclass($herramienta->categorias, "nombre", ", ") ?></p>

				</div>

			<?php endif; ?>

		</div>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>