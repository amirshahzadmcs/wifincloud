<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<script>
	$('#headerDomainDropdown').change(function() {
		this.form.submit();
	});

	$('#fresh_data, #fresh_data1').click(function() {

		var url = '<?php echo base_url() ?>/dashboard/fresh_dashboard_data/'
		$.ajax({
			type: 'get',
			url: url,
			beforeSend: function() {
				$('.custom-loader').css("display", "block");
			},
			success: function(data) {
				location.reload();
			}

		});

		return false;
	});
</script>

<!-- Footer -->
<div class="footer text-muted">
	&copy; <?php echo date("Y"); ?>. <a href="http://www.wifincloud.com">WiFinCloud</a> v2.3
</div>
<!-- /footer -->

</div>
<!-- /content area -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->

</body>

</html>