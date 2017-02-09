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

			<?php if ($publicaciones): ?>

				<div>

					<?php foreach ($publicaciones as $publicacion): ?>

						<div>

							<h2><?= $publicacion->nombre ?></h2>

							<?php if ($publicacion->imagen != ""): ?>
								<img src="<?= $publicacion->imagen ?>">
							<?php endif; ?>

							<p><?= $publicacion->descripcion ?></p>

							<?php if ($publicacion->url != ""): ?>
								<a href="<?= $publicacion->url ?>">Descargar</a>
							<?php endif; ?>

						</div>

					<?php endforeach; ?>

				</div>

			<?php else: ?>

				<p>No se registraron publicaciones.</p>

			<?php endif; ?>

			<a href="<?= base_url("administrador/registrar_publicacion") ?>">Registrar publicación</a>

		</div>

	</body>

</html>