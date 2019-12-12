<script type="text/javascript" src="<?= asset_url('assets/js/students/my_plan/my_plan.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/students/my_plan/my_plan_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		StudentsMyPlan.initialize(true);
    });
</script>

<!-- Main content -->
<div id="students_learned" class="main-content">
	<h1 class="hide-for-now"><?= lang('learned') ?></h1>
	<hr class="hide-for-now" />
	<!-- Others -->

</div>
