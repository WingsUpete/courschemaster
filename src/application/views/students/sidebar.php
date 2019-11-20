	<div id="sidebar" class="sidenav">
		<a id="closeNav" href="javascript:void(0);" class="closebtn">&times;</a>
		<div class="sidenav-items">
			<a href="#">My Courschema</a>
			<a href="#">All Courschemas</a>
			<a href="#">Collection</a>
			<hr />
			<a href="#">My Plan</a>
			<hr />
			<a href="#">Learned</a>
		</div>
	</div>
	
	<button id="openNav" class="btn btn-primary">
		<i class="fas fa-bars"></i>
	</button>
	
	<script>
		$('#openNav').click(function() {
			$('#sidebar').css('width', '100%');
			$('body').css('background-color', 'rgba(0, 0, 0, 0.4)');
		});
		$('#closeNav').click(function() {
			$('#sidebar').css('width', '0');
			$('body').css('background-color', 'white');
		});
	</script>