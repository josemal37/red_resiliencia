<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center titulo">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<button id="activar_busqueda" class="btn btn-default btn-lg btn-redondo"><span class="glyphicon glyphicon-search"></span></button>

	<div id="div_busqueda" <?php if ($submit): ?>style="display: none;"<?php endif; ?>>

		<form id="form-busqueda" action="<?= base_url("publicacion/busqueda_avanzada") ?>" method="post">

			<?php if ($fuente == "publicacion" || $fuente == "articulo" || $fuente == "evento"): ?>

				<?php if (isset($categorias) || isset($publicacion->categorias)): ?>

					<label>Categoria(s)</label>

					<div class="checkbox">

						<label><input type="checkbox" id="con_categorias" name="con_categorias" <?php if (!$submit):?>checked<?php elseif ($categorias_seleccionadas):?>checked<?php endif;?>>Filtrar por categorías</label>

					</div>

					<div id="div_categorias" class="form-group" <?php if ($submit && !$categorias_seleccionadas):?>style="display: none;"<?php endif;?>>

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

									<?php if ($categorias_seleccionadas): ?>

										<?php foreach ($categorias_seleccionadas as $categoria): ?>

											<option value="<?= $categoria->id ?>"><?= $categoria->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

					</div>

				<?php else: ?>

					<label>Categoria(s)</label>

					<p>No se registraron categorías.</p>

				<?php endif; ?>

			<?php endif; ?>

			<?php if ($fuente == "publicacion" || $fuente == "articulo"): ?>

				<?php if (isset($autores) && $autores): ?>

					<label>Autor</label>

					<div class="checkbox">

						<label><input type="checkbox" id="con_autor" name="con_autor" <?php if (!$submit):?>checked<?php elseif ($id_autor):?>checked<?php endif;?>>Filtrar por autor</label>

					</div>

					<div id="div_autor" class="form-group" <?php if ($submit && !$id_autor):?>style="display: none;"<?php endif;?>>

						<select id="id_autor" name="id_autor" class="form-control">

							<?php if ($autores): ?>

								<?php foreach ($autores as $autor): ?>

									<option value="<?= $autor->id ?>" <?php if ($submit && $autor->id = $id_autor): ?>selected<?php endif; ?>><?= $autor->nombre_completo ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

					</div>

				<?php else: ?>

					<label>Autor</label>

					<p>No se registraron autores.</p>

				<?php endif; ?>

			<?php endif; ?>

			<?php if ($fuente == "publicacion" || $fuente == "articulo" || $fuente == "evento"): ?>

				<?php if (isset($instituciones) && $instituciones): ?>

					<label>Institución</label>

					<div class="checkbox">

						<label><input type="checkbox" id="con_institucion" name="con_institucion" <?php if (!$submit):?>checked<?php elseif ($id_institucion):?>checked<?php endif;?>>Filtrar por institución</label>

					</div>

					<div id="div_institucion" class="form-group" <?php if ($submit && !$id_institucion):?>style="display: none;"<?php endif;?>>

						<select id="id_institucion" name="id_institucion" class="form-control">

							<?php if ($instituciones): ?>

								<?php foreach ($instituciones as $institucion): ?>

									<option value="<?= $institucion->id ?>" <?php if ($submit && $institucion->id = $id_institucion): ?>selected<?php endif; ?>><?= $institucion->nombre ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

					</div>

				<?php else: ?>

					<label>Institución</label>

					<p>No se registraron instituciones.</p>

				<?php endif; ?>

			<?php endif; ?>

			<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Buscar">

		</form>

	</div>

</div>

<?php if ($submit): ?>

	<div class="container">

		<?php if ($fuente == "publicacion"): ?>

			<h4>Publicaciones relacionadas</h4>

			<?php if ($publicaciones): ?>

				<?php foreach ($publicaciones as $publicacion): ?>

					<div class="row contenido-pagina">

						<div class="col-md-3 text-center">

							<?php if ($publicacion->imagen != ""): ?>

								<img src="<?= base_url($path_publicaciones . $publicacion->imagen) ?>" alt="<?= $publicacion->nombre ?>" class="img-responsive img-center">

							<?php endif; ?>

						</div>

						<div class="col-md-9">

							<h4><?= $publicacion->nombre ?></h4>

							<p class="text-justify"><?= $publicacion->descripcion ?></p>

							<?php if ($publicacion->modulos): ?>

								<h4>Modulos</h4>

								<ol>

									<?php foreach ($publicacion->modulos as $modulo): ?>

										<li><?= $modulo->nombre ?></li>

									<?php endforeach; ?>

								</ol>

							<?php endif; ?>

							<?php if ($publicacion->url != ""): ?>

								<h4>Documento</h4>

								<a href="<?= base_url($path_publicaciones . $publicacion->url) ?>">Descargar documento</a>

							<?php endif; ?>

							<div class="row">

								<?php if ($publicacion->autores): ?>

									<div class="col-md-4">

										<h4>Autores</h4>

										<ul>

											<?php foreach ($publicacion->autores as $autor): ?>

												<li><?= $autor->nombre_completo ?></li>

											<?php endforeach; ?>

										</ul>

									</div>

								<?php endif; ?>

								<?php if ($publicacion->categorias): ?>

									<div class="col-md-4">

										<h4>Categorias</h4>

										<ul>

											<?php foreach ($publicacion->categorias as $categoria): ?>

												<li><?= $categoria->nombre ?></li>

											<?php endforeach; ?>

										</ul>

									</div>

								<?php endif; ?>

								<?php if ($publicacion->instituciones): ?>

									<div class="col-md-4">

										<h4>Instituciones</h4>

										<ul>

											<?php foreach ($publicacion->instituciones as $institucion): ?>

												<li><?= $institucion->nombre ?></li>

											<?php endforeach; ?>

										</ul>

									</div>

								<?php endif; ?>

								<div class="clearfix visible-md-block visible-lg-block"></div>

							</div>

							<a href="<?= base_url("publicacion/ver_publicacion/" . $publicacion->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Ver</a>

							<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

								<a href="<?= base_url("publicacion/modificar_publicacion/" . $publicacion->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>

							<?php endif; ?>

							<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

								<a href="<?= base_url("publicacion/eliminar_publicacion/" . $publicacion->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>

							<?php endif; ?>

						</div>

						<div class="clearfix visible-md-block visible-lg-block"></div>

					</div>

				<?php endforeach; ?>

			<?php else: ?>

				<p>No se encontraron publicaciones relacionadas.</p>

			<?php endif; ?>

		<?php endif; ?>

	</div>

<?php endif; ?>

<script>
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

	$("#form-busqueda").submit(function() {
		$("option").each(function() {
			$(this).prop("selected", "selected");
		});
	});

	$("#con_categorias").click(function() {
		if ($(this).prop("checked") == true) {
			$("#div_categorias").show(300);
		} else {
			$("#div_categorias").hide(300);
		}
	});

	$("#con_autor").click(function() {
		if ($(this).prop("checked") == true) {
			$("#div_autor").show(300);
		} else {
			$("#div_autor").hide(300);
		}
	});

	$("#con_institucion").click(function() {
		if ($(this).prop("checked") == true) {
			$("#div_institucion").show(300);
		} else {
			$("#div_institucion").hide(300);
		}
	});

	$("#activar_busqueda").click(function(event) {
		event.preventDefault();
		$("#div_busqueda").toggle(500);
	});
</script>

<?php $this->load->view("base/footer"); ?>