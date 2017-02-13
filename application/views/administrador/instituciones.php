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

        <div class="container">
			
			<?php if($instituciones): ?>
			
			<table class="table">
				
				<thead>
					
					<tr>
						
						<th>Sigla</th>
						<th>Nombre</th>
						<th>Acciones</th>
						
					</tr>
					
				</thead>
				
				<tbody>
					
					<?php foreach($instituciones as $institucion): ?>
					
					<tr id="<?= $institucion->id?>">
						
						<td><?= $institucion->sigla ?></td>
						<td><?= $institucion->nombre ?></td>
						<td><a href="<?= base_url("administrador/modificar_institucion/" . $institucion->id)?>">Modificar</a></td>
						
					</tr>
					
					<?php endforeach; ?>
					
				</tbody>
				
			</table>
			
			<?php else: ?>
			
			<p>No se registraron instituciones.</p>
			
			<?php endif; ?>
			
			<a href="<?= base_url("administrador/registrar_institucion")?>">Registrar institución</a>
			
		</div>
		
	</body>
	
</html>