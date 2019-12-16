<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/qa/qa.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/qa/qa.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/qa/qa_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>,
		qid                : <?= $qid ?>,
		logged_in          : '<?= $logged_in ?>',
		main_page_url      : '<?= site_url('qa') ?>'
    };

    $(document).ready(function() {
		Qa.initialize(true, false);
    });
</script>

<!-- Main content -->
<div id="qa-detail" class="main-content" style="padding: 0;">
	<h1 class="hide-for-now"><?= lang('qa') ?></h1>
	<hr class="hide-for-now" />
	<!-- QA System - Question -->
	<input type="hidden" id="question-id" />
	<div class="top-bar">
		<a href="<?= site_url('qa') ?>">
			<?= lang('back') ?>
		</a>
		&ensp;&ensp;
		<a href="javascript:void(0);" class="delete_question">
			<?= lang('delete') ?>
		</a>
	</div>
	<hr style="margin-top: 0;" />
	<div class="main-answer-block" style="padding: 26px;padding-top: 0;">
		<h1 class="h1-responsive"><span class="question-title"></span></h1>
		<p class="question-basic-info text-muted">
			<a class="question-provider"></a> - <span class="question-provider-major"></span>&ensp;&ensp;<span class="question-creation-time"></span>&nbsp;
			<span class="tags"></span>
		</p>
		<h5 class="question-description h5-responsive"></h5>
		<p class="question-basic-info text-muted">
			<button type="button" class="btn btn-primary btn-sm answer-button <?= $logged_in == 'true' ? '' : 'disabled' ?> ml-0" data-toggle="modal" data-target="#answerWindow">
				<i class="fas fa-feather"></i>&ensp;
				<?= lang('provide_answer') ?>
			</button>
			&ensp;<?= lang('number_of_answers') ?>:<span class="question-number-of-answers"></span>&ensp;&ensp;<span class="authenticated question-authenticated text-success"></span>
		</p>
		<div class="question-answers">
			<div class="list-group" id="qa_contents"></div>
			<div id="qa_pagination"></div>
		</div>
	</div>
	<!-- answerWindow -->
	<div class="modal fade top" id="answerWindow" tabindex="-1" role="dialog" aria-labelledby="answerWindowLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg side-modal modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="answerWindowLabel"><?= lang('provide_answer') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="md-form md-outline">
						<textarea id="answer-content" class="md-textarea form-control answer-input is-invalid" rows="5" maxlength="250" style="resize:none;"></textarea>
						<label for="answer-content" data-error="wrong" data-success="right"><?= lang('answer') ?></label>
						<div class="invalid-feedback"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="answer-submit" type="button" class="btn btn-primary btn-sm"><?= lang('submit') ?></button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
				</div>
			</div>
		</div>
	</div>
	<!-- replyWindow -->
	<div class="modal fade top" id="replyWindow" tabindex="-1" role="dialog" aria-labelledby="replyWindowLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg side-modal modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="replyWindowLabel"><?= lang('reply') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="reply_answer_id" />
					<input type="hidden" id="reply_receiver_id" />
					<div class="md-form md-outline">
						<textarea id="reply-content" class="md-textarea form-control reply-input is-invalid" rows="5" maxlength="250" style="resize:none;"></textarea>
						<label for="reply-content" data-error="wrong" data-success="right"><?= lang('reply') ?></label>
						<div class="invalid-feedback"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="reply-submit" type="button" class="btn btn-primary btn-sm"><?= lang('submit') ?></button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
