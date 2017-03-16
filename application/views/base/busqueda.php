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
		$avanzada = base_url("evento/busqueda_avanzada");
		break;
}
?>

<form action="<?= $url ?>" id="form-busqueda" method="get">

	<div class="row">

		<div class="col-md-5 col-md-offset-6 col-sm-9 col-xs-8">

			<div class="form-group">

				<input type="text" id="criterio" name="criterio" class="form-control tokenfield" <?php if ($criterio): ?>value="<?= $criterio ?>"<?php endif; ?>>

			</div>

		</div>

		<div class="col-md-1 col-xs-1">

			<input type="submit" id="submit" name="submit" value="Buscar" class="btn btn-primary">

		</div>

	</div>

</form>

<a href="<?= $avanzada ?>" class="pull-right">Busqueda avanzada</a>

<?php if ($criterio): ?>

	<div class="mensaje-busqueda">

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
		}
		?>

	</div>

<?php endif; ?>