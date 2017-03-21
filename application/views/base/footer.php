<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
	$(".tokenfield").tokenfield({
		createTokensOnBlur: true
	});
</script>

<div class="social">

			<a href="<?= base_url("feed/rss") ?>">

				<img src="<?= base_url("assets/red_resiliencia/img/rss.png") ?>" class="img-responsive pull-right">

			</a>

</div>

<div class="container text-center footer">

	<hr class="small">

	<p>Copyright &copy; Fundación ATICA 2017</p>

</div>

</body>

</html>