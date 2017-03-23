<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<?php $this->load->view("base/menu"); ?>

<div class="pagina">

	<div class="titulo">

		<h1><?= $titulo ?></h1>

	</div>

	<div class="container contenido">

		<?php $this->load->ext_view("articulos", $articulo->url) ?>

		<?php if ($articulo->autores): ?>

			<p><label>Autor(es):</label> <?= listar_array_de_stdclass($articulo->autores, "nombre_completo", ", ") ?></p>

		<?php endif; ?>

		<?php if ($articulo->instituciones): ?>

			<p><label>Institución(es):</label> <?= listar_array_de_stdclass($articulo->instituciones, "nombre", ", ") ?></p>

		<?php endif; ?>

		<?php if ($articulo->categorias): ?>

			<p><label>Categoria(s):</label> <?= listar_array_de_stdclass($articulo->categorias, "nombre", ", ") ?></p>

		<?php endif; ?>

	</div>

</div>

<script type="text/javascript">
	$("img").addClass("img-responsive");
</script>

<?php $this->load->view("base/footer"); ?>