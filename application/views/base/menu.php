<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav>

	<nav id="menu" class="navbar navbar-default">

		<div class="container-fluid">

			<div class="navbar-header">

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-items">

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

				</button>

				<a class="navbar-brand" href="<?= base_url() ?>">Red resiliencia</a>

			</div>

			<div class="collapse navbar-collapse" id="menu-items">

				<ul class="nav navbar-nav">

					<?php if (!$this->session->userdata("rol") || $this->session->userdata("rol") == ""): ?>

						<li class="active"><a href="#">Inicio</a></li>

						<?php if (isset($articulos) && $articulos): ?>

							<li><a href="#articulos">Articulos</a></li>

						<?php endif; ?>

						<?php if (isset($publicaciones) && $publicaciones): ?>

							<li><a href="#publicaciones">Publicaciones</a></li>

						<?php endif; ?>

						<?php if (isset($eventos) && $eventos): ?>

							<li><a href="eventos">Eventos</a></li>

						<?php endif; ?>

					<?php elseif ($this->session->userdata("rol") == "administrador"): ?>

						<li><a href="<?= base_url("administrador") ?>">Inicio</a></li>

						<li><a href="<?= base_url("publicacion") ?>">Publicación</a></li>

						<li><a href="<?= base_url("articulo") ?>">Articulo</a></li>

						<li><a href="<?= base_url("evento") ?>">Evento</a></li>

						<li><a href="<?= base_url("categoria") ?>">Categoria</a></li>

						<li><a href="<?= base_url("autor") ?>">Autor</a></li>

						<li><a href="<?= base_url("institucion") ?>">Institución</a></li>

						<li><a href="<?= base_url("usuario") ?>">Usuario</a></li>

					<?php elseif ($this->session->userdata("rol") == "usuario"): ?>

						<li><a href="<?= base_url("usuario_administrador") ?>">Inicio</a></li>

						<li><a href="<?= base_url("publicacion") ?>">Publicación</a></li>

						<li><a href="<?= base_url("articulo") ?>">Articulo</a></li>

						<li><a href="<?= base_url("evento") ?>">Evento</a></li>

					<?php endif; ?>

				</ul>

				<ul class="nav navbar-nav navbar-right">

					<?php if (!$this->session->userdata("rol") || $this->session->userdata("rol") == ""): ?>

						<li><a href="<?= base_url("login") ?>">Ingresar</a></li>

					<?php elseif ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

						<li class="dropdown">

							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $this->session->userdata("nombre_completo") ?><span class="caret"></span></a>

							<ul class="dropdown-menu">

								<li class="navbar-text"><p><?= $this->session->userdata("nombre_institucion") ?></p></li>

								<li><a href="<?= base_url("login/cerrar_sesion") ?>">Cerrar sesión</a></li>

							</ul>

						</li>

					<?php endif; ?>

				</ul>

			</div>

		</div>

	</nav>

</nav>