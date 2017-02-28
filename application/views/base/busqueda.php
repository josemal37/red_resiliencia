<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$url = "";
switch ($fuente) {
	case "publicacion":
		$url = base_url("publicacion/publicaciones");
		break;
}
$categorias = $this->Modelo_categoria->select_categorias();
$nombre_categorias = array();
foreach ($categorias as $categoria) {
	$nombre_categorias[] = $categoria->nombre;
}
?>

<form action="<?= $url ?>" id="form-busqueda" method="get">

	<div class="row">

		<div class="col-md-5 col-md-offset-6 col-xs-10">

			<div class="form-group">

				<input type="text" id="criterio" name="criterio" class="form-control">

			</div>

		</div>

		<div class="col-md-1 col-xs-1">

			<input type="submit" id="submit" name="submit" value="Buscar" class="btn btn-primary">

		</div>

	</div>

</form>