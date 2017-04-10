<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="publicaciones">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu"); ?>

	<div class="titulo-publicaciones">

		<div class="container-fluid">

			<h1><?= $titulo ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/busqueda", array("fuente" => "publicacion", "criterio" => $criterio)); ?>

	<?php $this->load->view("publicacion/contenido_publicaciones"); ?>

	<?php if (isset($criterio) && !$criterio): ?>

		<div class="text-center">

			<ul class="pagination">

				<?php for ($i = 1; $i <= $nro_paginas; $i ++): ?>

					<li <?php if ($nro_pagina == $i): ?>class="active"<?php endif; ?>><a href="<?= base_url("publicacion/publicaciones/" . $i) ?>"><?= $i ?></a></li>

				<?php endfor; ?>

			</ul>

		</div>

	<?php endif; ?>

	<?php if ($this->session->flashdata("error")): ?><p><?= $this->session->flashdata("error") ?></p><?php endif; ?>

</div>

<?php $this->load->view("base/footer"); ?>