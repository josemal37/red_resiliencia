<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav>

	<nav class="navbar navbar-default">

		<div class="container-fluid">

			<div class="navbar-header">

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">

					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>

				</button>

				<a class="navbar-brand" href="#">Red resiliencia</a>

			</div>

			<div class="collapse navbar-collapse" id="menu">

				<ul class="nav navbar-nav">

					<?php if (!$this->session->userdata("rol") || $this->session->userdata("rol") == ""): ?>

						<li class="active"><a href="#">Home</a></li>

						<li><a href="#">Page 1</a></li>
						<li><a href="#">Page 2</a></li> 
						<li><a href="#">Page 3</a></li>

					<?php elseif ($this->session->userdata("rol") == "administrador"): ?>

						<li><a href="Inicio">Inicio</a></li>
						<li><a href="Publicaciones">Publicación</a></li>
						<li><a href="Articulos">Articulo</a></li>
						<li><a href="Eventos">Evento</a></li>
						<li><a href="<?= base_url("categoria")?>">Categoria</a></li>
						<li><a href="Instituciones">Institución</a></li>
						<li><a href="Usuarios">Usuario</a></li>

					<?php endif; ?>

				</ul>

				<ul class="nav navbar-nav navbar-right">

					<?php if (!$this->session->userdata("rol") || $this->session->userdata("rol") == ""): ?>

						<li><a href="<?= base_url("login") ?>"><span class="glyphicon glyphicon-log-in"></span> Ingresar</a></li>

					<?php elseif ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

						<li><a href="<?= base_url("login/cerrar_sesion") ?>">Cerrar sesión</a></li>

					<?php endif; ?>

				</ul>

			</div>

		</div>

	</nav>

</nav>
