<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center titulo">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<div class="row evento">

		<div class="col-md-4">

			<img src="<?= base_url($path_evento . $evento->imagen) ?>" class="img-responsive img-center">

		</div>

		<div class="col-md-8">

			<h4>Nombre</h4>

			<p class="text-justify"><?= $evento->nombre ?></p>

			<?php if ($evento->descripcion): ?>

				<h4>Descripción</h4>

				<p class="text-justify"><?= $evento->descripcion ?></p>

			<?php endif; ?>

			<?php if ($evento->direccion): ?>

				<h4>Lugar</h4>

				<?= $evento->direccion ?><?php if ($evento->ciudad): ?>, <?= $evento->ciudad->nombre ?><?php endif; ?><?php if ($evento->pais): ?>, <?= $evento->pais->nombre ?><?php endif; ?>

			<?php endif; ?>

			<?php if ($evento->fecha_inicio && $evento->fecha_fin): ?>

				<h4>Fecha</h4>

				<p>De <span class="fecha"><?= $evento->fecha_inicio ?></span> a <?= $evento->fecha_fin ?></p>

			<?php endif; ?>

			<?php if ($evento->instituciones): ?>

				<h4>Instituciones encargadas</h4>

				<p><?= listar_array_de_stdclass($evento->instituciones, "nombre", ", ") ?></p>

			<?php endif; ?>

			<?php if ($evento->categorias): ?>

				<h4>Categorias</h4>

				<p><?= listar_array_de_stdclass($evento->categorias, "nombre", ", ") ?></p>

			<?php endif; ?>

		</div>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>