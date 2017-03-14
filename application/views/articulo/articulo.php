<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="titulo text-center">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container contenido contenido-mce">

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

<script type="text/javascript">
	$("img").addClass("img-responsive");
</script>

<?php $this->load->view("base/footer"); ?>