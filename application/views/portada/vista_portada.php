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

        <header>

            <h1><?= $titulo ?></h1>

        </header>

        <?php if (isset($articulos)): ?>

            <!-- Articulos -->
            <section id="articulos" class="container">

                <h2>Artículos</h2>

                <?php if ($articulos): ?>

                    <div class="row">

                        <?php foreach ($articulos as $articulo): ?>

                            <h3><?= $articulo->nombre ?></h3>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <p>Sin artículos.</p>

                <?php endif; ?>

            </section>

        <?php endif; ?>

        <?php if (isset($publicaciones)): ?>

            <!-- Publicaciones -->
            <section id="publicaciones" class="container">

                <h2>Publicaciones</h2>

                <?php if ($publicaciones): ?>

                    <div class="row">

                        <?php foreach ($publicaciones as $publicacion): ?>

                            <div class="col-md-3">

                                <img src="<?= base_url($publicacion->imagen) ?>" alt="<?= $publicacion->nombre ?>" class="img-responsive">
                                <h3><?= $publicacion->nombre ?></h3>
                                <p><?= $publicacion->descripcion ?></p>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <p>Sin publicaciones.</p>

                <?php endif; ?>

            </section>

        <?php endif; ?>

    </body>

</html>