<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center header">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<?php if ($autores): ?>

		<table class="table">

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

							<a href="<?= base_url("autor/modificar_autor/" . $autor->id) ?>">Modificar</a>

							<a href="<?= base_url("autor/eliminar_autor/" . $autor->id) ?>">Eliminar</a>

						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

	<?php else: ?>

		<p>No se registraron autores.</p>

	<?php endif; ?>

	<a href="<?= base_url("autor/registrar_autor") ?>">Registrar autor</a>

</div>

<?php $this->load->view("base/footer"); ?>