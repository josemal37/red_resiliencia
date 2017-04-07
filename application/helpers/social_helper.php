<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function compartir_twitter($item = FALSE) {
	$CI = & get_instance();
	$url = "http://twitter.com/share?url=";
	switch ($CI->uri->segment(1)) {
		case "articulo":
			$url = $url . urlencode(base_url("articulo/ver_articulo/" . $item->id)) . "&text=" . urlencode($item->nombre);
			break;
		case "evento":
			$url = $url . urlencode(base_url("evento/ver_evento/" . $item->id)) . "&text=" . urlencode($item->nombre);
			break;
		case "herramienta":
			$url = $url . urlencode(base_url("herramienta/ver_herramienta/" . $item->id)) . "&text=" . urlencode($item->nombre);
			break;
		case "publicacion":
			$url = $url . urlencode(base_url("publicacion/ver_publicacion/" . $item->id)) . "&text=" . urlencode($item->nombre);
			break;
		default:
			$url = $url . urlencode(current_url());
			break;
	}
	return $url;
}

function compartir_linkedin($item = FALSE) {
	$CI = & get_instance();
	$url = "https://www.linkedin.com/shareArticle?mini=true&url=";
	switch ($CI->uri->segment(1)) {
		case "articulo":
			$url = $url . urlencode(base_url("articulo/ver_articulo/" . $item->id)) . "&title=" . urlencode($item->nombre) . "&source=" . urlencode(NOMBRE_PAGINA);
			break;
		case "evento":
			$url = $url . urlencode(base_url("evento/ver_evento/" . $item->id)) . "&title=" . urlencode($item->nombre) . "&source=" . urlencode(NOMBRE_PAGINA);
			break;
		case "herramienta":
			$url = $url . urlencode(base_url("herramienta/ver_herramienta/" . $item->id)) . "&title=" . urlencode($item->nombre) . "&source=" . urlencode(NOMBRE_PAGINA);
			break;
		case "publicacion":
			$url = $url . urlencode(base_url("publicacion/ver_publicacion/" . $item->id)) . "&title=" . urlencode($item->nombre) . "&source=" . urlencode(NOMBRE_PAGINA);
			break;
		default:
			$url = $url . urlencode(current_url());
			break;
	}
	return $url;
}
