	<div id="sidebar" class="sidenav">
		<a id="closeNav" href="javascript:void(0);" class="closebtn">&times;</a>
		<div class="sidenav-items">
			<?php $active = ($active_sidebar == PRIV_STUDENTS_MY_COURSCHEMA) ? 'active' : '' ?>
			<a href="<?= site_url('students') ?>" class="<?= $active ?>">
				<span class="sd_icn"><i class="fas fa-book"></i></span>
				&ensp;
				<span class="sd_epn"><?= lang('my_courschema') ?></span>
			</a>
			<?php $active = ($active_sidebar == PRIV_STUDENTS_ALL_COURSCHEMAS) ? 'active' : '' ?>
			<a href="<?= site_url('students/all_courschemas') ?>" class="<?= $active ?>">
				<span class="sd_icn"><i class="fas fa-layer-group"></i></span>
				&ensp;
				<span class="sd_epn"><?= lang('all_courschemas') ?></span>
			</a>
			<?php $active = ($active_sidebar == PRIV_STUDENTS_COLLECTION) ? 'active' : '' ?>
			<a href="<?= site_url('students/collection') ?>" class="<?= $active ?>">
				<span class="sd_icn"><i class="fas fa-star"></i></span>
				&ensp;
				<span class="sd_epn"><?= lang('collection') ?></span>
			</a>
			<hr />
			<?php $active = ($active_sidebar == PRIV_STUDENTS_MY_PLAN) ? 'active' : '' ?>
			<a href="<?= site_url('students/my_plan') ?>" class="<?= $active ?>">
				<span class="sd_icn"><i class="fas fa-trophy"></i></span>
				&ensp;
				<span class="sd_epn"><?= lang('my_plan') ?></span>
			</a>
			<hr />
			<?php $active = ($active_sidebar == PRIV_STUDENTS_LEARNED) ? 'active' : '' ?>
			<a href="<?= site_url('students/learned') ?>" class="<?= $active ?>">
				<span class="sd_icn"><i class="fas fa-graduation-cap"></i></span>
				&ensp;
				<span class="sd_epn"><?= lang('learned') ?></span>
			</a>
		</div>
	</div>
	
	<button id="openNav" class="btn">
		<i class="fas fa-bars"></i>
	</button>
	
	<script>
		$('#openNav').click(function() {
			$('#sidebar').css('width', '300px');
			$('.main-content').css('margin-left', '300px');
		});
		$('#closeNav').click(function() {
			$('#sidebar').css('width', '0');
			$('.main-content').css('margin-left', '0');
		});
	</script>