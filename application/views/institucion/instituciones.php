<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="pagina">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu"); ?>

	<div class="titulo-pagina">

		<div class="container-fluid">

			<h1><?= $titulo ?></h1>

		</div>

	</div>

	<div class="contenido">

		<div class="container-fluid">

			<?php if ($instituciones): ?>

				<table class="table table-bordered">

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

									<a href="<?= base_url("institucion/modificar_institucion/" . $institucion->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>

									<a href="<?= base_url("institucion/eliminar_institucion/" . $institucion->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>

								</td>

							</tr>

						<?php endforeach; ?>

					</tbody>

				</table>

			<?php else: ?>

				<p>No se registraron instituciones.</p>

			<?php endif; ?>

			<a href="<?= base_url("institucion/registrar_institucion") ?>" class="btn btn-default btn-resiliencia">Registrar institución</a>

			<?php if ($this->session->flashdata("no_existe")): ?><p><?= $this->session->flashdata("no_existe") ?></p><?php endif; ?>

		</div>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>