<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
	$(".tokenfield").tokenfield({
		createTokensOnBlur: true
	});
</script>

<div class="footer">

	<hr>

	<?php if ($this->session->userdata("rol") == ""): ?>

		<div class="logos hidden-xs">

			<div class="container">

				<div class="row">

					<div class="col-sm-2">

						<a href="https://www.eda.admin.ch/bolivia/">

							<img src="<?= base_url("assets/red_resiliencia/img/logos/cosude.jpg") ?>" class="logo img-center img-responsive">

						</a>

					</div>

					<div class="col-sm-2">

						<a href="http://www.umsa.bo">

							<img src="<?= base_url("assets/red_resiliencia/img/logos/umsa.jpg") ?>" class="logo img-center img-responsive">

						</a>

					</div>

					<div class="col-sm-2">

						<a href="http://fundacionatica.org/">

							<img src="<?= base_url("assets/red_resiliencia/img/logos/atica.jpg") ?>" class="logo img-center img-responsive">

						</a>

					</div>

					<div class="col-sm-2">

						<a href="http://www.ucb.edu.bo/">

							<img src="<?= base_url("assets/red_resiliencia/img/logos/ucb.jpg") ?>" class="logo img-center img-responsive">

						</a>

					</div>

					<div class="col-sm-2">

						<a href="http://www.egpp.gob.bo/">

							<img src="<?= base_url("assets/red_resiliencia/img/logos/egpp.jpg") ?>" class="logo img-center img-responsive">

						</a>

					</div>

					<div class="col-sm-2">

						<a href="http://www.umss.edu.bo/">

							<img src="<?= base_url("assets/red_resiliencia/img/logos/umss.jpg") ?>" class="logo img-center img-responsive">

						</a>

					</div>

				</div>

			</div>

		</div>

	<?php endif; ?>

	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-4">



			</div>

			<div class="col-sm-4">

				<div class="text-center">

					<p>Copyright &copy; Fundación ATICA 2017</p>

				</div>

			</div>

			<div class="col-sm-4">

				<?php if (!$this->session->userdata("rol")): ?>

					<div class="text-right">

						<a href="<?= base_url("login") ?>" class="text-muted small">administrar página</a>

					</div>

				<?php endif; ?>

			</div>

		</div>

	</div>

</div>

</body>

</html>