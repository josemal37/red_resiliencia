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

        <header class=" header text-center">

            <h1><?= $titulo ?></h1>

        </header>

		<?php if (isset($articulos)): ?>

			<!-- Articulos -->
			<section id="articulos" class="container">

				<h2>Artículos</h2>

				<?php if ($articulos): ?>

					<div class="row">

						<?php foreach ($articulos as $articulo): ?>

							<h3><?= $articulo->nombre ?></h3>

						<?php endforeach; ?>

					</div>

				<?php else: ?>

					<p>Sin artículos.</p>

				<?php endif; ?>

			</section>

		<?php endif; ?>

		<?php if (isset($publicaciones)): ?>

			<!-- Publicaciones -->
			<section id="publicaciones" class="container">

				<h2>Publicaciones</h2>

				<?php if ($publicaciones): ?>

					<?php foreach ($publicaciones as $publicacion): ?>

						<div class="row">

							<div class="col-md-3">

								<?php if ($publicacion->imagen != ""): ?>

									<img src="<?= base_url($path_publicaciones . $publicacion->imagen) ?>" alt="<?= $publicacion->nombre ?>" class="img-responsive">

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

							</div>

							<div class="clearfix visible-md-block visible-lg-block"></div>

						</div>

					<?php endforeach; ?>

				<?php else: ?>

					<p>Sin publicaciones.</p>

				<?php endif; ?>

			</section>

		<?php endif; ?>

    </body>

</html>