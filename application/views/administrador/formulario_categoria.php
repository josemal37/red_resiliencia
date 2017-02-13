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
			//definimos la url del formulario
			switch ($accion) {
				case "registrar":
					$url = base_url("administrador/" . $accion . "_categoria");
					break;
				case "modificar":
					$url = base_url("administrador/" . $accion . "_categoria/" . $categoria->id);
					break;
			}
			?>

			<form action="<?= $url ?>" method="post" autocomplete="off">

				<div class="form-group">

					<label>Nombre</label>
					<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar"): ?>value="<?= $categoria->nombre ?>"<?php endif; ?>>
					<?= form_error("nombre") ?>

				</div>

				<?php if ($accion == "modificar"): ?>

					<input type="hidden" id="id" name="id" value="<?= $categoria->id ?>">

				<?php endif; ?>

				<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Aceptar">

			</form>

        </div>

    </body>

</html>