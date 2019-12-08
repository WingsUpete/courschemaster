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
	<!-- QA System -->
	<div class="container-fluid">
		<div class="row">
			<!-- Search Box & Questions -->
			<div class="col-sm-12 col-lg-7">
				<div class="md-form md-outline">
					<i class="fas fa-search prefix"></i>
					<input type="text" id="qa-search" class="form-control">
					<label for="qa-search"><?= lang('search') ?></label>
				</div>
				
			</div>
			<!-- Recommend Box -->
			<div class="col-sm-12 col-lg-5">
				<div class="card">
					<div class="card-header">
						<ul class="nav nav-tabs card-header-tabs" id="list-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link font-weight-bold active" id="list-tabs-faqs" data-toggle="tab" title="Events" href="#list-tabs-faqs-content" role="tab" aria-controls="list-tabs-faqs-content" aria-selected="true"><?= lang('faqs') ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link font-weight-bold" id="list-tabs-lqs" data-toggle="tab" title="Courses" href="#list-tabs-lqs-content" role="tab" aria-controls="list-tabs-lqs-content" aria-selected="false"><?= lang('latest_questions') ?></a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="list-tabs-content">
							<div class="tab-pane fade show active" id="list-tabs-faqs-content" role="tabpanel" aria-labelledby="list-tabs-faqs">
								FAQs
							</div>
							<div class="tab-pane fade" id="list-tabs-lqs-content" role="tabpanel" aria-labelledby="list-tabs-lqs">
								Latest Questions
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
