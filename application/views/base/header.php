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

        <!-- JQuery -->
        <script src="<?= base_url("assets/jquery-2.0.3/jquery.js") ?>"></script>

		<!-- JQuery UI -->
		<link href="<?= base_url("assets/jquery-ui-1.12.1/jquery-ui.css") ?>" rel="stylesheet">
		<link href="<?= base_url("assets/jquery-ui-1.12.1/jquery-ui.structure.css") ?>" rel="stylesheet">
		<script src="<?= base_url("assets/jquery-ui-1.12.1/jquery-ui.js") ?>"></script>

        <!-- Bootstrap -->
        <link href="<?= base_url("assets/bootstrap-3.3.7/css/bootstrap.css") ?>" rel="stylesheet">
        <script src="<?= base_url("assets/bootstrap-3.3.7/js/bootstrap.js") ?>"></script>

		<!-- Bootstrap tokenfield -->
		<link href="<?= base_url("assets/bootstrap-tokenfield/css/bootstrap-tokenfield.min.css") ?>" rel="stylesheet">
		<script src="<?= base_url("assets/bootstrap-tokenfield/bootstrap-tokenfield.min.js") ?>"></script>

		<!-- Estilos de la pagina -->
		<link href="<?= base_url("assets/red_resiliencia/css/red_resiliencia.css") ?>" rel="stylesheet">

		<!-- Altura de elementos -->
		<script src="<?= base_url("assets/matchHeight/jquery.matchHeight.js") ?>"></script>

        <!-- Scrolling nav -->
        <script src="<?= base_url('assets/bootstrap-scrolling-nav/js/jquery.easing.min.js') ?>"></script>
        <script src="<?= base_url('assets/bootstrap-scrolling-nav/js/scrolling-nav.js') ?>"></script>
        <link href="<?= base_url('assets/bootstrap-scrolling-nav/css/scrolling-nav.css') ?>" rel="stylesheet">

		<!-- Fuentes -->
		<link href="https://fonts.googleapis.com/css?family=Sansita" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

        <!--[if lt IE 9]>
		
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script
		
        <![endif]-->

    </head>

    <body>