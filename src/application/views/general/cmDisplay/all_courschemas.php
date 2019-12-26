<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmDisplay/all_courschemas.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/all_courschemas/all_courschemas_helper.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmDisplay/all_courschemas/all_courschemas.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		AllCourschemas.initialize(true);
    });
</script>

<!-- Main content -->
<div id="all_courschemas" class="main-content">
	<!-- Title -->
	<h1 class="hide-for-now"><?= lang('all_courschemas') ?></h1>
	<hr class="hide-for-now" />
	<!-- A Navigation Bar -->
	<div id="bs-stepper-box" class="bs-stepper">
		<?php
			// Array for stepper items
			$stepper_items = array(
				array("sel_dep", lang('select_department')),
				array("sel_maj", lang('select_major')),
				array("sel_ver", lang('select_version')),
				array("cur_csm", lang('current_courschema')),
			);
		?>
		<!-- steps -->
		<div class="bs-stepper-header" role="tablist">
			<?php
				for ($i = 1; $i <= count($stepper_items); $i++) {
					$id_alias = $stepper_items[$i-1][0];
					$display_stepper_name = $stepper_items[$i-1][1];
					echo('<div class="step" data-target="#' . $id_alias . '">');
					echo('<button type="button" class="step-trigger" role="tab" aria-controls="' . $id_alias . '" id="' . $id_alias . '-trigger">');
					echo('<span class="bs-stepper-circle">' . $i . '</span>');
					echo('<span class="bs-stepper-label">' . $display_stepper_name . '</span></button></div>');
					if ($i != count($stepper_items)) {
						echo('<div class="line"></div>');
					}
				}
			?>
		</div>
		<!-- make some space -->
		<br />
		<!-- Steps Content -->
		<div class="bs-stepper-content">
			<?php
				for ($i = 0; $i < count($stepper_items); $i++) {
					$id_alias = $stepper_items[$i][0];
					$display_stepper_name = $stepper_items[$i][1];
					echo('<div id="' . $id_alias . '" class="content" role="tabpanel" aria-labelledby="' . $id_alias . '-trigger">');
					echo('<div class="contents"><h2 class="bs-stepper-titles"><span class="bs-stepper-btns">');
					echo('<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--prev ' . (($i == 0) ? 'disabled' : '') . '"><i class="fas fa-chevron-left"></i></button>');
//					echo('<button class="btn btn-sm bs-stepper-btn bs-stepper-btns--next ' . (($i == count($stepper_items) - 1) ? 'disabled' : '') . '"><i class="fas fa-chevron-right"></i></button>');
					echo('</span><span class="display-stepper-name">' . $display_stepper_name . '</span></h2>');
					//	Main Content Block
					//	If not last, search block
					if ($i != count($stepper_items)-1) {
						//	Search Block
						echo('<div class="md-form md-outline"><i class="fas fa-search prefix"></i><input type="text" id="' . $id_alias . '-search" class="form-control" /><label for="' . $id_alias . '-search">' . lang('search') . '</label></div>');
					}
					echo('<div class="stepper-search-res"><div class="container-fulid"><div class="row"></div></div></div>');
					//	If last section, load current_courschema.php
					if ($i == count($stepper_items)-1) {
						$ci->load->view('general/cmDisplay/current_courschema');
					}
					echo('</div></div>');
				}
			?>
		</div>
	</div>
</div>

<br />