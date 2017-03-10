<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center header">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<div class="login">

		<form action="<?= base_url("login/iniciar_sesion") ?>" id="form_login" method="post">

			<div class="form-group <?php if (form_error("login")): ?>has-error<?php endif; ?>">

				<label>Login</label>

				<input type="text" id="login" name="login" class="form-control" required>

				<?= form_error("login") ?>

			</div>

			<div class="form-group <?php if (form_error("password")): ?>has-error<?php endif; ?>">

				<label>Password</label>

				<input type="password" id="password" name="password" class="form-control" required>

				<?= form_error("password") ?>

			</div>
			<?php if ($this->session->flashdata("error")): ?>

				<div class="form-group has-error">

					<label class="control-label"><?= $this->session->flashdata("error") ?></label>

				</div>

			<?php endif; ?>

			<input type="hidden" id="token" name="token" value="<?= $token ?>">

			<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Aceptar">

		</form>

	</div>

</div>

<script type="text/javascript">
	$("#form_login").validate(<?= $reglas_validacion ?>);
</script>

<?php $this->load->view("base/footer"); ?>