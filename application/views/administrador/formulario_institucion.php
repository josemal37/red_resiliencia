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
					$url = base_url("administrador/" . $accion . "_institucion");
					break;
				case "modificar":
					$url = base_url("administrador/" . $accion . "_institucion/" . $institucion->id);
					break;
			}
			?>

            <form action="<?= $url ?>" method="post" autocomplete="off">

                <div>

                    <label>Nombre</label>
                    <input type="text" id="nombre" name="nombre" <?php if ($accion == "modificar"): ?>value="<?= $institucion->nombre ?>"<?php endif; ?>>
					<?= form_error("nombre") ?>

                </div>
				
				<div>

                    <label>Sigla</label>
                    <input type="text" id="sigla" name="sigla" <?php if ($accion == "modificar"): ?>value="<?= $institucion->sigla ?>"<?php endif; ?>>
					<?= form_error("sigla") ?>

                </div>

				<?php if ($accion == "modificar"): ?>

					<input type="hidden" id="id" name="id" value="<?= $institucion->id ?>">

				<?php endif; ?>

                <input type="submit" id="submit" name="submit" value="Aceptar">

            </form>

        </div>

    </body>

</html>
