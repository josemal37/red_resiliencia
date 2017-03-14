<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center titulo">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container contenido">

	<?php if ($instituciones): ?>

		<table class="table">

			<thead>

				<tr>

					<th>Sigla</th>
					<th>Nombre</th>
					<th>Acciones</th>

				</tr>

			</thead>

			<tbody>

				<?php foreach ($instituciones as $institucion): ?>

					<tr id="<?= $institucion->id ?>">

						<td><?= $institucion->sigla ?></td>
						<td><?= $institucion->nombre ?></td>

						<td>

							<a href="<?= base_url("institucion/modificar_institucion/" . $institucion->id) ?>">Modificar</a>

							<a href="<?= base_url("institucion/eliminar_institucion/" . $institucion->id) ?>">Eliminar</a>

						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

	<?php else: ?>

		<p>No se registraron instituciones.</p>

	<?php endif; ?>

	<?php if ($this->session->flashdata("no_existe")): ?><p><?= $this->session->flashdata("no_existe") ?></p><?php endif; ?>

	<a href="<?= base_url("institucion/registrar_institucion") ?>">Registrar institución</a>

</div>

<?php $this->load->view("base/footer"); ?>