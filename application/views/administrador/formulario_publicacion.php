<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <!-- Metadatos -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Titulo -->
        <title><?= $titulo ?></title>

        <!-- jQuery -->
        <script src="<?= base_url('assets/jquery-2.0.3/jquery.js') ?>"></script>

        <!-- Bootstrap -->
        <script src="<?= base_url('assets/bootstrap-3.3.7/js/bootstrap.js') ?>"></script>
        <link href="<?= base_url('assets/bootstrap-3.3.7/css/bootstrap.css') ?>" rel="stylesheet">

        <!--[if lt IE 9]>
		
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script
		
        <![endif]-->

    </head>

    <body>

        <div>

            <h1><?= $titulo ?></h1>

        </div>

        <div>

			<?php
			switch ($accion) {
				case "registrar":
					$url = base_url("administrador/" . $accion . "_publicacion");
					break;
				case "modificar":
					$url = base_url("administrador/" . $accion . "_publicacion/" . $publicacion->id);
					break;
			}
			?>

			<form action="<?= $url ?>" method="post" enctype="multipart/form-data" autocomplete="off">

				<div>

					<label>Nombre</label>
					<input type="text" id="nombre" name="nombre" <?php if ($accion == "modificar"): ?>value="<?= $publicacion->nombre ?>"<?php endif; ?>>
					<?= form_error("nombre") ?>

				</div>

				<div>

					<label>Descripción</label>
					<textarea id="descripcion" name="descripcion"><?php if ($accion == "modificar"): ?><?= $publicacion->descripcion ?><?php endif; ?></textarea>
					<?= form_error("descripcion") ?>

				</div>

				<div>

					<label>Imagen</label>
					<input type="file" id="imagen" name="imagen">
					<?= form_error("imagen") ?>

				</div>

				<div>

					<label>Documento</label>
					<input type="file" id="url" name="url">
					<?php if ($accion == "modificar"): ?>
						<a href="<?= base_url($publicacion->imagen) ?>">descargar</a>
					<?php endif; ?>
					<?= form_error("url") ?>

				</div>

				<?php if ($autores): ?>

					<div>

						<label>Autor(es)</label>

						<div>

							<select id="autores" multiple>

								<?php foreach ($autores as $autor): ?>

									<?php
									$autor->nombre_completo = $autor->nombre;

									if ($autor->apellido_paterno != "") {
										$autor->nombre_completo = $autor->nombre_completo . " " . $autor->apellido_paterno;
									}

									if ($autor->apellido_materno != "") {
										$autor->nombre_completo = $autor->nombre_completo . " " . $autor->apellido_materno;
									}
									?>

									<option value="<?= $autor->id ?>"><?= $autor->nombre_completo ?></option>

								<?php endforeach; ?>

							</select>

						</div>

						<div>

							<button id="agregar_autor" class="agregar">Agregar ></button>
							<button id="quitar_autor" class="quitar">< Quitar</button>

						</div>

						<div>

							<select id="id_autor" name="id_autor[]" multiple="">



							</select>

						</div>

					</div>

				<?php endif; ?>

				<?php if ($categorias): ?>

					<div>

						<label>Categoria(s)</label>

						<div>

							<select id="categorias" multiple>

								<?php foreach ($categorias as $categoria): ?>

									<option value="<?= $categoria->id ?>"><?= $categoria->nombre ?></option>

								<?php endforeach; ?>

							</select>

						</div>

						<div>

							<button id="agregar_categoria" class="agregar">Agregar ></button>
							<button id="quitar_categoria" class="quitar">< Quitar</button>

						</div>

						<div>

							<select id="id_categoria" name="id_categoria[]" multiple>



							</select>

						</div>

					</div>

				<?php endif; ?>

				<?php if ($instituciones): ?>

					<div>

						<label>Institución(es)</label>

						<div>

							<select id="instituciones" multiple>

								<?php foreach ($instituciones as $institucion): ?>

									<option value="<?= $institucion->id ?>"><?= $institucion->nombre ?></option>

								<?php endforeach; ?>

							</select>

						</div>

						<div>

							<button id="agregar_institucion" class="agregar">Agregar ></button>
							<button id="quitar_institucion" class="quitar">< Quitar</button>

						</div>

						<div>

							<select id="id_institucion" name="id_institucion[]" multiple>



							</select>

						</div>

					</div>

				<?php endif; ?>

				<input type="submit" id="submit" name="submit" value="Aceptar">

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
				$('.quitar').click(function(e) {
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
			});

		</script>

	</body>

</html>