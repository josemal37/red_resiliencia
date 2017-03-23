<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<?php $this->load->view("base/menu"); ?>

<?php
switch ($accion) {
	case "registrar":
		$url = base_url("institucion/" . $accion . "_institucion");
		break;
	case "modificar":
		$url = base_url("institucion/" . $accion . "_institucion/" . $institucion->id);
		break;
}
?>

<div class="pagina">

	<div class="titulo">

		<h1><?= $titulo ?></h1>

	</div>

	<div class="container contenido">

		<form action="<?= $url ?>" id="form-institucion" method="post" autocomplete="off">

			<div class="form-group">

				<label>Nombre</label>

				<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $institucion->nombre ?>"<?php endif; ?>>

				<?= form_error("nombre") ?>

			</div>

			<div class="form-group">

				<label>Sigla</label>

				<input type="text" id="sigla" name="sigla" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $institucion->sigla ?>"<?php endif; ?>>

				<?= form_error("sigla") ?>

			</div>

			<?php if ($accion == "modificar"): ?>

				<input type="hidden" id="id" name="id" value="<?= $institucion->id ?>">

			<?php endif; ?>

			<?php if ($this->session->flashdata("existe")): ?><p><?= $this->session->flashdata("existe") ?></p><?php endif; ?>

			<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Aceptar">

		</form>

	</div>

</div>

<script type="text/javascript">
	/** script para validaciones **/
	$("#form-institucion").validate(<?= $reglas_validacion ?>);
</script>

<?php $this->load->view("base/footer"); ?>
