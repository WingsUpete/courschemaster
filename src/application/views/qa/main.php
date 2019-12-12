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
	<h1 class="hide-for-now"><?= lang('qa') ?></h1>
	<hr class="hide-for-now" />
	<!-- QA System -->
	<div class="container-fluid">
		<div class="row">
			<!-- Search Box & Questions -->
			<div class="col-sm-12 col-lg-7">
				<div class="card">
					<div class="card-header">
						<ul class="nav nav-tabs card-header-tabs" id="question-box" role="tablist">
							<li class="nav-item">
								<a class="nav-link font-weight-bold active" id="question-box-search" data-toggle="tab" title="Events" href="#question-box-search-content" role="tab" aria-controls="question-box-search-content" aria-selected="true"><?= lang('search_questions') ?></a>
							</li>
							<li class="nav-item<?= $logged_in == 'true' ? '' : ' disabled' ?>">
								<a class="nav-link font-weight-bold" id="question-box-ask" data-toggle="tab" title="Courses" href="#question-box-ask-content" role="tab" aria-controls="question-box-ask-content" aria-selected="false"><?= lang('ask_questions') ?></a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="question-box-content">
							<div class="tab-pane fade show active" id="question-box-search-content" role="tabpanel" aria-labelledby="question-box-search">
								<div class="md-form md-outline">
									<i class="fas fa-search prefix"></i>
									<input type="text" id="qa-search" class="form-control">
									<label for="qa-search"><?= lang('search') ?></label>
								</div>
							</div>
							<div class="tab-pane fade" id="question-box-ask-content" role="tabpanel" aria-labelledby="question-box-ask">
								<div class="md-form md-outline">
									<textarea id="ask_question_title" class="md-textarea form-control ask-question-input is-invalid" rows="3" maxlength="50" style="resize:none;"></textarea>
									<label for="ask_question_title" data-error="wrong" data-success="right"><?= lang('title') ?></label>
									<div class="invalid-feedback"></div>
								</div>
								<div class="md-form md-outline">
									<textarea id="ask_question_description" class="md-textarea form-control ask-question-input is-invalid" rows="5" maxlength="300" style="resize:none;"></textarea>
									<label for="ask_question_description" data-error="wrong" data-success="right"><?= lang('description') ?></label>
									<div class="invalid-feedback"></div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-lg-8">
										<span id="ask_questions_tags" class="tags">
											<span class="selected_tags"></span>
											<span class="more_tags">
												<span class="tag-btn badge badge-pill badge-primary" data-toggle="modal" data-target="#tagPanel"><i class="fas fa-plus fa-sm"></i></span>
											</span>
										</span>
									</div>
									<div class="col-xs-12 col-lg-4 text-right">
										<button type="button" id="ask_question_submit" class="btn btn-primary">
											<?= lang('submit') ?>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Utility Box -->
			<div class="col-sm-12 col-lg-5">
				<div class="card">
					<div class="card-header">
						<ul class="nav nav-tabs card-header-tabs" id="recommend-box" role="tablist">
							<li class="nav-item">
								<a class="nav-link font-weight-bold active" id="recommend-box-faqs" data-toggle="tab" title="Events" href="#recommend-box-faqs-content" role="tab" aria-controls="recommend-box-faqs-content" aria-selected="true"><?= lang('faqs') ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link font-weight-bold" id="recommend-box-lqs" data-toggle="tab" title="Courses" href="#recommend-box-lqs-content" role="tab" aria-controls="recommend-box-lqs-content" aria-selected="false"><?= lang('latest_questions') ?></a>
							</li>
							<li class="nav-item<?= $logged_in == 'true' ? '' : ' disabled' ?>">
								<a class="nav-link font-weight-bold" id="recommend-box-myqs" data-toggle="tab" title="Courses" href="#recommend-box-myqs-content" role="tab" aria-controls="recommend-box-myqs-content" aria-selected="false"><?= lang('my_questions') ?></a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="recommend-box-content">
							<div class="tab-pane fade show active" id="recommend-box-faqs-content" role="tabpanel" aria-labelledby="recommend-box-faqs">
								<div class="list-group" id="faq_contents"></div>
								<div id="faq_pagination"></div>
							</div>
							<div class="tab-pane fade" id="recommend-box-lqs-content" role="tabpanel" aria-labelledby="recommend-box-lqs">
								<div class="list-group" id="lq_contents"></div>
								<div id="lq_pagination"></div>
							</div>
							<div class="tab-pane fade" id="recommend-box-myqs-content" role="tabpanel" aria-labelledby="recommend-box-myqs">
								<div class="list-group" id="mq_contents"></div>
								<div id="mq_pagination"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- tagPanel -->
	<div class="modal fade left" id="tagPanel" tabindex="-1" role="dialog" aria-labelledby="tagPanelLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg side-modal modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tagPanelLabel"><?= lang('tag_panel') ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="md-form md-outline filter-box">
						<i class="fas fa-search prefix"></i>
						<input type="text" id="search-tags" class="form-control">
						<label for="search-tags"><?= lang('search') ?></label>
					</div>
					<div id="tagChoices" class="tags"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
