<?php
if ($this->session->flashdata('errormessage')) {
?>
	<script type="text/javascript">
		$(document).ready(function () {
			showErrorMsg("<?php echo $this->session->flashdata('errormessage'); ?>");
		});
	</script>
<?php
} else if ($this->session->flashdata('message')) {
?>
	<script type="text/javascript">
		$(document).ready(function () {
			showSuccessMsg("<?php echo $this->session->flashdata('message'); ?>");
		});
	</script>
<?php
}
?>