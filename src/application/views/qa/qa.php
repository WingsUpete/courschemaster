<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/current_courschema/current_courschema.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/current_courschema/current_courschema_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		CurrentCourschema.initialize(true);
    });
</script>

<!-- Main content -->
<div id="qa" class="main-content">
	<h1><?= lang('qa') ?></h1>
	<hr />
	<!-- Others -->

</div>
