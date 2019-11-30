	<div id="sidebar" class="sidenav">
		<a id="closeNav" href="javascript:void(0);" class="closebtn">&times;</a>
		<a id="toggleExpansionNav" href="javascript:void(0);" class="expandbtn">
			<i class="fas fa-sign-out-alt noflip fa-xs"></i>
			<i class="fas fa-sign-out-alt fa-flip-horizontal fa-xs"></i>
		</a>
		<!-- Sidenav Items -->
		<div class="sidenav-items">
			<?php
				foreach($sidebar AS $group) {
					echo('<hr />');
					foreach($group AS $item) {
						$active = ($active_sidebar == $item['mark'] ? 'active' : '');
						echo('<a href="' . $item['url'] . '" class="' . $active . '">');
						echo('<span class="sp_icn"><i class="fas fa-' . $item['icon'] . '"></i></span>');
						echo('&ensp;');
						echo('<span class="sd_epn">' . $item['name'] . '</span>');
						echo('</a>');
					}
				}
			?>
		</div>
	</div>
	
	<button id="openNav" class="btn">
		<i class="fas fa-bars"></i>
	</button>
	
	<script>
		var mql = window.matchMedia("screen and (max-width: 600px)");
		mediaQueryResponse(mql);
		mql.addListener(mediaQueryResponse);
		
		function mediaQueryResponse(mql) {
			if (mql.matches) {
				$('.sidenav').removeClass('mobile').removeClass('stretched').removeClass('expanded');
				$('.sidenav').addClass('mobile');
				GeneralFunctions.placeFooterToBottom();	// fix footer issue
				return true;
			} else {
				$('.sidenav').removeClass('mobile').removeClass('stretched').removeClass('expanded');
				$('.sidenav').removeClass('mobile');
				GeneralFunctions.placeFooterToBottom();	// fix footer issue
				return false;
			}
		}
		
		$(document).on('click', '.sidenav #toggleExpansionNav', function() {
			$('#sidebar').toggleClass('expanded');
			GeneralFunctions.placeFooterToBottom();	// fix footer issue
		});
		
		$(document).on('click', '.sidenav.mobile + #openNav', function() {
			$('.sidenav').addClass('stretched');
		});
		$(document).on('click', '.sidenav.mobile #closeNav', function() {
			$('.sidenav').removeClass('stretched');
		});
	</script>