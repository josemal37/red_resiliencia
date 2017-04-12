<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="articulo">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu"); ?>

	<div class="contenido">

		<div class="container text-center">

			<h2 class="titulo-articulo"><?= $articulo->nombre ?></h2>

		</div>

		<div class="container">

			<?php if ($articulo->autores): ?>

				<p><label class="subtitulo">Autores:</label> <?= listar_array_de_stdclass($articulo->autores, "nombre_completo", ", ") ?></p>

			<?php endif; ?>

			<?php if ($articulo->instituciones): ?>

				<p><label class="subtitulo">Instituciones:</label> <?= listar_array_de_stdclass($articulo->instituciones, "nombre", ", ") ?></p>

			<?php endif; ?>

			<hr>

			<div class="contenido-mce">

				<?php $this->load->ext_view("articulos", $articulo->url) ?>

			</div>

			<hr>

			<div class="text-right">

				<?php if ($articulo->categorias): ?>

					<p><label class="subtitulo">Categorías:</label> <?= listar_array_de_stdclass($articulo->categorias, "nombre", ", ") ?></p>

				<?php endif; ?>

			</div>

			<?php $this->load->view("base/social", array("item" => $articulo)); ?>

		</div>

	</div>

</div>

<script type="text/javascript">
	$("img").addClass("img-responsive");
</script>

<?php $this->load->view("base/footer"); ?>