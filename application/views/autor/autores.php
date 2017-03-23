<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<?php $this->load->view("base/menu"); ?>

<div class="pagina">

	<div class="titulo">

		<h1><?= $titulo ?></h1>

	</div>

	<div class="container contenido">

		<?php if ($autores): ?>

			<table class="table table-bordered">

				<thead>

					<tr>

						<th>Nombre</th>
						<th>Apellido paterno</th>
						<th>Apellido materno</th>
						<th>Instituciones</th>
						<th>Acciones</th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($autores as $autor): ?>

						<tr id="<?= $autor->id ?>">

							<td><?= $autor->nombre ?></td>
							<td><?= $autor->apellido_paterno ?></td>
							<td><?= $autor->apellido_materno ?></td>

							<td>

								<?php if ($autor->instituciones): ?>

									<ul>

										<?php foreach ($autor->instituciones as $institucion): ?>

											<li><?= $institucion->nombre ?></li>

										<?php endforeach; ?>

									</ul>

								<?php endif; ?>

							</td>

							<td>

								<a href="<?= base_url("autor/modificar_autor/" . $autor->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>

								<a href="<?= base_url("autor/eliminar_autor/" . $autor->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>

							</td>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		<?php else: ?>

			<p>No se registraron autores.</p>

		<?php endif; ?>

			<a href="<?= base_url("autor/registrar_autor") ?>" class="btn btn-default btn-resiliencia">Registrar autor</a>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>