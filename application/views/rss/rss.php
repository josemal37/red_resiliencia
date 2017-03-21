<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<rss version="2.0">

	<title><?= $nombre_rss ?></title>
	<link><?= $url_rss ?></link>
	<description><?= $descripcion_rss ?></description>
	<language><?= $lenguaje_rss ?></language>

	<?php if (isset($categorias) && $categorias): ?>

		<?php foreach ($categorias as $categoria): ?>

			<category><?= $categoria ?></category>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php if (isset($articulos) && $articulos): ?>

		<?php foreach ($articulos as $articulo): ?>

			<item>

				<title><?= xml_convert($articulo->nombre) ?></title>
				<link><?= base_url("articulo/ver_articulo/" . $articulo->id) ?></link>
				<descripcion><?= xml_convert($articulo->descripcion) ?></descripcion>

			</item>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php if (isset($publicaciones) && $publicaciones): ?>

		<?php foreach ($publicaciones as $publicacion): ?>

			<item>

				<title><?= xml_convert($publicacion->nombre) ?></title>
				<link><?= base_url("publicacion/ver_publicacion/" . $publicacion->id) ?></link>
				<descripcion><?= xml_convert($publicacion->descripcion) ?></descripcion>

			</item>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php if (isset($eventos) && $eventos): ?>

		<?php foreach ($eventos as $evento): ?>

			<item>

				<title><?= xml_convert($evento->nombre) ?></title>
				<link><?= base_url("evento/ver_evento/" . $evento->id) ?></link>
				<descripcion><?= xml_convert($evento->descripcion) ?></descripcion>

			</item>

		<?php endforeach; ?>

	<?php endif; ?>

</rss>