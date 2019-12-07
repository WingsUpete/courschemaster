	<!-- Main Block Ended -->
	</div>
	
	<!-- Footer -->
	<footer id="page-footer" class="page-footer">
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
		//	Navicon
		$('#navCourschemaster').on('show.bs.collapse', function() {
			if ($('.sidenav').css('position') === 'fixed') {
				$('.sidenav').addClass('fixed swipe_down');
			}
			$(this).find('.navbar-toggler').addClass('change_navicon');
			$(this).find('ul.navbar-nav').css('display', 'block');
			$(this).find('li.nav-item.phd').hide();
			GeneralFunctions.placeFooterToBottom();	// fix footer issue
		}).on('hidden.bs.collapse', function() {
			$(this).find('.navbar-toggler').removeClass('change_navicon');
			$(this).find('ul.navbar-nav').css('display', 'flex');
			$(this).find('li.nav-item.phd').show();
			GeneralFunctions.placeFooterToBottom();	// fix footer issue
		}).on('hide.bs.collapse', function() {
			if ($('.sidenav').css('position') === 'fixed') {
				$('.sidenav').removeClass('fixed swipe_down');
			}
			GeneralFunctions.placeFooterToBottom();	// fix footer issue
		});
		GeneralFunctions.placeFooterToBottom();			//	Pre-order footer		
	});
	
	//	Resize listener
	var t_ft = null;
	$(window).on('resize', function() {
		if (t_ft) {
			clearTimeout(t_ft);
		}
		t_ft = setTimeout(function() {
			if ($('.navbar-toggler').hasClass('change_navicon')) {
				$('.navbar-toggler').trigger('click');
			}
			GeneralFunctions.placeFooterToBottom();
		}, 500);
	}).trigger('resize');
</script>

</html>