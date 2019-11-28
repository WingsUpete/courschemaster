<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };
</script>

<!-- Main content -->
<div id="bg-img"></div>

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
						<h3>Student</h3>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a href="<?= site_url('staff') ?>">
					<div class="nav-icons">
						<i class="fas fa-user-tie fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3>Staff</h3>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a href="<?= site_url('visitors') ?>">
					<div class="nav-icons">
						<i class="fas fa-user-friends fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3>Visitor</h3>
					</div>
				</a>
			</div>
		</div>
	</div>
	<div id="nav-components--staff" class="nav-components text-black text-center">
<!--		<h1 class="nav-title"><i class="fas fa-user-tie fa-lg"></i>&ensp;Staff</h1>-->
		<div class="row">
			<div class="col-sm-4">
				<a href="<?= site_url('staff') ?>">
					<div class="nav-icons">
						<i class="fas fa-user-cog fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3>TAO</h3>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a href="<?= site_url('staff') ?>">
					<div class="nav-icons">
						<i class="fas fa-user-secret fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3>Secretary</h3>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a href="<?= site_url('staff') ?>">
					<div class="nav-icons">
						<i class="fas fa-chalkboard-teacher fa-4x"></i>
					</div>
					<div class="nav-texts">
						<h3>Mentor</h3>
					</div>
				</a>
			</div>
		</div>
		<div id="staff-compo-back-block">
			<i id="staff-compo-back" class="fas fa-chevron-circle-left fa-2x"></i>
		</div>
	</div>
</div>