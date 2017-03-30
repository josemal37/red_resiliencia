<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="pagina">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= NOMBRE_PAGINA ?></h1>

		</div>

	</div>

	<?php $this->load->view("base/menu"); ?>

	<div class="titulo-pagina">

		<div class="container-fluid">

			<h1><?= $titulo ?></h1>

		</div>

	</div>

	<div class="contenido">

		<div class="container">
			
			<?php if (isset($usuarios) && $usuarios): ?>
			
				<h3>Los siguientes usuarios también serán eliminados:</h3>
				
				<ul>
			
				<?php foreach ($usuarios  as $usuario): ?>
			
					<li><?= $usuario->nombre_completo ?> (<?= $usuario->login ?>)</li>
			
				<?php endforeach; ?>
			
				</ul>
				
			<?php endif; ?>

				<form action="<?= base_url("institucion/eliminar_institucion/" . $id) ?>" id="form-institucion" method="post" autocomplete="off">

				<input type="hidden" id="id" name="id" value="<?= $id ?>">

				<?php if ($this->session->flashdata("existe")): ?><p><?= $this->session->flashdata("existe") ?></p><?php endif; ?>

				<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Continuar">

			</form>

		</div>

	</div>

</div>

<script type="text/javascript">
	/** script para validaciones **/
	$("#form-institucion").validate(<?= $reglas_validacion ?>);
</script>

<?php $this->load->view("base/footer"); ?>
