<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="articulos">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu"); ?>

	<div class="titulo-articulos">

		<div class="container-fluid">

			<h1><?= $titulo ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/busqueda", array("fuente" => "articulo", "criterio" => $criterio)); ?>

	<?php $this->load->view("articulo/contenido_articulos"); ?>

	<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

		<div class="acciones">

			<a href="<?= base_url("articulo/registrar_articulo") ?>" class="btn btn-default btn-resiliencia">Registrar articulo</a>

		</div>

	<?php endif; ?>

	<?php //if (isset($criterio) && !$criterio): ?>

	<div class="text-center">

		<ul class="pagination">

			<?php for ($i = 1; $i <= $nro_paginas; $i ++): ?>

				<li <?php if ($nro_pagina == $i): ?>class="active"<?php endif; ?>><a href="<?= base_url("articulo/articulos/" . $i) ?><?php if ($criterio): ?>?criterio=<?= $criterio ?><?php endif; ?>"><?= $i ?></a></li>

			<?php endfor; ?>

		</ul>

	</div>

	<?php //endif; ?>

	<?php if ($this->session->flashdata("error")): ?><p><?= $this->session->flashdata("error") ?></p><?php endif; ?>

</div>

<?php $this->load->view("base/footer"); ?>