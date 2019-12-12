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
<div id="review" class="main-content">
	<h1 class="hide-for-now">Review</h1>
	<hr class="hide-for-now" />
	<!-- ... -->
	
</div>
