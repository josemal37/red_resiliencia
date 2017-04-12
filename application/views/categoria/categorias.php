<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="pagina">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php
	$this->load->view("base/menu");
	?>

	<div class="pagina">

		<div class="titulo-pagina">

			<div class="container-fluid">

				<h1><?= $titulo ?></h1>

			</div>

		</div>

		<div class="contenido">

			<div class="container-fluid">

				<?php if ($categorias): ?>

					<table class="table table-bordered">

						<thead>

							<tr>

								<th>Nombre</th>

								<?php if ($this->session->userdata("rol") == "administrador"): ?>

									<th>Acciones</th>

								<?php endif; ?>

							</tr>

						</thead>

						<tbody>

							<?php foreach ($categorias as $categoria): ?>

								<tr id="<?= $categoria->id ?>">

									<td><?= $categoria->nombre ?></td>

									<?php if ($this->session->userdata("rol") == "administrador"): ?>

										<td>
											<a href="<?= base_url("categoria/modificar_categoria/" . $categoria->id) ?>" class="btn btn-default btn-xs">Modificar</a>

											<a href="<?= base_url("categoria/eliminar_categoria/" . $categoria->id) ?>" class="btn btn-default btn-xs">Eliminar</a>

										</td>

									<?php endif; ?>

								</tr>

							<?php endforeach; ?>

						</tbody>

					</table>

				<?php else: ?>

					<p>No se registraron categorias.</p>

				<?php endif; ?>

				<a href="<?= base_url("categoria/registrar_categoria") ?>" class="btn btn-default btn-resiliencia">Registrar categoria</a>

			</div>

		</div>

		<?php if ($this->session->flashdata("no_existe")): ?><p><?= $this->session->flashdata("no_existe") ?></p><?php endif; ?>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>