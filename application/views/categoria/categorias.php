<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<?php
$this->load->view("base/menu");
?>

<div class="pagina">

	<div class="titulo">

		<h1><?= $titulo ?></h1>

	</div>

	<div class="container contenido">

		<?php if ($categorias): ?>

			<table class="table table-bordered">

				<thead>

					<tr>

						<th>Nombre</th>
						<th>Acciones</th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($categorias as $categoria): ?>

						<tr id="<?= $categoria->id ?>">

							<td><?= $categoria->nombre ?></td>
							<td>
								<a href="<?= base_url("categoria/modificar_categoria/" . $categoria->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Modificar</a>
								
								<a href="<?= base_url("categoria/eliminar_categoria/" . $categoria->id) ?>" class="btn btn-default btn-resiliencia btn-xs">Eliminar</a>
							</td>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		<?php else: ?>

			<p>No se registraron categorias.</p>

		<?php endif; ?>

			<a href="<?= base_url("categoria/registrar_categoria") ?>" class="btn btn-default btn-resiliencia">Registrar categoria</a>

	</div>

	<?php if ($this->session->flashdata("no_existe")): ?><p><?= $this->session->flashdata("no_existe") ?></p><?php endif; ?>

</div>

<?php $this->load->view("base/footer"); ?>