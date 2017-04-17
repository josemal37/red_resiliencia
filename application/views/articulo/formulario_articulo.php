<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<?php
switch ($accion) {
	case "registrar":
		$url = base_url("articulo/registrar_articulo");
		break;
	case "modificar":
		$url = base_url("articulo/modificar_articulo/" . $articulo->id);
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

	<div class="container contenido">

		<form action="<?= $url ?>" id="form-articulo"  method="post" enctype="multipart/form-data" autocomplete="off">

			<div class="form-group">

				<label>Nombre</label>

				<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $articulo->nombre ?>"<?php endif; ?> required>

				<?= form_error("nombre") ?>

			</div>

			<div class="form-group">

				<label>Descripción</label>

				<textarea id="descripcion" name="descripcion" class="form-control"><?php if ($accion == "modificar"): ?><?= $articulo->descripcion ?><?php endif; ?></textarea>

				<?= form_error("descripcion") ?>

			</div>

			<div class="form-group">

				<label>Imagen</label>

				<?php if ($accion == "modificar"): ?>

					<?php if (isset($articulo->imagen)): ?>

						<div>

							<label>Imagen actual</label>

							<br><img src="<?= base_url($path_articulo . $articulo->imagen) ?>" class="img-responsive">

							<p><?= $articulo->imagen ?></p>

							<input type="hidden" id="imagen_antiguo" name="imagen_antiguo" value="<?= $articulo->imagen ?>">

						</div>

						<label>Subir imagen nueva</label>

					<?php endif; ?>

				<?php endif; ?>

				<input type="file" id="imagen" name="imagen" <?php if ($accion == "registrar"): ?>required<?php endif; ?>>

				<?= form_error("imagen") ?>

			</div>

			<div class="form-group">

				<label>Contenido</label>

				<textarea id="contenido" name="contenido"><?php if ($accion == "modificar"): ?><?php $this->load->ext_view("articulos", $articulo->url) ?><?php endif; ?></textarea>

				<?php if ($accion == "modificar"): ?>

					<input type="hidden" id="id_contenido" name="id_contenido" value="<?= $articulo->url ?>">

				<?php endif; ?>

				<?= form_error("contenido") ?>

			</div>

			<!-- Autores -->
			<?php if (isset($autores) || isset($articulo->autores)): ?>

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

							<div class="text-right">

								<button id="agregar_autor" class="agregar btn btn-default">Agregar</button>

							</div>

						</div>

						<div class="col-md-2"></div>

						<div class="col-md-5">

							<label>Autores seleccionados</label>

							<select id="id_autor" name="id_autor[]" class="form-control" multiple="">

								<?php if ($articulo->autores): ?>

									<?php foreach ($articulo->autores as $autor): ?>

										<option value="<?= $autor->id ?>"><?= $autor->nombre_completo ?></option>

									<?php endforeach; ?>

								<?php endif; ?>

							</select>

							<div class="text-right">

								<button id="quitar_autor" class="quitar btn btn-default">Quitar</button>

							</div>

						</div>

					</div>

				</div>

			<?php else: ?>

				<p>No se registraron autores.</p>

			<?php endif; ?>

			<!-- Categorias -->
			<?php if (isset($categorias) || isset($articulo->categorias)): ?>

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

							<div class="text-right">

								<button id="agregar_categoria" class="agregar btn btn-default">Agregar</button>

							</div>

						</div>

						<div class="col-md-2 btn-group"></div>

						<div class="col-md-5">

							<label>Categorias seleccionadas</label>

							<select id="id_categoria" name="id_categoria[]" class="form-control" multiple>

								<?php if ($accion == "modificar" && $articulo->categorias): ?>

									<?php foreach ($articulo->categorias as $categoria): ?>

										<option value="<?= $categoria->id ?>"><?= $categoria->nombre ?></option>

									<?php endforeach; ?>

								<?php endif; ?>

							</select>

							<div class="text-right">

								<button id="quitar_categoria" class="quitar btn btn-default">Quitar</button>

							</div>

						</div>

					</div>

				</div>

			<?php else: ?>

				<p>No se registraron categorias.</p>

			<?php endif; ?>

			<!-- Instituciones -->
			<?php if (isset($instituciones) || isset($articulo->instituciones)): ?>

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

							<div class="text-right">

								<button id="agregar_institucion" class="agregar btn btn-default">Agregar</button>

							</div>

						</div>

						<div class="col-md-2 btn-group"></div>

						<div class="col-md-5">

							<label>Instituciones seleccionadas</label>

							<select id="id_institucion" name="id_institucion[]" class="form-control" multiple>

								<?php if ($accion == "modificar" && $articulo->instituciones): ?>

									<?php foreach ($articulo->instituciones as $institucion): ?>

										<option value="<?= $institucion->id ?>"><?= $institucion->nombre ?></option>

									<?php endforeach; ?>

								<?php endif; ?>

								<?php if ($accion == "registrar" && $institucion_usuario): ?>

									<option value="<?= $institucion_usuario->id ?>"><?= $institucion_usuario->nombre ?></option>

								<?php endif; ?>

							</select>

							<div class="text-right">

								<button id="quitar_institucion" class="quitar btn btn-default">Quitar</button>

							</div>

						</div>

					</div>

					<?php if ($this->session->userdata("rol") == "usuario"): ?>

						<input type="hidden" id="id_institucion_usuario" name="id_institucion_usuario" value="<?= $this->session->userdata("id_institucion") ?>">

					<?php endif; ?>

				</div>

			<?php else: ?>

				<p>No se registraron instituciones.</p>

			<?php endif; ?>

			<?php if ($this->session->flashdata("error")): ?>

				<p><?= $this->session->flashdata("error") ?></p>

			<?php endif; ?>

			<?php if ($accion == "modificar"): ?>

				<input type="hidden" id="id" name="id" value="<?= $articulo->id ?>">

			<?php endif; ?>

			<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

		</form>

	</div>

</div>

<script src="<?= base_url("assets/tinymce/tinymce.min.js") ?>"></script>

<script src="<?= base_url("assets/tinymce/jquery.tinymce.min.js") ?>"></script>

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
	});

	tinymce.init({
		selector: '#contenido',
		height: 400,
		menubar: false,
		plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
			"contextmenu directionality emoticons paste textcolor filemanager"
		],
		toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink anchor | image | print preview",
		content_css: '<?= base_url("assets/red_resiliencia/css/red_resiliencia.css") ?>,https://fonts.googleapis.com/css?family=Josefin+Sans',
		body_class: "contenido-mce"
	});

	/** script para antes del envio **/

	$("#form-articulo").submit(function() {
		$("option").each(function() {
			$(this).prop("selected", "selected");
		});
	});

	/** script para validaciones **/
	jQuery.validator.setDefaults({
		ignore: []
	});

	$("#form-articulo").validate(<?= $reglas_validacion ?>);
</script>

<script type="text/javascript">
	/** script para validaciones **/
	jQuery.validator.setDefaults({
		ignore: []
	});

	$("#form-articulo").validate(<?= $reglas_validacion ?>);
</script>

<?php $this->load->view("base/footer"); ?>