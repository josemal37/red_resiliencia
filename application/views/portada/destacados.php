<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ((isset($eventos_proximos) && $eventos_proximos) || (isset($articulos_recientes) && $articulos_recientes) || (isset($publicaciones_recientes) && $publicaciones_recientes)): ?>

	<div id="destacados" class="carousel slide carousel-fade destacados" data-ride="carousel">

		<ol class="carousel-indicators">

			<?php $i = 0; ?>

			<?php if (isset($eventos_proximos) && $eventos_proximos): ?>

				<?php for ($j = 0; $j < sizeof($eventos_proximos); $j = $j + 1): ?>

					<li data-target="#destacados" data-slide-to="<?= $i ?>" <?php if ($i == 0): ?>class="active"<?php endif; ?>></li>

					<?php $i += 1; ?>

				<?php endfor; ?>

			<?php endif; ?>

			<?php if (isset($articulos_recientes) && $articulos_recientes): ?>

				<?php for ($j = 0; $j < sizeof($articulos_recientes); $j = $j + 1): ?>

					<li data-target="#destacados" data-slide-to="<?= $i ?>" <?php if ($i == 0): ?>class="active"<?php endif; ?>></li>

					<?php $i += 1; ?>

				<?php endfor; ?>

			<?php endif; ?>

			<?php if (isset($publicaciones_recientes) && $publicaciones_recientes): ?>

				<?php for ($j = 0; $j < sizeof($publicaciones_recientes); $j = $j + 1): ?>

					<li data-target="#destacados" data-slide-to="<?= $i ?>" <?php if ($i == 0): ?>class="active"<?php endif; ?>></li>

					<?php $i += 1; ?>

				<?php endfor; ?>

			<?php endif; ?>

		</ol>

		<div class="carousel-inner" role="listbox">

			<?php $i = 0; ?>

			<?php if (isset($eventos_proximos) && $eventos_proximos): ?>

				<?php foreach ($eventos_proximos as $evento): ?>

					<div class="item <?php if ($i == 0): ?>active<?php endif; ?>">

						<div class="row">

							<a href="<?= base_url("evento/ver_evento/" . $evento->id) ?>">

								<div class="col-sm-4 col-md-push-1 imagen-item" style="background-image: url('<?= base_url($path_evento . $evento->imagen) ?>');"></div>

							</a>

							<div class="col-md-5 col-sm-7 col-md-offset-1 hidden-xs contenido-item">

								<div>

									<?php if ($evento->nombre): ?>

										<h2><?= $evento->nombre ?></h2>

									<?php endif; ?>

									<?php if ($evento->descripcion): ?>

										<div class="descripcion text-ellipsis">

											<p class="text-justify"><?= $evento->descripcion ?></p>

										</div>

									<?php endif; ?>

									<?php if ($evento->ciudad || $evento->pais): ?>

										<p class="text-left"><label>Lugar:</label> <?php if ($evento->ciudad): ?><?= $evento->ciudad->nombre ?>, <?php endif; ?><?php if ($evento->pais): ?><?= $evento->pais->nombre ?><?php endif; ?></p>

									<?php endif; ?>

									<?php if ($evento->fecha_inicio || $evento->fecha_fin): ?>

										<p class="text-left"><?php if ($evento->fecha_inicio): ?><label>Inicio:</label> <?= $evento->fecha_inicio ?> <?php endif; ?><?php if ($evento->fecha_fin): ?><label>Fin:</label> <?= $evento->fecha_fin ?><?php endif; ?></p>

									<?php endif; ?>

									<?php if ($evento->instituciones): ?>

										<p class="text-left"><label>Instituciónes:</label> <?= listar_array_de_stdclass($evento->instituciones, "nombre", ", ") ?></p>

									<?php endif; ?>

									<a href="<?= base_url("evento/ver_evento/" . $evento->id) ?>" class="btn btn-primary btn-resiliencia pull-right">Ver evento</a>

								</div>

							</div>

						</div>

					</div>

					<?php $i += 1; ?>

				<?php endforeach; ?>

			<?php endif; ?>

			<?php if (isset($articulos_recientes) && $articulos_recientes): ?>

				<?php foreach ($articulos_recientes as $articulo): ?>

					<div class="item <?php if ($i == 0): ?>active<?php endif; ?>">

						<div class="row">

							<a href="<?= base_url("articulo/ver_articulo/" . $articulo->id) ?>">

								<div class="col-sm-4 col-md-push-1 imagen-item" style="background-image: url('<?= base_url($path_articulos . $articulo->imagen) ?>');"></div>

							</a>

							<div class="col-md-5 col-sm-7 col-md-offset-1 hidden-xs contenido-item">

								<div>

									<?php if ($articulo->nombre): ?>

										<h2><?= $articulo->nombre ?></h2>

									<?php endif; ?>

									<?php if ($articulo->descripcion): ?>

										<div class="descripcion text-ellipsis">

											<p class="text-justify"><?= $articulo->descripcion ?></p>

										</div>

									<?php endif; ?>

									<?php if ($articulo->autores): ?>

										<p class="text-left"><label>Autores:</label> <?= listar_array_de_stdclass($articulo->autores, "nombre_completo", ", ") ?></p>

									<?php endif; ?>

									<a href="<?= base_url("articulo/ver_articulo/" . $articulo->id) ?>"  class="btn btn-primary btn-resiliencia pull-right">Ver artículo</a>

								</div>

							</div>

						</div>

					</div>

					<?php $i += 1; ?>

				<?php endforeach; ?>

			<?php endif; ?>

			<?php if (isset($publicaciones_recientes) && $publicaciones_recientes): ?>

				<?php foreach ($publicaciones_recientes as $publicacion): ?>

					<div class="item <?php if ($i == 0): ?>active<?php endif; ?>">

						<div class="row">

							<a href="<?= base_url("publicacion/ver_publicacion/" . $publicacion->id) ?>">

								<div class="col-sm-4 col-md-push-1 imagen-item" style="background-image: url('<?= base_url($path_publicaciones . $publicacion->imagen) ?>');"></div>

							</a>

							<div class="col-md-5 col-sm-7 col-md-offset-1 hidden-xs contenido-item">

								<div>

									<?php if ($publicacion->nombre): ?>

										<h2><?= $publicacion->nombre ?></h2>

									<?php endif; ?>

									<?php if ($publicacion->descripcion): ?>

										<div class="descripcion text-ellipsis">

											<p class="text-justify"><?= $publicacion->descripcion ?></p>

										</div>

									<?php endif; ?>

									<?php if ($publicacion->autores): ?>

										<p class="text-left"><label>Autores:</label> <?= listar_array_de_stdclass($publicacion->autores, "nombre", ", ") ?></p>

									<?php endif; ?>

									<?php if ($publicacion->instituciones): ?>

										<p class="text-left"><label>Instituciones:</label> <?= listar_array_de_stdclass($publicacion->instituciones, "nombre", ", ") ?></p>

									<?php endif; ?>

									<a href="<?= base_url("publicacion/ver_publicacion/" . $publicacion->id) ?>" class="btn btn-primary btn-resiliencia pull-right">Ver publicación</a>

								</div>

							</div>

						</div>

					</div>

					<?php $i += 1; ?>

				<?php endforeach; ?>

			<?php endif; ?>

		</div>

		<a class="left carousel-control" href="#destacados" data-slide="prev">

			<span class="icon-prev"></span>

		</a>

		<a class="right carousel-control" href="#destacados" data-slide="next">

			<span class="icon-next"></span>

		</a>

	</div>

<?php endif; ?>