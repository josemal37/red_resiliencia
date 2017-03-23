<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<?php $this->load->view("base/menu"); ?>

<?php
switch ($accion) {
	case "registrar":
		$url = base_url("categoria/" . $accion . "_categoria");
		break;
	case "modificar":
		$url = base_url("categoria/" . $accion . "_categoria/" . $categoria->id);
		break;
}
?>

<div class="pagina">

	<div class="titulo">

		<h1><?= $titulo ?></h1>

	</div>

	<div class="container contenido">

		<form action="<?= $url ?>" id="form-categoria" method="post" autocomplete="off">

			<div class="form-group">

				<label>Nombre</label>

				<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $categoria->nombre ?>"<?php endif; ?>>

				<?= form_error("nombre") ?>

				<?php if ($this->session->flashdata("existe")): ?>

					<p><?= $this->session->flashdata("existe") ?></p>

				<?php endif; ?>

			</div>

			<?php if ($accion == "modificar"): ?>

				<input type="hidden" id="id" name="id" value="<?= $categoria->id ?>">

			<?php endif; ?>

			<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Aceptar">

		</form>

	</div>

</div>

<script type="text/javascript">
	/** script para validaciones **/
	$("#form-categoria").validate(<?= $reglas_validacion ?>);
</script>

<?php $this->load->view("base/footer"); ?>