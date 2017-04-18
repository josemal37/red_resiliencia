<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$url = "";
$avanzada = "";
switch ($fuente) {
	case "publicacion":
		$url = base_url("publicacion/publicaciones");
		$avanzada = base_url("publicacion/busqueda_avanzada");
		break;
	case "evento":
		$url = base_url("evento/eventos");
		$avanzada = base_url("evento/busqueda_avanzada");
		break;
	case "articulo":
		$url = base_url("articulo/articulos");
		$avanzada = base_url("articulo/busqueda_avanzada");
		break;
	case "herramienta":
		$url = base_url("herramienta/herramientas");
		$avanzada = base_url("herramienta/busqueda_avanzada");
		break;
}
?>

<div class="busqueda">

	<div class="container">

		<form action="<?= $url ?>" id="form-busqueda" method="get">

			<div class="form-group">

				<label>Busqueda</label>

				<input type="text" id="criterio" name="criterio" class="tokenfield form-control" placeholder="Introduzca criterios de busqueda" <?php if ($criterio): ?>value="<?= $criterio ?>"<?php endif; ?>>

			</div>

			<div class="row">

				<?php if ($fuente == "articulo"): ?>

					<?php if ($this->session->userdata("rol") == "usuario"): ?>

						<div class="col-md-6">

							<div class="form-group">

								<label>Categoría</label>

								<select id="categoria" name="categoria" class="form-control">

									<option value="">-- Seleccione una categoría --</option>

									<?php if (isset($categorias) && $categorias): ?>

										<?php foreach ($categorias as $categoria): ?>

											<option value="<?= $categoria->id ?>" <?php if (isset($id_categoria) && $categoria->id == $id_categoria): ?>selected<?php endif; ?>><?= $categoria->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<label>Autor</label>

								<select id="autor" name="autor" class="form-control">

									<option value="">-- Seleccione un autor --</option>

									<?php if (isset($autores) && $autores): ?>

										<?php foreach ($autores as $autor): ?>

											<option value="<?= $autor->id ?>" <?php if (isset($id_autor) && $autor->id == $id_autor): ?>selected<?php endif; ?>><?= $autor->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

					<?php else: ?>

						<div class="col-md-4">

							<div class="form-group">

								<label>Categoría</label>

								<select id="categoria" name="categoria" class="form-control">

									<option value="">-- Seleccione una categoría --</option>

									<?php if (isset($categorias) && $categorias): ?>

										<?php foreach ($categorias as $categoria): ?>

											<option value="<?= $categoria->id ?>" <?php if (isset($id_categoria) && $categoria->id == $id_categoria): ?>selected<?php endif; ?>><?= $categoria->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label>Autor</label>

								<select id="autor" name="autor" class="form-control">

									<option value="">-- Seleccione un autor --</option>

									<?php if (isset($autores) && $autores): ?>

										<?php foreach ($autores as $autor): ?>

											<option value="<?= $autor->id ?>" <?php if (isset($id_autor) && $autor->id == $id_autor): ?>selected<?php endif; ?>><?= $autor->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label>Institución</label>

								<select id="institucion" name="institucion" class="form-control">

									<option value="">-- Seleccione una institución --</option>

									<?php if (isset($instituciones) && $instituciones): ?>

										<?php foreach ($instituciones as $institucion): ?>

											<option value="<?= $institucion->id ?>" <?php if (isset($id_institucion) && $institucion->id == $id_institucion): ?>selected<?php endif; ?>><?= $institucion->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

					<?php endif; ?>
				<?php elseif ($fuente == "evento"): ?>

				<?php elseif ($fuente == "herramienta"): ?>

				<?php elseif ($fuente == "publicacion"): ?>

					<?php if ($this->session->userdata("rol")): ?>

						<div class="col-md-4">

							<div class="form-group">

								<label>Categoría</label>

								<select id="categoria" name="categoria" class="form-control">

									<option value="">-- Seleccione una categoría --</option>

									<?php if (isset($categorias) && $categorias): ?>

										<?php foreach ($categorias as $categoria): ?>

											<option value="<?= $categoria->id ?>" <?php if (isset($id_categoria) && $categoria->id == $id_categoria): ?>selected<?php endif; ?>><?= $categoria->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label>Año</label>

								<select id="anio" name="anio" class="form-control">

									<option value="">-- Seleccione un año --</option>

									<?php if (isset($anios) && $anios): ?>

										<?php foreach ($anios as $anio): ?>

											<option value="<?= $anio->id ?>" <?php if (isset($id_anio) && $anio->id == $id_anio): ?>selected<?php endif; ?>><?= $anio->anio ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label>Autor</label>

								<select id="autor" name="autor" class="form-control">

									<option value="">-- Seleccione un autor --</option>

									<?php if (isset($autores) && $autores): ?>

										<?php foreach ($autores as $autor): ?>

											<option value="<?= $autor->id ?>" <?php if (isset($id_autor) && $autor->id == $id_autor): ?>selected<?php endif; ?>><?= $autor->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

					<?php else: ?>

						<div class="col-md-3">

							<div class="form-group">

								<label>Categoría</label>

								<select id="categoria" name="categoria" class="form-control">

									<option value="">-- Seleccione una categoría --</option>

									<?php if (isset($categorias) && $categorias): ?>

										<?php foreach ($categorias as $categoria): ?>

											<option value="<?= $categoria->id ?>" <?php if (isset($id_categoria) && $categoria->id == $id_categoria): ?>selected<?php endif; ?>><?= $categoria->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

						<div class="col-md-3">

							<div class="form-group">

								<label>Año</label>

								<select id="anio" name="anio" class="form-control">

									<option value="">-- Seleccione un año --</option>

									<?php if (isset($anios) && $anios): ?>

										<?php foreach ($anios as $anio): ?>

											<option value="<?= $anio->id ?>" <?php if (isset($id_anio) && $anio->id == $id_anio): ?>selected<?php endif; ?>><?= $anio->anio ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

						<div class="col-md-3">

							<div class="form-group">

								<label>Autor</label>

								<select id="autor" name="autor" class="form-control">

									<option value="">-- Seleccione un autor --</option>

									<?php if (isset($autores) && $autores): ?>

										<?php foreach ($autores as $autor): ?>

											<option value="<?= $autor->id ?>" <?php if (isset($id_autor) && $autor->id == $id_autor): ?>selected<?php endif; ?>><?= $autor->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

						<div class="col-md-3">

							<div class="form-group">

								<label>Institución</label>

								<select id="institucion" name="institucion" class="form-control">

									<option value="">-- Seleccione una institución --</option>

									<?php if (isset($instituciones) && $instituciones): ?>

										<?php foreach ($instituciones as $institucion): ?>

											<option value="<?= $institucion->id ?>" <?php if (isset($id_institucion) && $institucion->id == $id_institucion): ?>selected<?php endif; ?>><?= $institucion->nombre ?></option>

										<?php endforeach; ?>

									<?php endif; ?>

								</select>

							</div>

						</div>

					<?php endif; ?>

				<?php endif; ?>

			</div>

			<div class="form-group text-right">

				<input type="submit" id="submit" name="submit" value="Buscar" class="btn btn-primary">

			</div>

		</form>

	</div>

	<?php if (isset($submit)): ?>

		<div class="container-fluid">

			<?php
			switch ($fuente) {
				case "publicacion":
					?>

					<h4>Publicaciones relacionadas:</h4>

					<?php
					break;
				case "evento":
					?>

					<h4>Eventos relacionados:</h4>

					<?php
					break;

				case "articulo":
					?>

					<h4>Artículos relacionados:</h4>

					<?php
					break;

				case "herramienta":
					?>

					<h4>Herramientas relacionadas:</h4>

				<?php
			}
			?>

		</div>

	<?php endif; ?>

</div>