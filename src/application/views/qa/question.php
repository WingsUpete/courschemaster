<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/qa/qa.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/qa/qa.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/qa/qa_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>,
		qid                : <?= $qid ?>
    };

    $(document).ready(function() {
		Qa.initialize(true, false);
    });
</script>

<!-- Main content -->
<div id="qa-detail" class="main-content">
	<h1 class="hide-for-now"><?= lang('qa') ?></h1>
	<hr class="hide-for-now" />
	<!-- QA System - Question -->
	<input type="hidden" id="question-id" />
	<h1 class="question-title font-weight-bold h1-responsive"></h1>
	<p class="question-basic-info text-muted">
		<a class="question-provider"></a> - <span class="question-provider-major"></span>&ensp;&ensp;<span class="question-creation-time"></span>&ensp;&ensp;<?= lang('number_of_answers') ?>:<span class="question-number-of-answers"></span>&ensp;&ensp;<span class="authenticated question-authenticated text-success"></span>&nbsp;
		<span class="tags"></span>
	</p>
	<h5 class="question-description h5-responsive"></h5>
	<hr />
	<div class="question-answers">
		<div class="list-group" id="qa_contents"></div>
		<div id="qa_pagination"></div>
	</div>
</div>
