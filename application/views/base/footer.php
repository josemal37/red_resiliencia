<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container text-center footer">

	<hr class="small">

	<p>Copyright &copy; Fundación ATICA 2017</p>

</div>

<script type="text/javascript">
	$(document).ready(function() {

		var menu = $('#menu');
		var origOffsetY = menu.offset().top;

		function scroll() {
			if ($(window).scrollTop() >= origOffsetY) {
				$('#menu').addClass('navbar-fixed-top');
			} else {
				$('#menu').removeClass('navbar-fixed-top');
			}


		}

		window.onscroll = function(e) {
			scroll();
		}

	});
</script>

</body>

</html>