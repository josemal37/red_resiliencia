<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<?php
switch ($accion) {
	case "registrar":
		$url = base_url("herramienta/registrar_herramienta");
		break;
	case "modificar":
		$url = base_url("herramienta/modificar_herramienta/" . $herramienta->id);
		break;
}
?>

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

	<div class="contenido container">

		<form action="<?= $url ?>" id="form-herramienta" method="post" enctype="multipart/form-data" autocomplete="off">

			<div class="form-group">

				<label>Nombre</label>

				<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $herramienta->nombre ?>"<?php endif; ?>>

				<?= form_error("nombre") ?>

			</div>

			<div class="form-group">

				<label>Descripción</label>

				<textarea id="descripcion" name="descripcion" class="form-control"><?php if ($accion == "modificar"): ?><?= $herramienta->descripcion ?><?php endif; ?></textarea>

				<?= form_error("descripcion") ?>

			</div>

			<div class="form-group">

				<label>Imagen</label>

				<?php if ($accion == "modificar"): ?>

					<?php if (isset($herramienta->imagen)): ?>

						<div>

							<label>Imagen actual</label>

							<br><img src="<?= base_url($path_herramientas . $herramienta->imagen) ?>" class="img-responsive">

							<p><?= $herramienta->imagen ?></p>

							<input type="hidden" id="imagen_antiguo" name="imagen_antiguo" value="<?= $herramienta->imagen ?>">

						</div>

						<label>Subir imagen nueva</label>

					<?php endif; ?>

				<?php endif; ?>

				<input type="file" id="imagen" name="imagen" <?php if ($accion == "registrar"): ?>required<?php endif; ?>>

				<?= form_error("imagen") ?>

			</div>

			<div class="form-group">

				<label>Url del video descriptivo (YouTube)</label>

				<input type="text" id="video" name="video" class="form-control"<?php if ($accion == "modificar"): ?>value="<?= $herramienta->video ?>"<?php endif; ?>>

				<?= form_error("video") ?>

			</div>

			<div class="form-group">

				<label>Url de la herramienta</label>

				<input type="text" id="url" name="url" class="form-control"<?php if ($accion == "modificar"): ?>value="<?= $herramienta->url ?>"<?php endif; ?>>

				<?= form_error("url") ?>

			</div><!-- Autores -->
			<?php if (isset($autores) || isset($publicacion->autores)): ?>

				<div class="form-group">

					<label>Autor(es)</label>

					<div class="row">

						<div class="col-md-5">

							<label>Autores disponibles</label>

							<select id="autores" class="form-control" multiple>

								<?php if ($autores): ?>

									<?php foreach ($autores as $autor): ?>

										<option value="<?= $autor->id ?>"><?= $autor->nombre_completo ?></option>

									<?php endforeach; ?>

								<?php endif; ?>

							</select>

						</div>

						<div class="col-md-2 btn-group">

							<button id="agregar_autor" class="agregar btn btn-default">Agregar ></button>
							<button id="quitar_autor" class="quitar btn btn-default">< Quitar</button>

						</div>

						<div class="col-md-5">

							<label>Autores seleccionados</label>

							<select id="id_autor" name="id_autor[]" class="form-control" multiple="">

								<?php if ($herramienta->autores): ?>

									<?php foreach ($herramienta->autores as $autor): ?>

										<option value="<?= $autor->id ?>"><?= $autor->nombre_completo ?></option>

									<?php endforeach; ?>

								<?php endif; ?>

							</select>

						</div>

					</div>

				</div>

			<?php else: ?>

				<p>No se registraron autores.</p>

			<?php endif; ?>

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

								<?php if ($herramienta->categorias): ?>

									<?php foreach ($herramienta->categorias as $categoria): ?>

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

								<?php if (isset($herramienta) && $herramienta->instituciones): ?>

									<?php foreach ($herramienta->instituciones as $institucion): ?>

										<option value="<?= $institucion->id ?>"><?= $institucion->nombre ?></option>

									<?php endforeach; ?>

								<?php endif; ?>

								<?php if ($accion == "registrar" && $institucion_usuario): ?>

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

			<?php if ($accion == "modificar"): ?>

				<input type="hidden" id="id" name="id" value="<?= $herramienta->id ?>">

			<?php endif; ?>

			<?php if ($this->session->flashdata("error")): ?><?= $this->session->flashdata("error") ?><?php endif; ?>

			<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

		</form>

	</div>

</div>

<script type="text/javascript">
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
	;

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
	;

	/** script para antes del envio **/

	$("#form-herramienta").submit(function() {
		$("option").each(function() {
			$(this).prop("selected", "selected");
		});
	});

	jQuery.validator.addMethod("youtubeUrl", function(value, element) {
		return this.optional(element) || /(?:youtube\.com\/\S*(?:(?:\/e(?:mbed))?\/|watch\?(?:\S*?&?v\=))|youtu\.be\/)([a-zA-Z0-9_-]{6,11})/.test(value);
	}, "Debe ser un video de YouTube.");

	$("#form-herramienta").validate(<?= $reglas_validacion ?>);
</script>

<?php $this->load->view("base/footer"); ?>