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

        <div class="text-center">

            <h1><?= $titulo ?></h1>

        </div>

		<?php
		$this->load->view("base/menu");
		?>

        <div class="container">

			<?php if ($categorias): ?>

				<table class="table">

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
									<a href="<?= base_url("categoria/modificar_categoria/" . $categoria->id) ?>">Modificar</a>
									<a href="<?= base_url("categoria/eliminar_categoria/" . $categoria->id) ?>">Eliminar</a>
								</td>

							</tr>

						<?php endforeach; ?>

					</tbody>

				</table>

			<?php else: ?>

				<p>No se registraron categorias.</p>

			<?php endif; ?>

			<?php if ($this->session->flashdata("no_existe")): ?><p><?= $this->session->flashdata("no_existe") ?></p><?php endif; ?>

            <a href="<?= base_url("categoria/registrar_categoria") ?>">Registrar categoria</a>

        </div>

    </body>

</html>