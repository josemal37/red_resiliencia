<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

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
if (isset($eventos)) {
	$datos["herramientas"] = TRUE;
} else {
	$datos["herramientas"] = FALSE;
}
?>

<header id="header" class="header">

	<div class="container-fluid">

		<div class="row">

			<div class="col-md-10 titulo">

				<h1><?= $titulo ?></h1>

			</div>

			<div class="col-md-2 social">

				<a href="<?= base_url("feed/rss") ?>">

					<img src="<?= base_url("assets/red_resiliencia/img/rss.png") ?>" class="img-responsive pull-right">

				</a>

			</div>

		</div>

	</div>

	<?php $this->load->view("base/menu", $datos); ?>

	<?php $this->load->view("portada/destacados"); ?>

</header>

<?php if (isset($articulos)): ?>

	<!-- Articulos -->
	<section id="articulos" class="articulos">

		<div class="titulo-articulos container-fluid">

			<hr>

			<h1>Artículos</h1>

			<hr>

		</div>

		<?php if ($articulos): ?>

			<?php $this->load->view("articulo/contenido_articulos", array("articulos" => $articulos, "path_articulos" => $path_articulos)); ?>

			<div class="acciones">

				<a href="<?= base_url("articulo/articulos") ?>" class="btn btn-primary">Ver todos los artículos</a>

			</div>

		<?php else: ?>

			<div class="container-fluid">

				<p>Sin artículos.</p>

			</div>

		<?php endif; ?>

	</section>

<?php endif; ?>

<?php if (isset($publicaciones)): ?>

	<!-- Publicaciones -->
	<section id="publicaciones" class="publicaciones">

		<div class="titulo-publicaciones container-fluid">

			<hr>

			<h1>Publicaciones</h1>

			<hr>

		</div>

		<?php if ($publicaciones): ?>

			<?php $this->load->view("publicacion/contenido_publicaciones", array("publicaciones" => $publicaciones, "path_publicaciones" => $path_publicaciones)); ?>

			<div class="acciones">

				<a href="<?= base_url("publicacion/publicaciones") ?>" class="btn btn-primary">Ver todas las publicaciones</a>

			</div>

		<?php else: ?>

			<div class="container-fluid">

				<p>Sin publicaciones.</p>

			</div>

		<?php endif; ?>

	</section>

<?php endif; ?>

<?php if (isset($eventos)): ?>

	<!-- Eventos -->
	<section id="eventos" class="eventos">

		<div class="titulo-eventos container-fluid">

			<hr>

			<h1>Eventos</h1>

			<hr>

		</div>

		<?php if ($eventos): ?>

			<?php $this->load->view("evento/contenido_eventos", array("eventos" => $eventos, "path_evento" => $path_evento)); ?>

			<div class="acciones">

				<a href="<?= base_url("evento/eventos") ?>" class="btn btn-primary">Ver todos los eventos</a>

			</div>

		<?php else: ?>

			<div class="container-fluid">

				<p>Sin eventos.</p>

			</div>

		<?php endif; ?>

	</section>

<?php endif; ?>

<?php if (isset($herramientas)): ?>

	<!-- Herramientas -->
	<section id="herramientas" class="herramientas">

		<div class="titulo-herramientas container-fluid">

			<hr>

			<h1>Herramientas</h1>

			<hr>

		</div>

		<?php if ($herramientas): ?>

			<?php $this->load->view("herramienta/contenido_herramientas", array("herramientas" => $herramientas, "path_herramientas" => $path_herramientas)); ?>

			<div class="acciones">

				<a href="<?= base_url("herramienta/herramientas") ?>" class="btn btn-primary">Ver todas las herramientas</a>

			</div>

		<?php else: ?>

			<div class="container-fluid">

				<p>Sin herramientas.</p>

			</div>

		<?php endif; ?>

	</section>

<?php endif; ?>

<?php $this->load->view("base/footer"); ?>