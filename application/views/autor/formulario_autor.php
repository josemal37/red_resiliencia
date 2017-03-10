<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center header">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container contenido">

	<?php
	switch ($accion) {
		case "registrar":
			$url = base_url("autor/" . $accion . "_autor");
			break;
		case "modificar":
			$url = base_url("autor/" . $accion . "_autor/" . $autor->id);
			break;
	}
	?>

	<form action="<?= $url ?>" id="form_autor" method="post" autocomplete="off">

		<div class="form-group">

			<label>Nombre</label>
			<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $autor->nombre ?>"<?php endif; ?>>
			<?= form_error("nombre") ?>

		</div>

		<div class="form-group">

			<label>Apellido paterno</label>
			<input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $autor->apellido_paterno ?>"<?php endif; ?>>
			<?= form_error("apellido_paterno") ?>

		</div>

		<div class="form-group">

			<label>Apellido materno</label>
			<input type="text" id="apellido_materno" name="apellido_materno" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $autor->apellido_materno ?>"<?php endif; ?>>
			<?= form_error("apellido_materno") ?>

		</div>

		<div class="form-group">

			<label>Institución(es)</label>

			<?php if (isset($instituciones) || isset($autor->instituciones)): ?>

				<div class="row">

					<div class="col-md-5">

						<label>Instituciones disponibles</label>

						<select id="instituciones" multiple class="form-control">

							<?php if ($instituciones): ?>

								<?php foreach ($instituciones as $institucion): ?>

									<option value="<?= $institucion->id ?>"><?= $institucion->nombre ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

					</div>

					<div class="col-md-2 btn-group">

						<button id="agregar_institucion" class="agregar btn btn-default">Agregar ></button>
						<button id="quitar_institucion" class="quitar btn btn-default">< Quitar</button>

					</div>

					<div class="col-md-5">

						<label>Instituciones seleccionadas</label>

						<select id="id_institucion" name="id_institucion[]" multiple class="form-control">

							<?php if ($autor->instituciones): ?>

								<?php foreach ($autor->instituciones as $institucion): ?>

									<option value="<?= $institucion->id ?>"><?= $institucion->nombre ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

					</div>

				</div>

			<?php else: ?>

				<p class="control-label">No se registraron instituciones.</p>

			<?php endif; ?>

		</div>

		<?php if ($accion == "modificar"): ?>

			<input type="hidden" id="id" name="id" value="<?= $autor->id ?>">

		<?php endif; ?>

		<?php if ($this->session->flashdata("existe")): ?><p><?= $this->session->flashdata("existe") ?></p><?php endif; ?>

		<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Aceptar">

	</form>

</div>

<script type="text/javascript">

	$(document).ready(function() {

		$('.agregar').click(function(event) {
			event.preventDefault();
			var id = $(this).attr("id");
			var id_origen = get_select_origen(id);
			var id_destino = get_select_destino(id);
			$("#" + id_origen + " option:selected").remove().appendTo("#" + id_destino);
		});
		$('.quitar').click(function(event) {
			event.preventDefault();
			var id = $(this).attr("id");
			var id_origen = get_select_origen(id);
			var id_destino = get_select_destino(id);
			$("#" + id_origen + " option:selected").remove().appendTo("#" + id_destino);
		});

		function get_select_origen(id) {

			var id_select = "";

			switch (id) {
				case "agregar_autor":
					id_select = "autores";
					break;
				case "agregar_categoria":
					id_select = "categorias";
					break;
				case "agregar_institucion":
					id_select = "instituciones";
					break;
				case "quitar_autor":
					id_select = "id_autor";
					break;
				case "quitar_categoria":
					id_select = "id_categoria";
					break;
				case "quitar_institucion":
					id_select = "id_institucion";
					break;
			}

			return id_select;
		}

		function get_select_destino(id) {

			var id_select = "";

			switch (id) {
				case "agregar_autor":
					id_select = "id_autor";
					break;
				case "agregar_categoria":
					id_select = "id_categoria";
					break;
				case "agregar_institucion":
					id_select = "id_institucion";
					break;
				case "quitar_autor":
					id_select = "autores";
					break;
				case "quitar_categoria":
					id_select = "categorias";
					break;
				case "quitar_institucion":
					id_select = "instituciones";
					break;
			}

			return id_select;
		}

		$("#form_autor").submit(function() {
			$("option").each(function() {
				$(this).prop("selected", "selected");
			});
		});
	});

</script>

<script type="text/javascript">
	/** script para validaciones **/
	$("#form_autor").validate(<?= $reglas_validacion ?>);
</script>

<?php $this->load->view("base/footer"); ?>
