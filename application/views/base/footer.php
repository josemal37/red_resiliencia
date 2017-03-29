<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
	$(".tokenfield").tokenfield({
		createTokensOnBlur: true
	});
</script>

<div class="footer">

	<hr>

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