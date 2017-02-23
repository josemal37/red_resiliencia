<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<header class=" header text-center">

	<h1><?= $titulo ?></h1>

</header>

<?php
$datos = array();
if (isset($articulos)) {
	$datos["articulos"] = TRUE;
} else {
	$datos["articulos"] = FALSE;
}
if (isset($publicaciones)) {
	$datos["publicaciones"] = TRUE;
} else {
	$datos["publicaciones"] = FALSE;
}
if (isset($eventos)) {
	$datos["eventos"] = TRUE;
} else {
	$datos["eventos"] = FALSE;
}
?>

<?php $this->load->view("base/menu", $datos); ?>

<?php if (isset($articulos)): ?>

	<!-- Articulos -->
	<section id="articulos" class="container">

		<h2>Artículos</h2>

		<?php if ($articulos): ?>

			<div class="row">

				<?php foreach ($articulos as $articulo): ?>

					<h3><?= $articulo->nombre ?></h3>

				<?php endforeach; ?>

			</div>

		<?php else: ?>

			<p>Sin artículos.</p>

		<?php endif; ?>

	</section>

<?php endif; ?>

<?php if (isset($publicaciones)): ?>

	<!-- Publicaciones -->
	<section id="publicaciones" class="container">

		<h2>Publicaciones</h2>

		<?php if ($publicaciones): ?>

			<div class="row">

				<?php foreach ($publicaciones as $publicacion): ?>

					<div class="col-md-4">

						<?php if ($publicacion->imagen != ""): ?>

							<img src="<?= base_url($path_publicaciones . $publicacion->imagen) ?>" alt="<?= $publicacion->nombre ?>" class="img-responsive">

						<?php endif; ?>

						<label><?= $publicacion->nombre ?></label>

					</div>

				<?php endforeach; ?>

				<div class="clearfix visible-md-block visible-lg-block"></div>
				
				<div>
					
					<a href="<?= base_url("publicacion/publicaciones")?>" class="btn btn-primary pull-right">Ver todas las publicaciones</a>
					
				</div>

			</div>

		<?php else: ?>

			<p>Sin publicaciones.</p>

		<?php endif; ?>

	</section>

<?php endif; ?>

<?php $this->load->view("base/footer"); ?>