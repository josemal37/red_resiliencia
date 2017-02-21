<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<?php
	switch ($accion) {
		case "registrar":
			$url = base_url("usuario/" . $accion . "_usuario");
			break;
		case "modificar":
			$url = base_url("usuario/" . $accion . "_usuario/" . $usuario->id);
			break;
		case "modificar_password":
			$url = base_url("usuario/" . $accion . "_usuario/" . $usuario->id);
			break;
	}
	?>

	<form action="<?= $url ?>" id="form_usuario" method="post" autocomplete="off">

		<?php if ($accion == "registrar" || $accion == "modificar"): ?>

			<div class="form-group">

				<label>Nombre</label>

				<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $usuario->nombre ?>"<?php endif; ?> required>

				<?= form_error("nombre") ?>

			</div>

			<div class="form-group">

				<label>Apellido paterno</label>

				<input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $usuario->apellido_paterno ?>"<?php endif; ?>>

				<?= form_error("nombre") ?>

			</div>

			<div class="form-group">

				<label>Apellido materno</label>

				<input type="text" id="apellido_materno" name="apellido_materno" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $usuario->apellido_materno ?>"<?php endif; ?>>

				<?= form_error("nombre") ?>

			</div>

			<div class="form-group">

				<label>Institución</label>

				<select id="institucion" name="institucion" class="form-control" required>

					<?php if ($instituciones): ?>

						<?php foreach ($instituciones as $institucion): ?>

							<option value="<?= $institucion->id ?>" <?php if ($accion == "modificar" && $usuario->id_institucion == $institucion->id): ?>selected<?php endif; ?>><?= $institucion->nombre ?></option>

						<?php endforeach; ?>

					<?php endif; ?>

				</select>

				<?= form_error("institucion") ?>

			</div>

			<div class="form-group">

				<label>Rol</label>

				<select id="rol" name="rol" class="form-control" required>

					<?php if ($roles): ?>

						<?php foreach ($roles as $rol): ?>

							<option value="<?= $rol->id ?>" <?php if ($accion == "modificar" && $usuario->id_rol == $rol->id): ?>selected<?php endif; ?>><?= $rol->nombre_rol ?></option>

						<?php endforeach; ?>

					<?php endif; ?>

				</select>

				<?= form_error("rol") ?>

			</div>

			<div class="form-group">

				<label>Login</label>

				<input type="text" id="login" name="login" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $usuario->login ?>"<?php endif; ?> required>

				<?= form_error("login") ?>

				<?php if ($this->session->flashdata("existe")): ?><p><?= $this->session->flashdata("existe") ?></p><?php endif; ?>

			</div>

		<?php endif; ?>

		<?php if ($accion == "modificar_password"): ?>

			<div>

				<p><label>Nombre:</label> <?= $usuario->nombre_completo ?></p>

			</div>

		<?php endif; ?>

		<?php if ($accion == "registrar" || $accion == "modificar_password"): ?>

			<div class="form-group">

				<label>Password</label>

				<input type="password" id="password" name="password" class="form-control" required>

				<?= form_error("password") ?>

			</div>

			<div class="form-group">

				<label>Confirmación</label>

				<input type="password" id="confirmacion" name="confirmacion" class="form-control" required>

				<?= form_error("confirmacion") ?>

			</div>

		<?php endif; ?>

		<?php if ($accion == "modificar" || $accion == "modificar_password"): ?>

			<input type="hidden" id="id" name="id" value="<?= $usuario->id ?>">

		<?php endif; ?>

		<?php if ($this->session->flashdata("error")): ?><p><?= $this->session->flashdata("error") ?></p><?php endif; ?>

		<input type="submit" id="submit" name="submit" class="btn btn-primary" value="aceptar">

	</form>

</div>

<?php $this->load->view("base/footer"); ?>