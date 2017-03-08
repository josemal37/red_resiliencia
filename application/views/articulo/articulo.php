<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="header text-center">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container contenido contenido-mce">

	<?php $this->load->ext_view("articulos", $articulo->url) ?>

</div>

<?php $this->load->view("base/footer"); ?>