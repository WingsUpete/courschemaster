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
<div id="courschema_management" class="main-content">
	<h1 class="hide-for-now">Courschema Management</h1>
	<hr class="hide-for-now" />
	<!-- ... -->
	<pre>
		<code class="language-css" contenteditable="true">
			p {
				color: red;
			}
		</code>
	</pre>
</div>
