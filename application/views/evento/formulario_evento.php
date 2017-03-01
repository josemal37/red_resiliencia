<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center">

	<h1><?= $titulo ?></h1>

</div>

<?php
switch ($accion) {
	case "registrar":
		$url = base_url("evento/registrar_evento");
		break;
	case "modificar":
		$url = base_url("evento/modificar_evento/" . $evento->id);
		break;
}
?>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<form action="<?= $url ?>" id="form-evento" method="post" enctype="multipart/form-data" autocomplete="off">

		<div class="form-group">

			<label>Nombre</label>

			<input type="text" id="nombre" name="nombre" class="form-control">

			<?= form_error("nombre") ?>

		</div>

		<div class="form-group">

			<label>Descripción</label>

			<textarea id="descripcion" name="descripcion" class="form-control"></textarea>

			<?= form_error("descripcion") ?>

		</div>

		<div class="form-group">

			<label>Imagen</label>

			<input type="file" id="imagen" name="imagen" required>

			<?= form_error("imagen") ?>

		</div>

		<div class="form-group">

			<label>Fecha de inicio</label>

			<input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">

			<?= form_error("fecha_inicio") ?>

		</div>

		<div class="form-group">

			<label>Fecha de fin</label>

			<input type="date" id="fecha_fin" name="fecha_fin" class="form-control">

			<?= form_error("fecha_fin") ?>

		</div>

		<div class="form-group">

			<label>Pais</label>

			<select id="pais" class="form-control">

				<?php if ($paises): ?>

					<?php foreach ($paises as $pais): ?>

						<option value="<?= $pais->id ?>"><?= $pais->nombre ?></option>

					<?php endforeach; ?>

				<?php endif; ?>

			</select>

			<?= form_error("pais") ?>

		</div>

		<div class="form-group">

			<label>Ciudad</label>

			<select id="ciudad" name="ciudad" class="form-control">

				<?php if ($ciudades): ?>

					<?php foreach ($ciudades as $ciudad): ?>

						<option value="<?= $ciudad->id ?>"><?= $ciudad->nombre ?></option>

					<?php endforeach; ?>

				<?php endif; ?>

			</select>

			<?= form_error("pais") ?>

		</div>

		<div class="form-group">

			<label>Dirección</label>

			<input type="text" id="direccion" name="direccion" class="form-control">

			<?= form_error("direccion") ?>

		</div>

		<!-- Categorias -->
		<?php if (isset($categorias) || isset($publicacion->categorias)): ?>

			<div class="form-group">

				<label>Categoria(s)</label>

				<div class="row">

					<div class="col-md-5">

						<label>Categorias disponibles</label>

						<select id="categorias" class="form-control" multiple>

							<?php if ($categorias): ?>

								<?php foreach ($categorias as $categoria): ?>

									<option value="<?= $categoria->id ?>"><?= $categoria->nombre ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

					</div>

					<div class="col-md-2 btn-group">

						<button id="agregar_categoria" class="agregar btn btn-default">Agregar ></button>

						<button id="quitar_categoria" class="quitar btn btn-default">< Quitar</button>

					</div>

					<div class="col-md-5">

						<label>Categorias seleccionadas</label>

						<select id="id_categoria" name="id_categoria[]" class="form-control" multiple>

							<?php if ($publicacion->categorias): ?>

								<?php foreach ($publicacion->categorias as $categoria): ?>

									<option value="<?= $categoria->id ?>"><?= $categoria->nombre ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

					</div>

				</div>

			</div>

		<?php else: ?>

			<p>No se registraron categorias.</p>

		<?php endif; ?>

		<!-- Instituciones -->
		<?php if (isset($instituciones) || isset($publicacion->instituciones)): ?>

			<div class="form-group">

				<label>Institución(es)</label>

				<div class="row">

					<div class="col-md-5">

						<label>Instituciones disponibles</label>

						<select id="instituciones" class="form-control" multiple>

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

						<select id="id_institucion" name="id_institucion[]" class="form-control" multiple>

							<?php if (isset($publicacion) && $publicacion->instituciones): ?>

								<?php foreach ($publicacion->instituciones as $institucion): ?>

									<option value="<?= $institucion->id ?>"><?= $institucion->nombre ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

							<?php if ($institucion_usuario): ?>

								<option value="<?= $institucion_usuario->id ?>"><?= $institucion_usuario->nombre ?></option>

							<?php endif; ?>

						</select>

					</div>

				</div>

				<?php if ($this->session->userdata("rol") == "usuario"): ?>

					<input type="hidden" id="id_institucion_usuario" name="id_institucion_usuario" value="<?= $this->session->userdata("id_institucion") ?>">

				<?php endif; ?>

			</div>

		<?php else: ?>

			<p>No se registraron instituciones.</p>

		<?php endif; ?>

		<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

	</form>

</div>

<script type="text/javascript">

	$(document).ready(function() {

		/** scripts de los selects multiples **/

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
			if (id == "quitar_institucion") {
				var id_institucion = $("#id_institucion_usuario").attr("value");
				if (typeof id_institucion != "undefined") {
					console.log("asd");
					$("#" + id_origen + " option:selected").each(function() {
						console.log($(this));
						if ($(this).attr("value") == id_institucion) {
							$(this).prop("selected", false);
						}
					});
				}
			}
			$("#" + id_origen + " option:selected").remove().appendTo("#" + id_destino);
		});

		function get_select_origen(id) {

			var id_select = "";

			switch (id) {
				case "agregar_categoria":
					id_select = "categorias";
					break;
				case "agregar_institucion":
					id_select = "instituciones";
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
		;

		function get_select_destino(id) {

			var id_select = "";

			switch (id) {
				case "agregar_categoria":
					id_select = "id_categoria";
					break;
				case "agregar_institucion":
					id_select = "id_institucion";
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
		;

		/** script para antes del envio **/

		$("#form_publicacion").submit(function() {
			$("option").each(function() {
				$(this).prop("selected", "selected");
			});
		});

		/** script para actualizar ciudades **/

		$("#pais").on("change", function() {
			var id_pais = $(this).find("option:selected").prop("value");
			$.ajax({
				url: "<?= base_url("evento/get_ciudades_ajax") ?>",
				method: "POST",
				data: {
					id_pais: id_pais
				},
				dataType: "json"
			}).done(function(response) {
				actualizar_ciudades(response);
			});
		});

		function actualizar_ciudades(ciudades) {
			var opciones = Array();
			for (var i = 0; i < ciudades.length; i++) {
				var ciudad = ciudades[i];
				var opcion = $("<option/>").prop("value", ciudad.id).html(ciudad.nombre);
				opciones.push(opcion);
			}
			$("#ciudad").find("option").remove();
			$("#ciudad").append(opciones);
		}
	});

</script>

<?php $this->load->view("base/footer"); ?>