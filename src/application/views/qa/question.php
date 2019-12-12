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
	<h1 class="question-title font-weight-bold">
		Title
	</h1>
	<p class="question-addi-info text-muted">
		2019-12-12&ensp;<?= lang('number_of_answers') ?>:3&ensp;<span class="authenticated text-success"><?= lang('authenticated') ?></span>&nbsp;
		<span class="tags">
			<span class="tag badge badge-pill badge-info" title="湿乎乎的话题" data-tag-id="2" data-tag-name="湿乎乎的话题">湿乎乎的话题</span>
			<span class="tag badge badge-pill badge-info" title="湿乎乎的话题" data-tag-id="2" data-tag-name="湿乎乎的话题">湿乎乎的话题</span>
			<span class="tag badge badge-pill badge-info" title="湿乎乎的话题" data-tag-id="2" data-tag-name="湿乎乎的话题">湿乎乎的话题</span>
		</span>
	</p>
	<hr />
	<div class="description">
		This is the description of the question. Maybe it should be a lot longer you know?
	</div>
</div>
