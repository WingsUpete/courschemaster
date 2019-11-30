	<div id="sidebar" class="sidenav">
		<a id="closeNav" href="javascript:void(0);" class="closebtn">&times;</a>
		<a id="toggleExpansionNav" href="javascript:void(0);" class="expandbtn">
			<i class="fas fa-sign-out-alt noflip fa-xs"></i>
			<i class="fas fa-sign-out-alt fa-flip-horizontal fa-xs"></i>
		</a>
		<!-- Sidenav Items -->
		<div class="sidenav-items">
			<hr />
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
		var mql = window.matchMedia("screen and (max-width: 600px)");
		mediaQueryResponse(mql);
		mql.addListener(mediaQueryResponse);
		
		function mediaQueryResponse(mql) {
			if (mql.matches) {
				$('.sidenav').removeClass('mobile').removeClass('stretched').removeClass('expanded');
				$('.sidenav').addClass('mobile');
				GeneralFunctions.placeFooterToBottom();	// fix footer issue
				return true;
			} else {
				$('.sidenav').removeClass('mobile').removeClass('stretched').removeClass('expanded');
				$('.sidenav').removeClass('mobile');
				GeneralFunctions.placeFooterToBottom();	// fix footer issue
				return false;
			}
		}
		
		$(document).on('click', '.sidenav #toggleExpansionNav', function() {
			$('#sidebar').toggleClass('expanded');
			GeneralFunctions.placeFooterToBottom();	// fix footer issue
		});
		
		$(document).on('click', '.sidenav.mobile + #openNav', function() {
			$('.sidenav').addClass('stretched');
		});
		$(document).on('click', '.sidenav.mobile #closeNav', function() {
			$('.sidenav').removeClass('stretched');
		});
	</script>