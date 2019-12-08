<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/qa/qa.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/qa/qa.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/qa/qa_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		Qa.initialize(true);
    });
</script>

<!-- Main content -->
<div id="qa" class="main-content">
	<h1><?= lang('qa') ?></h1>
	<hr />
	<!-- Others -->

</div>
