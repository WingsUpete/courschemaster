<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmManagement/review.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/review/review_helper.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/review/review.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		Review.initialize(true);
    });
</script>

<!-- Main content -->
<div id="review" class="main-content">
	<h1 class="hide-for-now">Review</h1>
	<hr class="hide-for-now" />
	<!-- ... -->
	<?php
		// Array for couschema view icons (alias, active, icon, lang)
		$reviews = array(
			array('wide', 'true', 'list', lang('reviews-wide')),
			array('func', 'false', 'gem', lang('reviews-func'))
		);
	?>
	<ul class="nav nav-pills pills-pink mb-3" id="reviews" role="tablist">
		<?php
			for ($i = 0; $i < count($reviews); $i++) {
				echo('<li class="nav-item">');
				echo('<a class="nav-link font-weight-bold' . ($reviews[$i][1] == 'true' ? ' active' : '') . '" id="reviews-' . $reviews[$i][0] . '" data-toggle="pill" title="' . $reviews[$i][3] . '" href="#reviews-' . $reviews[$i][0] . '-content" role="tab" aria-controls="reviews-' . $reviews[$i][0] . '-content" aria-selected="' . $reviews[$i][1] . '">');
				echo('<i class="fas fa-' . $reviews[$i][2] . ' fa-lg"></i><span class="reviews-txt">&ensp;' . $reviews[$i][3] . '</span>');
				echo('</a></li>');
			}
		?>
	</ul>
	<div class="tab-content" id="reviews-content">
		<div class="tab-pane fade show active" id="reviews-wide-content" role="tabpanel" aria-labelledby="reviews-wide">
			<?php
				$record_table_headers = array(
					'#', lang('courschema_name'), lang('courschema_major'), lang('status'), lang('submit_time')
				);
			?>
			<div class="table-responsive"><table id="records-datatable" class="table table-striped table-bordered table-hover table-condensed text-center">
				<thead>
					<tr>
						<?php
							for ($i = 0; $i < count($record_table_headers); $i++) {
								echo('<th class="th-sm justify-content-center">' . $record_table_headers[$i] . '</th>');
							}
						?>
					</tr>
				</thead>
				<tbody></tbody>
			</table></div>
		</div>
		<div class="tab-pane fade" id="reviews-func-content" role="tabpanel" aria-labelledby="reviews-func">
			
		</div>
	</div>
</div>
