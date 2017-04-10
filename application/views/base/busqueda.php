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

	<div class="container-fluid">

		<div class="row">

			<div class="col-md-6"></div>

			<div class="col-md-6">

				<form action="<?= $url ?>" id="form-busqueda" method="get">

					<div class="form-group">

						<div class="input-group">

							<input type="text" id="criterio" name="criterio" class="tokenfield form-control" <?php if ($criterio): ?>value="<?= $criterio ?>"<?php endif; ?>>

							<span class="input-group-btn">

								<input type="submit" id="submit" name="submit" value="Buscar" class="btn btn-primary">

							</span>

						</div>

					</div>

				</form>

				<a href="<?= $avanzada ?>">Busqueda avanzada</a>

			</div>

		</div>

	</div>

	<?php if ($criterio): ?>

		<div class="container-fluid">

			<?php
			switch ($fuente) {
				case "publicacion":
					?>

					<h4>Publicaciones relacionadas con la(s) palabra(s) <strong>"<?= $criterio ?>"</strong></h4>

					<?php
					break;
				case "evento":
					?>

					<h4>Eventos relacionados con la(s) palabra(s) <strong>"<?= $criterio ?>"</strong></h4>

					<?php
					break;

				case "articulo":
					?>

					<h4>Artículos relacionados con la(s) palabra(s) <strong>"<?= $criterio ?>"</strong></h4>

					<?php
					break;

				case "herramienta":
					?>

					<h4>Herramientas relacionadas con la(s) palabra(s) <strong>"<?= $criterio ?>"</strong></h4>

				<?php
			}
			?>

		</div>

	<?php endif; ?>

</div>