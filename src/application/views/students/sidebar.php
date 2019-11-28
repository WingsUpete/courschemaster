	<div id="sidebar" class="sidenav">
		<a id="closeNav" href="javascript:void(0);" class="closebtn">&times;</a>
		<div class="sidenav-items">
			<?php $active = ($active_sidebar == PRIV_STUDENTS_MY_COURSCHEMA) ? 'active' : '' ?>
			<a href="<?= site_url('students') ?>" class="<?= $active ?>">My Courschema</a>
			<?php $active = ($active_sidebar == PRIV_STUDENTS_ALL_COURSCHEMAS) ? 'active' : '' ?>
			<a href="<?= site_url('students/all_courschemas') ?>" class="<?= $active ?>">All Courschemas</a>
			<?php $active = ($active_sidebar == PRIV_STUDENTS_COLLECTION) ? 'active' : '' ?>
			<a href="<?= site_url('students/collection') ?>" class="<?= $active ?>">Collection</a>
			<hr />
			<?php $active = ($active_sidebar == PRIV_STUDENTS_MY_PLAN) ? 'active' : '' ?>
			<a href="<?= site_url('students/my_plan') ?>" class="<?= $active ?>">My Plan</a>
			<hr />
			<?php $active = ($active_sidebar == PRIV_STUDENTS_LEARNED) ? 'active' : '' ?>
			<a href="<?= site_url('students/learned') ?>" class="<?= $active ?>">Learned</a>
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