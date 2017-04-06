<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="herramientas">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu"); ?>

	<?php $this->load->view("base/busqueda", array("fuente" => "herramienta", "criterio" => $criterio)); ?>

	<?php $this->load->view("herramienta/contenido_herramientas"); ?>

	<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

		<div class="acciones">

			<a href="<?= base_url("herramienta/registrar_herramienta") ?>" class="btn btn-default">Registrar herramienta</a>

		</div>

	<?php endif; ?>

	<?php if ($this->session->flashdata("error")): ?>

		<div class="container-fluid">

			<p class="text-danger"><?= $this->session->flashdata("error") ?></p>

		</div>

	<?php endif; ?>

</div>

<?php $this->load->view("base/footer"); ?>