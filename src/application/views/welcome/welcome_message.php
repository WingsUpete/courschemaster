<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };
</script>

	<!-- Main content -->
	<div id="welcome_page" class="main-content">
		<div id="nav-components" class="text-black text-center">
			<h1 class="nav-title">Courschemaster</h1>
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
	</div>