<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-------------------------------------------------------------------------------------------------------->
	<!------------------------------------------------- Meta ------------------------------------------------->
	<!-- Content Type and Charset -->
	<meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!-- Render web pages using the Edge engine, and enable Google Chrome Frame in the meantime -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<!-- Additional Info of the page -->
	<meta name="Keywords" content="SUSTech, SUSMusic, Courschemaster, OOAD" />
	<meta name="Description" content="An OOAD Project for SUSTech_2017 - SUSMusic-Courschemaster Team" />
	<!-- Robots are for web crawling maybe... -->
	<meta name="Robots" content="index,follow" />
	<meta name="Author" content="SUSMusic x Courschemaster Team" />
	<!-- Viewport Settings -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<!------------------------------------------------- Meta ------------------------------------------------->
	<!-------------------------------------------------------------------------------------------------------->

	
	
	<!-- Title -->
	<title>Welcome&nbsp;|&nbsp;Courschemaster</title>
	
	
	
	<!-------------------------------------------------------------------------------------------------------->
	<!------------------------------------------------- Link ------------------------------------------------->
	<!-- Logo icon for title and bookmark -->
	<link rel="shortcut icon" type="image/png" href="<?= asset_url('assets/img/favicon.png') ?>" sizes="32x32" />
	
	<!-- Normalize.css -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/normalize/normalize.css', NULL, 'css') ?>" />
	<!-- FontAwesome -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/fontawesome/css/all.min.css', NULL, 'css') ?>" />
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/bootstrap/css/bootstrap.min.css', NULL, 'css') ?>" />
	<!-- MDB -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/mdbootstrap/css/mdb.min.css', NULL, 'css') ?>" />
	<!------------------------------------------------- Link ------------------------------------------------->
	<!-------------------------------------------------------------------------------------------------------->
	
	
	
	<!-------------------------------------------------------------------------------------------------------->
	<!------------------------------------------------ Script ------------------------------------------------>
	<!-- jQuery -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/jquery/jquery-3.4.1.min.js', NULL, 'js') ?>"></script>
	<!-- HTML5Shiv -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/html5shiv/html5shiv.min.js', NULL, 'js') ?>"></script>
	<!-- Respond -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/respond/respond.min.js', NULL, 'js') ?>"></script>
	<!-- FontAwesome -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/fontawesome/js/all.min.js', NULL, 'js') ?>"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/bootstrap/js/bootstrap.bundle.min.js', NULL, 'js') ?>"></script>
	<!-- MDB -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/mdbootstrap/js/mdb.min.js', NULL, 'js') ?>"></script>
	<!------------------------------------------------ Script ------------------------------------------------>
	<!-------------------------------------------------------------------------------------------------------->
	
	<!-- Customize CSS -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/welcome/welcome.css', NULL, 'css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css', NULL, 'css') ?>" />
	
	<!-- Customize JS -->
	<script type="text/javascript" src="<?= asset_url('assets/js/general_functions.js', NULL, 'js') ?>"></script>
	
</head>

<body>
	<div id="welcome_page" class="welcome_pages">
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
	</div>
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
</script>

</html>