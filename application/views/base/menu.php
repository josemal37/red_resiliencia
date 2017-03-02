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

				<a class="navbar-brand page-scroll" href="#header">Inicio</a>

			</div>

			<div class="collapse navbar-collapse" id="menu-items">

				<ul class="nav navbar-nav">

					<?php if (!$this->session->userdata("rol") || $this->session->userdata("rol") == ""): ?>

						<?php if (current_url() == base_url("index.php/portada") || current_url() == base_url("index.php")): ?>

							<?php if (isset($articulos) && $articulos): ?>

								<li><a href="#articulos" class="page-scroll">Articulos</a></li>

							<?php endif; ?>

							<?php if (isset($publicaciones) && $publicaciones): ?>

								<li><a href="#publicaciones" class="page-scroll">Publicaciones</a></li>

							<?php endif; ?>

							<?php if (isset($eventos) && $eventos): ?>

								<li><a href="#eventos" class="page-scroll">Eventos</a></li>

							<?php endif; ?>


						<?php elseif ($this->uri->segment(1) == "articulo" || $this->uri->segment(1) == "publicacion" || $this->uri->segment(1) == "evento"): ?>

							<li><a href="<?= base_url() ?>" class="page-scroll">Portada</a></li>

							<li <?php if ($this->uri->segment(1) == "articulo"): ?>class="active"<?php endif; ?>><a href="<?= base_url("articulo/articulos") ?>" class="page-scroll">Articulos</a></li>

							<li <?php if ($this->uri->segment(1) == "publicacion"): ?>class="active"<?php endif; ?>><a href="<?= base_url("publicacion/publicaciones") ?>" class="page-scroll">Publicaciones</a></li>

							<li <?php if ($this->uri->segment(1) == "evento"): ?>class="active"<?php endif; ?>><a href="<?= base_url("evento/eventos") ?>" class="page-scroll">Eventos</a></li>

						<?php endif; ?>

					<?php elseif ($this->session->userdata("rol") == "administrador"): ?>

						<li <?php if ($this->uri->segment(1) == "administrador"): ?>class="active"<?php endif; ?>><a href="<?= base_url("administrador") ?>">Inicio</a></li>

						<li <?php if ($this->uri->segment(1) == "publicacion"): ?>class="active"<?php endif; ?>><a href="<?= base_url("publicacion") ?>">Publicación</a></li>

						<li <?php if ($this->uri->segment(1) == "articulo"): ?>class="active"<?php endif; ?>><a href="<?= base_url("articulo") ?>">Articulo</a></li>

						<li <?php if ($this->uri->segment(1) == "evento"): ?>class="active"<?php endif; ?>><a href="<?= base_url("evento") ?>">Evento</a></li>

						<li <?php if ($this->uri->segment(1) == "categoria"): ?>class="active"<?php endif; ?>><a href="<?= base_url("categoria") ?>">Categoria</a></li>

						<li <?php if ($this->uri->segment(1) == "autor"): ?>class="active"<?php endif; ?>><a href="<?= base_url("autor") ?>">Autor</a></li>

						<li <?php if ($this->uri->segment(1) == "institucion"): ?>class="active"<?php endif; ?>><a href="<?= base_url("institucion") ?>">Institución</a></li>

						<li <?php if ($this->uri->segment(1) == "usuario"): ?>class="active"<?php endif; ?>><a href="<?= base_url("usuario") ?>">Usuario</a></li>

					<?php elseif ($this->session->userdata("rol") == "usuario"): ?>

						<li <?php if ($this->uri->segment(1) == "usuario_administrador"): ?>class="active"<?php endif; ?>><a href="<?= base_url("usuario_administrador") ?>">Inicio</a></li>

						<li <?php if ($this->uri->segment(1) == "publicacion"): ?>class="active"<?php endif; ?>><a href="<?= base_url("publicacion") ?>">Publicación</a></li>

						<li <?php if ($this->uri->segment(1) == "articulo"): ?>class="active"<?php endif; ?>><a href="<?= base_url("articulo") ?>">Articulo</a></li>

						<li <?php if ($this->uri->segment(1) == "evento"): ?>class="active"<?php endif; ?>><a href="<?= base_url("evento") ?>">Evento</a></li>

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

<script type="text/javascript">
	$(document).ready(function() {
		
		//minima altura permitida
		if ($("body").height() < 768) {
			$("body").height(768);
		}

		var menu = $('#menu');
		var origOffsetY = menu.offset().top;

		function scroll() {
			if ($(window).scrollTop() >= origOffsetY) {
				$('#menu').addClass('navbar-fixed-top');
				console.log("asd");
				console.log($(window).scrollTop());
				console.log(origOffsetY);

			} else {
				$('#menu').removeClass('navbar-fixed-top');
				console.log("qwe");
				console.log($(window).scrollTop());
				console.log(origOffsetY);

			}
		}

		window.onscroll = function(e) {
			scroll();
		}

	});
</script>