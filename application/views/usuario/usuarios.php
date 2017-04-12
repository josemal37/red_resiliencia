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

			<?php if ($usuarios): ?>

				<div class="table-responsive">

					<table class="table table-bordered">

						<thead>

							<tr>

								<th>Nombre completo</th>
								<th>Institución</th>
								<th>Login</th>
								<th>Rol</th>
								<th>Acciones</th>

							</tr>

						</thead>

						<tbody>

							<?php foreach ($usuarios as $usuario): ?>

								<tr>

									<td><?= $usuario->nombre_completo ?></td>
									<td><?= $usuario->nombre_institucion ?></td>
									<td><?= $usuario->login ?></td>
									<td><?= $usuario->nombre_rol ?></td>
									<td>
										<a href="<?= base_url("usuario/modificar_usuario/" . $usuario->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>

										<a href="<?= base_url("usuario/modificar_password_usuario/" . $usuario->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar password</a>

										<a href="<?= base_url("usuario/eliminar_usuario/" . $usuario->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>
									</td>

								</tr>

							<?php endforeach; ?>

						</tbody>

					</table>

				</div>

			<?php else: ?>

				<p>No se registraron usuarios.</p>

			<?php endif; ?>

			<a href="<?= base_url("usuario/registrar_usuario") ?>" class="btn btn-default btn-resiliencia">Registrar usuario</a>

			<?php if ($this->session->flashdata("no_existe")): ?><p><?= $this->session->flashdata("no_existe") ?></p><?php endif; ?>

		</div>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>