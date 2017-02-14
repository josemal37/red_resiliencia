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

			<?php if ($publicaciones): ?>

				<?php foreach ($publicaciones as $publicacion): ?>

					<div class="row">

						<div class="col-md-3">

							<?php if ($publicacion->imagen != ""): ?>

								<img src="<?= $publicacion->imagen ?>" alt="<?= $publicacion->nombre ?>" class="img-responsive">

							<?php endif; ?>

						</div>

						<div class="col-md-9">

							<h4><?= $publicacion->nombre ?></h4>

							<p><?= $publicacion->descripcion ?></p>

							<?php if ($publicacion->modulos): ?>

								<h4>Modulos</h4>

								<ol>

									<?php foreach ($publicacion->modulos as $modulo): ?>

										<li><?= $modulo->nombre ?></li>

									<?php endforeach; ?>

								</ol>

							<?php endif; ?>

							<?php if ($publicacion->url != ""): ?>

								<a href="<?= $publicacion->url ?>">Descargar</a>

							<?php endif; ?>

							<?php if ($publicacion->autores): ?>

								<h4>Autores</h4>

								<ul>

									<?php foreach ($publicacion->autores as $autor): ?>

										<li><?= $autor->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							<?php endif; ?>

							<?php if ($publicacion->categorias): ?>

								<h4>Categorias</h4>

								<ul>

									<?php foreach ($publicacion->categorias as $categoria): ?>

										<li><?= $categoria->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							<?php endif; ?>

							<?php if ($publicacion->instituciones): ?>

								<h4>Intituciones</h4>

								<ul>

									<?php foreach ($publicacion->instituciones as $institucion): ?>

										<li><?= $institucion->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							<?php endif; ?>

						</div>

						<div class="clearfix visible-md-block visible-lg-block"></div>

					</div>

				<?php endforeach; ?>

			<?php else: ?>

				<p>No se registraron publicaciones.</p>

			<?php endif; ?>

			<a href="<?= base_url("administrador/registrar_publicacion") ?>">Registrar publicación</a>

		</div>

	</body>

</html>