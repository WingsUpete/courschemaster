	<!-- Footer -->
	<footer id="page-footer" class="page-footer blue">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-lg-5">
					<div>
						<ul id="power_copyright">
							<li>Powered by @SUSMusic x Courschemaster Team</li>
							<li>© 2019 Copyright:<span> SUSMusic x Courschemaster Team</span></li>
						</ul>
					</div>
				</div>
				<div class="col-xs-12 col-lg-2"></div>
				<div class="col-xs-12 col-lg-5">
					<div>
						<ul id="support_info">
							<li><a id="footer_QA" href="javascript:void(0);" target="_blank" data-toggle="tooltip" data-title="Q & A" data-placement="top"><strong>Question & Answers</strong></a></li>
							<li>Contact Administrator: <span id="admin_phone_number">80088208820</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>
</body>

<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
	
	window.addEventListener('load', function() {
		GeneralFunctions.placeFooterToBottom();			//	Pre-order footer
	});
	
	//	Resize listener
	$(window).on('resize', function() {
		GeneralFunctions.placeFooterToBottom();
	}).trigger('resize');
	
	//	Navicon
	$('#navCourschemaster').on('show.bs.collapse', function() {
		$(this).find('.navbar-toggler').addClass('change_navicon');
	}).on('hide.bs.collapse', function() {
		$(this).find('.navbar-toggler').removeClass('change_navicon');
	});
</script>

</html>