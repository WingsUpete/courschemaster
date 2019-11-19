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
	
	<!-- Preload JS Global Variables -->
	<script>
		var availableLanguages = <?= json_encode($this->config->item('available_languages')) ?>;
		var SCLang = <?= json_encode($this->lang->language) ?>;
		var GlobalVariables = {
			'csrfToken'			: <?= json_encode($this->security->get_csrf_hash()) ?>,
			'baseUrl'			: <?= json_encode($base_url) ?>
		};
	</script>
	
	<!-- Customize JS -->
	<script type="text/javascript" src="<?= asset_url('assets/js/general_functions.js', NULL, 'js') ?>"></script>
</head>

<body>
	<!-- Header -->
	<header>
		<nav id="navCourschemaster" class="navbar navbar-expand-lg navbar-dark blue lighten-1">
			<!-- Brand -->
			<a class="navbar-brand" href="<?= site_url() ?>">
				<!-- img src="< ?= asset_url('assets/img/favicon.png') ?>" alt="Courschemaster" / -->
				<!-- i class="fas fa-book"></i -->
				<span class="text-white"><strong>Courschemaster</strong></span>
			</a>
			<!-- Toggle Button - Navicon -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-contents" aria-controls="header-contents" aria-expanded="false" aria-label="Toggle Navigation">
				<span class="sr-only">Toggle Navigation</span>
				<span class="navbar-toggler-icon icon-bar bar1"></span>
				<span class="navbar-toggler-icon icon-bar bar2"></span>
				<span class="navbar-toggler-icon icon-bar bar3"></span>
			</button>
			<!-- Content -->
			<div class="collapse navbar-collapse" id="header-contents">
				<ul class="navbar-nav ml-auto nav-flex-icons">
					<li class="nav-item">
						<a id="lang_en" class="language nav-link active" href="javascript:void(0);">
							English
						</a>
					</li>
					<li class="nav-item">
						<a id="lang_chzn" class="language nav-link" href="javascript:void(0);">
							简体中文
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="javascript:void(0);">
							
						</a>
					</li>
					<li class="nav-item avatar">
						<a class="nav-link p-0" href="javascript:void(0);">
							<img src="<?= asset_url('assets/img/favicon.png') ?>" class="z-depth-0" alt="Avatar" height="35" />
							<span class="header_user_name align-middle">Peter S</span>
						</a>
					</li>
				</ul>
			</div>
		</nav> 
	</header>
	
	<div id="welcome_page" class="welcome_pages">
		<div id="nav-components" class="text-black text-center">
			<h1 class="nav-title">Courschemaster</h1>
			<div class="row">
				<div class="col-sm-4">
					<a href="javascript:void(0);">
						<div class="nav-icons">
							<i class="fas fa-chalkboard-teacher fa-4x"></i>
						</div>
						<div class="nav-texts">
							<h3>Student</h3>
						</div>
					</a>
				</div>
				<div class="col-sm-4">
					<a href="javascript:void(0);">
						<div class="nav-icons">
							<i class="fas fa-user-cog fa-4x"></i>
						</div>
						<div class="nav-texts">
							<h3>Staff</h3>
						</div>
					</a>
				</div>
				<div class="col-sm-4">
					<a href="javascript:void(0);">
						<div class="nav-icons">
							<i class="fas fa-user-edit fa-4x"></i>
						</div>
						<div class="nav-texts">
							<h3>Visitor</h3>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	
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