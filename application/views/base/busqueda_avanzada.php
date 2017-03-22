<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center titulo">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<?php
switch ($fuente) {
	case "publicacion":
		$url = base_url("publicacion/busqueda_avanzada");
		break;
	case "articulo":
		$url = base_url("articulo/busqueda_avanzada");
		break;
	case "evento":
		$url = base_url("evento/busqueda_avanzada");
		break;
}
?>

<div class="container">

	<button id="activar_busqueda" class="btn btn-default btn-lg btn-redondo"><span class="glyphicon glyphicon-search"></span></button>

	<div id="div_busqueda" <?php if ($submit): ?>style="display: none;"<?php endif; ?>>

		<form id="form-busqueda" action="<?= $url ?>" method="post">

			<?php if ($fuente == "publicacion" || $fuente == "articulo" || $fuente == "evento"): ?>

				<?php if (isset($categorias)): ?>

					<div class="checkbox">

						<label><input type="checkbox" id="con_categorias" name="con_categorias" <?php if ($submit && (isset($categorias_seleccionadas) && $categorias_seleccionadas)): ?>checked<?php endif; ?>>Filtrar por categorías</label>

					</div>

					<div id="div_categorias" class="form-group" <?php if (!$submit || (isset($categorias_seleccionadas) && !$categorias_seleccionadas)): ?>style="display: none;"<?php endif; ?>>

						<div class="row">

							<div class="col-md-5">

								<label>Categorias disponibles</label>

								<select id="categorias" class="form-control" multiple>

									<?php if (isset($categorias) && $categorias): ?>

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

									<?php if (isset($categorias_seleccionadas) && $categorias_seleccionadas): ?>

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

					<div class="checkbox">

						<label><input type="checkbox" id="con_autor" name="con_autor" <?php if ($submit && (isset($id_autor) && $id_autor)): ?>checked<?php endif; ?>>Filtrar por autor</label>

					</div>

					<div id="div_autor" class="form-group" <?php if (!$submit || (isset($id_autor) && !$id_autor)): ?>style="display: none;"<?php endif; ?>>

						<select id="id_autor" name="id_autor" class="form-control">

							<?php if ($autores): ?>

								<?php foreach ($autores as $autor): ?>

									<option value="<?= $autor->id ?>" <?php if ($submit && isset($id_autor) && $autor->id = $id_autor): ?>selected<?php endif; ?>><?= $autor->nombre_completo ?></option>

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

					<?php if ($this->session->userdata("rol") != "usuario"): ?>

						<div class="checkbox">

							<label><input type="checkbox" id="con_institucion" name="con_institucion" <?php if ($submit && (isset($id_institucion) && $id_institucion)): ?>checked<?php endif; ?>>Filtrar por institución</label>

						</div>

						<div id="div_institucion" class="form-group" <?php if (!$submit || (isset($id_institucion) && !$id_institucion)): ?>style="display: none;"<?php endif; ?>>

							<select id="id_institucion" name="id_institucion" class="form-control">

								<?php if ($instituciones): ?>

									<?php foreach ($instituciones as $institucion): ?>

										<option value="<?= $institucion->id ?>" <?php if ($submit && isset($id_institucion) && $institucion->id == $id_institucion): ?>selected<?php endif; ?>><?= $institucion->nombre ?></option>

									<?php endforeach; ?>

								<?php endif; ?>

							</select>

						</div>

					<?php else: ?>

						<input type="hidden" id="con_institucion" name="con_institucion" value="on">

						<input type="hidden" id="id_institucion" name="id_institucion" value="<?= $this->session->userdata("id_institucion") ?>">

					<?php endif; ?>

				<?php else: ?>

					<label>Institución</label>

					<p>No se registraron instituciones.</p>

				<?php endif; ?>

			<?php endif; ?>

			<?php if ($fuente == "evento"): ?>

				<div class="checkbox">

					<label><input type="checkbox" id="con_fecha" name="con_fecha" <?php if ($submit && isset($id_fecha) && $id_fecha): ?>checked<?php endif; ?>>Filtrar por fecha</label>

				</div>

				<div id="div_fecha" <?php if (!$submit || (isset($id_fecha) && !$id_fecha)): ?>style="display: none;"<?php endif; ?>>

					<div class="radio">

						<label><input type="radio" name="fecha" value="proximos" <?php if (!$submit || (isset($id_fecha) && ($id_fecha == "proximos" || !$id_fecha))): ?>checked<?php endif; ?>>Sólo eventos próximos</label>

					</div>

					<div class="radio">

						<label><input type="radio" name="fecha" value="todos" <?php if ($submit && isset($id_fecha) && $id_fecha == "todos"): ?>checked<?php endif; ?>>Todos los eventos</label>

					</div>

				</div>

			<?php endif; ?>

			<?php if ($fuente == "evento"): ?>

				<div class="checkbox">

					<label><input type="checkbox" id="con_pais" name="con_pais" <?php if ($submit && isset($id_pais) && $id_pais): ?>checked<?php endif; ?>>Filtrar por país</label>

				</div>

				<div id="div_pais" <?php if (!$submit || (isset($id_pais) && !$id_pais)): ?>style="display: none;"<?php endif; ?>>

					<div class="form-group">

						<select id="pais" name="pais" class="form-control">

							<?php if ($paises): ?>

								<?php foreach ($paises as $pais): ?>

									<option value="<?= $pais->id ?>" <?php if ($submit && isset($id_pais) && $pais->id == $id_pais): ?>selected<?php endif; ?>><?= $pais->nombre ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

						<?= form_error("pais") ?>

					</div>

					<div class="checkbox">

						<label><input type="checkbox" id="con_ciudad" name="con_ciudad" <?php if ($submit && isset($id_ciudad) && $id_ciudad): ?>checked<?php endif; ?>>Filtrar por ciudad</label>

					</div>

					<div id="div_ciudad" class="form-group" <?php if (!$submit || (isset($id_ciudad) && !$id_ciudad)): ?>style="display: none;"<?php endif; ?>>

						<select id="ciudad" name="ciudad" class="form-control">

							<?php if ($ciudades): ?>

								<?php foreach ($ciudades as $ciudad): ?>

									<option value="<?= $ciudad->id ?>" <?php if ($submit && isset($id_ciudad) && $ciudad->id == $id_ciudad): ?>selected<?php endif; ?>><?= $ciudad->nombre ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

						<?= form_error("pais") ?>

					</div>

				</div>

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

		<?php if ($fuente == "articulo"): ?>

			<h4>Artículos relacionados</h4>

			<?php if ($articulos): ?>

				<?php foreach ($articulos as $articulo): ?>

					<div class="row contenido-pagina">

						<div class="col-md-3">

							<img src="<?= base_url($path_articulos . $articulo->imagen) ?>" class="img-responsive">

						</div>

						<div class="col-md-9">

							<h4><?= $articulo->nombre ?></h4>

							<p class="text-justify"><?= $articulo->descripcion ?></p>

							<div class="row">

								<?php if ($articulo->autores): ?>

									<div class="col-md-4">

										<h4>Autores</h4>

										<ul>

											<?php foreach ($articulo->autores as $autor): ?>

												<li><?= $autor->nombre_completo ?></li>

											<?php endforeach; ?>

										</ul>

									</div>

								<?php endif; ?>

								<?php if ($articulo->categorias): ?>

									<div class="col-md-4">

										<h4>Categorias</h4>

										<ul>

											<?php foreach ($articulo->categorias as $categoria): ?>

												<li><?= $categoria->nombre ?></li>

											<?php endforeach; ?>

										</ul>

									</div>

								<?php endif; ?>

								<?php if ($articulo->instituciones): ?>

									<div class="col-md-4">

										<h4>Instituciones</h4>

										<ul>

											<?php foreach ($articulo->instituciones as $institucion): ?>

												<li><?= $institucion->nombre ?></li>

											<?php endforeach; ?>

										</ul>

									</div>

								<?php endif; ?>

							</div>

							<a href="<?= base_url("articulo/ver_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Ver</a>

							<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

								<a href="<?= base_url("articulo/modificar_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>

								<a href="<?= base_url("articulo/eliminar_articulo/" . $articulo->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>

							<?php endif; ?>

						</div>

					</div>

				<?php endforeach; ?>

			<?php else: ?>

				<div class="contenido">

					<p>No se registraron articulos.</p>

				</div>

			<?php endif; ?>

		<?php endif; ?>

		<?php if ($fuente == "evento"): ?>

			<?php if ($eventos): ?>

				<?php foreach ($eventos as $evento): ?>

					<div class="row contenido-pagina">

						<div class="col-md-3">

							<img src="<?= base_url($path_evento . $evento->imagen) ?>" class="img-responsive img-center">

						</div>

						<div class="col-md-9">

							<h4><?= $evento->nombre ?></h4>

							<p class="text-justify"><?= $evento->descripcion ?></p>

							<p><label>Fecha de inicio:</label> <?= $evento->fecha_inicio ?></p>

							<p><label>Fecha de fin:</label> <?= $evento->fecha_fin ?></p>

							<p><label>Lugar:</label> <?= $evento->direccion . ", " . $evento->ciudad->nombre . ", " . $evento->pais->nombre ?></p>

							<div class="row">

								<?php if ($evento->instituciones): ?>

									<div class="col-md-6">

										<h4>Instituciones</h4>

										<ul>

											<?php foreach ($evento->instituciones as $institucion): ?>

												<li><?= $institucion->nombre ?></li>

											<?php endforeach; ?>

										</ul>

									</div>

								<?php endif; ?>

								<?php if ($evento->categorias): ?>

									<div class="col-md-6">

										<h4>Categorias</h4>

										<ul>

											<?php foreach ($evento->categorias as $categoria): ?>

												<li><?= $categoria->nombre ?></li>

											<?php endforeach; ?>

										</ul>

									</div>

								<?php endif; ?>

							</div>

							<a href="<?= base_url("evento/ver_evento/" . $evento->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Ver</a>

							<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

								<a href="<?= base_url("evento/modificar_evento/" . $evento->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>

							<?php endif; ?>

							<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

								<a href="<?= base_url("evento/eliminar_evento/" . $evento->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>

							<?php endif; ?>

						</div>

					</div>

				<?php endforeach; ?>

			<?php else: ?>

				<div class="contenido">

					<p>No se registraron eventos.</p>

				</div>

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
		$("#id_categoria > option").each(function() {
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
	$("#con_fecha").click(function() {
		if ($(this).prop("checked") == true) {
			$("#div_fecha").show(300);
		} else {
			$("#div_fecha").hide(300);
		}
	});

	$("#con_pais").click(function() {
		if ($(this).prop("checked") == true) {
			$("#div_pais").show(300);
		} else {
			$("#div_pais").hide(300);
		}
	});

	$("#con_ciudad").click(function() {
		if ($(this).prop("checked") == true) {
			$("#div_ciudad").show(300);
		} else {
			$("#div_ciudad").hide(300);
		}
	});

	$("#activar_busqueda").click(function(event) {
		event.preventDefault();
		$("#div_busqueda").toggle(500);
	});

	$("#pais").on("change", function() {
		var id_pais = $(this).find("option:selected").prop("value");
		$.ajax({
			url: "<?= base_url("evento/get_ciudades_ajax") ?>",
			method: "POST",
			data: {
				id_pais: id_pais
			}, dataType: "json"}).done(function(response) {
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
</script>

<?php $this->load->view("base/footer"); ?>