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

			</div>

			<div class="collapse navbar-collapse" id="menu-items">

				<ul class="nav navbar-nav">

					<?php if (!$this->session->userdata("rol") || $this->session->userdata("rol") == ""): ?>

						<li><a href="<?= base_url() ?>">Inicio</a></li>

						<li <?php if ($this->uri->segment(1) == "articulo"): ?>class="active"<?php endif; ?>><a href="<?= base_url("articulo/articulos") ?>" class="page-scroll">Articulos</a></li>

						<li <?php if ($this->uri->segment(1) == "publicacion"): ?>class="active"<?php endif; ?>><a href="<?= base_url("publicacion/publicaciones") ?>" class="page-scroll">Publicaciones</a></li>

						<li <?php if ($this->uri->segment(1) == "evento"): ?>class="active"<?php endif; ?>><a href="<?= base_url("evento/eventos") ?>" class="page-scroll">Eventos</a></li>

						<li <?php if ($this->uri->segment(1) == "herramienta"): ?>class="active"<?php endif; ?>><a href="<?= base_url("herramienta/herramientas") ?>" class="page-scroll">Herramientas</a></li>

					<?php elseif ($this->session->userdata("rol") == "administrador"): ?>

						<li <?php if ($this->uri->segment(1) == "administrador"): ?>class="active"<?php endif; ?>><a href="<?= base_url("administrador") ?>">Inicio</a></li>

						<li <?php if ($this->uri->segment(1) == "publicacion"): ?>class="active"<?php endif; ?>><a href="<?= base_url("publicacion") ?>">Publicación</a></li>

						<li <?php if ($this->uri->segment(1) == "articulo"): ?>class="active"<?php endif; ?>><a href="<?= base_url("articulo") ?>">Articulo</a></li>

						<li <?php if ($this->uri->segment(1) == "evento"): ?>class="active"<?php endif; ?>><a href="<?= base_url("evento") ?>">Evento</a></li>

						<li <?php if ($this->uri->segment(1) == "herramienta"): ?>class="active"<?php endif; ?>><a href="<?= base_url("herramienta/herramientas") ?>" class="page-scroll">Herramientas</a></li>

						<li <?php if ($this->uri->segment(1) == "categoria"): ?>class="active"<?php endif; ?>><a href="<?= base_url("categoria") ?>">Categoria</a></li>

						<li <?php if ($this->uri->segment(1) == "autor"): ?>class="active"<?php endif; ?>><a href="<?= base_url("autor") ?>">Autor</a></li>

						<li <?php if ($this->uri->segment(1) == "institucion"): ?>class="active"<?php endif; ?>><a href="<?= base_url("institucion") ?>">Institución</a></li>

						<li <?php if ($this->uri->segment(1) == "usuario"): ?>class="active"<?php endif; ?>><a href="<?= base_url("usuario") ?>">Usuario</a></li>

					<?php elseif ($this->session->userdata("rol") == "usuario"): ?>

						<li <?php if ($this->uri->segment(1) == "usuario_administrador"): ?>class="active"<?php endif; ?>><a href="<?= base_url("usuario_administrador") ?>">Inicio</a></li>

						<li <?php if ($this->uri->segment(1) == "publicacion"): ?>class="active"<?php endif; ?>><a href="<?= base_url("publicacion") ?>">Publicación</a></li>

						<li <?php if ($this->uri->segment(1) == "articulo"): ?>class="active"<?php endif; ?>><a href="<?= base_url("articulo") ?>">Articulo</a></li>

						<li <?php if ($this->uri->segment(1) == "evento"): ?>class="active"<?php endif; ?>><a href="<?= base_url("evento") ?>">Evento</a></li>

						<li <?php if ($this->uri->segment(1) == "herramienta"): ?>class="active"<?php endif; ?>><a href="<?= base_url("herramienta/herramientas") ?>" class="page-scroll">Herramientas</a></li>

					<?php endif; ?>

				</ul>

				<ul class="nav navbar-nav navbar-right">

					<?php if ($this->session->userdata("rol") == "administrador" || $this->session->userdata("rol") == "usuario"): ?>

						<li class="dropdown">

							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $this->session->userdata("nombre_completo") ?><span class="caret"></span></a>

							<ul class="dropdown-menu">

								<li class="navbar-text"><p><?= $this->session->userdata("nombre_institucion") ?></p></li>

								<li><a href="<?= base_url("usuario/modificar_password/" . $this->session->userdata("id_usuario")) ?>">Cambiar password</a></li>

								<li><a href="<?= base_url("login/cerrar_sesion") ?>">Cerrar sesión</a></li>

							</ul>

						</li>

					<?php endif; ?>

				</ul>

			</div>

		</div>

	</nav>

</nav>