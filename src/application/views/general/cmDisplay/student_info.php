<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
//		Collection.initialize(true);
    });
</script>

<!-- Main content -->
<div id="student_info" class="main-content">
	<h1>Student Info</h1>
	<hr />
	<!-- ... -->
	
</div>