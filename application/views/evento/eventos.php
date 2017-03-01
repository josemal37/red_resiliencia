<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center">

	<h1><?= $titulo ?></h1>

</div>

<?php $this->load->view("base/menu"); ?>

<div class="container">

	<?php if ($eventos): ?>

		<?php foreach ($eventos as $evento): ?>

			<div class="row">

				<div class="col-md-3">

					<img src="<?= base_url($path_evento . $evento->imagen) ?>" class="img-responsive">

				</div>

				<div class="col-md-9">

					<h4><?= $evento->nombre ?></h4>

					<p class="text-justify"><?= $evento->descripcion ?></p>

					<p><label>Fecha de inicio:</label> <?= $evento->fecha_inicio ?></p>

					<p><label>Fecha de fin:</label> <?= $evento->fecha_fin ?></p>

					<p><label>Lugar:</label> <?= $evento->direccion . ", " . $evento->ciudad->nombre . ", " . $evento->pais->nombre ?></p>

					<div class="row">

						<?php if ($evento->instituciones): ?>

							<div class="col-md-6">

								<h4>Instituciones</h4>

								<ul>

									<?php foreach ($evento->instituciones as $institucion): ?>

										<li><?= $institucion->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							</div>

						<?php endif; ?>

						<?php if ($evento->categorias): ?>

							<div class="col-md-6">

								<h4>Categorias</h4>

								<ul>

									<?php foreach ($evento->categorias as $categoria): ?>

										<li><?= $categoria->nombre ?></li>

									<?php endforeach; ?>

								</ul>

							</div>

						<?php endif; ?>

					</div>

					<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

						<a href="<?= base_url("evento/modificar_evento/" . $evento->id) ?>">Modificar</a>

					<?php endif; ?>

					<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

						<a href="<?= base_url("evento/eliminar_evento/" . $evento->id) ?>">Eliminar</a>

					<?php endif; ?>

				</div>

			</div>

		<?php endforeach; ?>

	<?php else: ?>

		<p>No se registraron eventos.</p>

	<?php endif; ?>

	<?php if ($this->session->flashdata("error")): ?><p><?= $this->session->flashdata("error") ?></p><?php endif; ?>

	<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

		<a href="<?= base_url("evento/registrar_evento") ?>">Registrar evento</a>

	<?php endif; ?>

</div>

<?php $this->load->view("base/footer"); ?>