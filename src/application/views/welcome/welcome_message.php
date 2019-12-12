<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/welcome/welcome.css', NULL, 'css') ?>" />
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };
	
	window.addEventListener('load', function() {
		$('header #navCourschemaster, footer').addClass('welcome');
		
		var fadeTime = 360;
		$(document).on('click', '#staff-comp-entry', function() {
			$('#bg-img').addClass('flip');
			$('#nav-components--general').fadeOut(fadeTime);
			$('#nav-components--staff').fadeIn(fadeTime);
		});
		$(document).on('click', '#staff-compo-back', function() {
			$('#bg-img').removeClass('flip');
			$('#nav-components--staff').fadeOut(fadeTime);
			$('#nav-components--general').fadeIn(fadeTime);
		});
		$(document).on('click', '.staff-links', function() {
			$('#bg-img').removeClass('flip');
		});
	});
</script>

<!-- Main content -->
<div id="welcome_page" class="main-content">
	<div id="nav-components--general" class="nav-components text-black text-center">
<!--		<h1 class="nav-title">Courschemaster</h1>-->
		<div class="row">
			<div class="col-sm-4">
				<a href="<?= site_url('students') ?>">
					<div class="nav-icons">
						<i class="fas fa-user-edit fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3><?= lang('student') ?></h3>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a id="staff-comp-entry" href="javascript:void(0);">
					<div class="nav-icons">
						<i class="fas fa-user-tie fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3><?= lang('staff') ?></h3>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a href="<?= site_url('visitors') ?>">
					<div class="nav-icons">
						<i class="fas fa-user-friends fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3><?= lang('visitor') ?></h3>
					</div>
				</a>
			</div>
		</div>
	</div>
	<div id="nav-components--staff" class="nav-components text-black text-center">
<!--		<h1 class="nav-title"><i class="fas fa-user-tie fa-lg"></i>&ensp;Staff</h1>-->
		<div class="row">
			<div class="col-sm-4">
				<a href="<?= site_url('tao') ?>" class="staff-links">
					<div class="nav-icons">
						<i class="fas fa-user-cog fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3><?= lang('tao') ?></h3>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a href="<?= site_url('secretary') ?>" class="staff-links">
					<div class="nav-icons">
						<i class="fas fa-user-secret fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3><?= lang('secretary') ?></h3>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a href="<?= site_url('mentor') ?>" class="staff-links">
					<div class="nav-icons">
						<i class="fas fa-chalkboard-teacher fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3><?= lang('mentor') ?></h3>
					</div>
				</a>
			</div>
		</div>
		<div id="staff-compo-back-block">
			<i id="staff-compo-back" class="fas fa-chevron-circle-left fa-2x"></i>
		</div>
	</div>
</div>