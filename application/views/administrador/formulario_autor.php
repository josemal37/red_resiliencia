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

        <div class="text-center">

            <h1><?= $titulo ?></h1>

        </div>

        <div class="container">

			<?php
			switch ($accion) {
				case "registrar":
					$url = base_url("administrador/" . $accion . "_autor");
					break;
				case "modificar":
					$url = base_url("administrador/" . $accion . "_autor/" . $autor->id);
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

					<?php if ($instituciones || $autor->instituciones): ?>

						<div class="row">

							<div class="col-md-5">

								<label>Instituciones disponibles</label>

								<select id="instituciones" multiple class="form-control">

									<?php foreach ($instituciones as $institucion): ?>

										<option value="<?= $institucion->id ?>"><?= $institucion->nombre ?></option>

									<?php endforeach; ?>

								</select>

							</div>

							<div class="col-md-2">

								<button id="agregar_institucion" class="agregar">Agregar ></button>
								<button id="quitar_institucion" class="quitar">< Quitar</button>

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

				$("#form_autor").submit(function() {
					$("option").each(function(){
						$(this).prop("selected", "selected");
					});
				});
			});

		</script>

    </body>

</html>
