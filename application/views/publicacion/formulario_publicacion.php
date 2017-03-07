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
			$url = base_url("publicacion/" . $accion . "_publicacion");
			break;
		case "modificar":
			$url = base_url("publicacion/" . $accion . "_publicacion/" . $publicacion->id);
			break;
	}
	?>

	<form action="<?= $url ?>" id="form_publicacion" method="post" enctype="multipart/form-data" autocomplete="off">

		<!-- Nombre -->
		<div class="form-group">

			<label>Nombre</label>

			<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $publicacion->nombre ?>"<?php endif; ?>>

			<?= form_error("nombre") ?>

		</div>

		<!-- Descripcion -->
		<div class="form-group">

			<label>Descripción</label>

			<textarea id="descripcion" name="descripcion" class="form-control"><?php if ($accion == "modificar"): ?><?= $publicacion->descripcion ?><?php endif; ?></textarea>

			<?= form_error("descripcion") ?>

		</div>

		<!-- Modulos -->
		<div class="form-group">

			<label>Modulos</label>

			<div class="checkbox">

				<label><input type="checkbox" id="con_modulos" name="con_modulos" <?php if ($accion == "modificar" && $publicacion->modulos): ?>checked<?php endif; ?>>Agregar modulos</label>

			</div>

			<?php if ($accion == "modificar" && $publicacion->modulos): ?>

				<div id="div_modulos">

					<ol id="lista_modulos">

						<?php foreach ($publicacion->modulos as $modulo): ?>

							<li>

								<span class="input-group">

									<input type="text" id="modulos" name="modulos[]" class="form-control" value="<?= $modulo->nombre ?>">

									<span class="input-group-btn">

										<button class="eliminar_modulo btn btn-default">Eliminar</button>

									</span>

								</span>

							</li>

						<?php endforeach; ?>

					</ol>

					<?= form_error("modulos") ?>

					<button id="agregar_modulo" name="agregar_modulo" class="btn btn-default">Agregar modulo</button>

				</div>

			<?php else: ?>

				<div id="div_modulos" style="display: none">

					<ol id="lista_modulos">

						<li>

							<span class="input-group">

								<input type="text" id="modulos" name="modulos[]" class="form-control">

								<span class="input-group-btn">

									<button class="eliminar_modulo btn btn-default">Eliminar</button>

								</span>

							</span>

						</li>

					</ol>

					<?= form_error("modulos") ?>

					<button id="agregar_modulo" name="agregar_modulo" class="btn btn-default">Agregar modulo</button>

				</div>

			<?php endif; ?>

		</div>

		<!-- Imagen -->
		<div class="form-group">

			<label>Imagen</label>

			<?php if ($accion == "modificar"): ?>

				<?php if (isset($publicacion->imagen)): ?>

					<div>

						<label>Imagen actual</label>

						<br><img src="<?= base_url($path_publicaciones . $publicacion->imagen) ?>" class="img-responsive">

						<p><?= $publicacion->imagen ?></p>

						<input type="hidden" id="imagen_antiguo" name="imagen_antiguo" value="<?= $publicacion->imagen ?>">

					</div>

					<label>Subir imagen nueva</label>

				<?php endif; ?>

			<?php endif; ?>

			<input type="file" id="imagen" name="imagen" <?php if ($accion == "registrar"): ?>required<?php endif; ?>>

			<?= form_error("imagen") ?>

		</div>

		<!-- Documento -->
		<div class="form-group">

			<label>Documento</label>

			<?php if ($accion == "modificar"): ?>

				<?php if ($publicacion->url): ?>

					<div>

						<label>Documento actual</label>

						<p><a href="<?= base_url($path_publicaciones . $publicacion->url) ?>"><?= $publicacion->url ?></a></p>

						<input type="hidden" id="url_antiguo" name="url_antiguo" value="<?= $publicacion->url ?>">

					</div>

					<label>Subir nuevo documento</label>

				<?php endif; ?>

			<?php endif; ?>

			<input type="file" id="url" name="url">

			<?= form_error("url") ?>

		</div>

		<?php if ($this->session->flashdata("error")): ?><p><?= $this->session->flashdata("error") ?></p><?php endif; ?>

		<!-- Autores -->
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

							<?php if ($publicacion->autores): ?>

								<?php foreach ($publicacion->autores as $autor): ?>

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

			<input type="hidden" id="id" name="id" value="<?= $publicacion->id ?>">

		<?php endif; ?>

		<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Aceptar">

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

		$("#form_publicacion").submit(function() {
			$("option").each(function() {
				$(this).prop("selected", "selected");
			});
		});

		/** scripts de los modulos **/

		$("#con_modulos").click(function() {
			if ($(this).prop("checked") == true) {
				$("#div_modulos").show();
			} else {
				$("#div_modulos").hide();
			}
		});

		/* agregar un modulo */
		$("#agregar_modulo").click(function(event) {
			event.preventDefault();

			var input = $("<input/>", {
				type: "text",
				id: "modulos",
				name: "modulos[]"
			});
			input.addClass("form-control");

			var button_eliminar = $("<button/>");
			button_eliminar.html("Eliminar");
			button_eliminar.addClass("eliminar_modulo btn btn-default");

			var span_button = $("<span/>");
			span_button.addClass("input-group-btn");

			span_button.append(button_eliminar);

			var span_conjunto = $("<span/>");
			span_conjunto.addClass("input-group");

			span_conjunto.append(input);
			span_conjunto.append(span_button);

			var li = $("<li/>");

			li.append(span_conjunto);

			li.appendTo("#lista_modulos");
		});

		/* eliminar un modulo */
		$(document).on("click", ".eliminar_modulo", function(event) {
			event.preventDefault();

			var li = $(this).parents("li");

			li.remove();
		});
	});

</script>

<?php $this->load->view("base/footer"); ?>