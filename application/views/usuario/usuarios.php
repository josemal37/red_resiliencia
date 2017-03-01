<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center header">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<?php if ($usuarios): ?>

		<div class="table-responsive">

			<table class="table">

				<thead>

					<tr>

						<th>Nombre</th>
						<th>Apellido paterno</th>
						<th>Apellido materno</th>
						<th>Rol</th>
						<th>Acciones</th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($usuarios as $usuario): ?>

						<tr>

							<td><?= $usuario->nombre ?></td>
							<td><?= $usuario->apellido_paterno ?></td>
							<td><?= $usuario->apellido_materno ?></td>
							<td><?= $usuario->nombre_rol ?></td>
							<td>
								<a href="<?= base_url("usuario/modificar_usuario/" . $usuario->id) ?>">Modificar</a>
								<a href="<?= base_url("usuario/modificar_password_usuario/" . $usuario->id) ?>">Modificar password</a>
								<a href="<?= base_url("usuario/eliminar_usuario/" . $usuario->id) ?>">Eliminar</a>
							</td>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		</div>

	<?php else: ?>

		<p>No se registraron usuarios.</p>

	<?php endif; ?>

	<?php if ($this->session->flashdata("no_existe")): ?><p><?= $this->session->flashdata("no_existe") ?></p><?php endif; ?>

	<a href="<?= base_url("usuario/registrar_usuario") ?>">Registrar usuario</a>

</div>

<?php $this->load->view("base/footer"); ?>