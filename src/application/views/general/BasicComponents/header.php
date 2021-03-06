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
	<meta name="Description" content="An OOAD Project for SUSTech_2017 - SUSMusic x Courschemaster Team" />
	<!-- Robots are for web crawling maybe... -->
	<meta name="Robots" content="index,follow" />
	<meta name="Author" content="SUSMusic x Courschemaster Team" />
	<!-- Viewport Settings -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<!------------------------------------------------- Meta ------------------------------------------------->
	<!-------------------------------------------------------------------------------------------------------->

	
	
	<!-- Title -->
	<title>Courschemaster</title>
	
	
	
	<!-------------------------------------------------------------------------------------------------------->
	<!------------------------------------------------- Link ------------------------------------------------->
	<!-- Logo icon for title and bookmark -->
<!--	<link rel="shortcut icon" type="image/png" href="--><?//= asset_url('assets/img/favicon.png') ?><!--" sizes="32x32" />-->
	<link rel="shortcut icon" href="<?= asset_url('assets/img/bitbug_favicon.ico') ?>" />
	<!-- Normalize.css -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/normalize/normalize.css', NULL, 'css') ?>" />
	<!-- FontAwesome -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/fontawesome/css/all.min.css', NULL, 'css') ?>" />
	<!-- JQueryUI -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/jqueryui/jquery-ui.min.css', NULL, 'css') ?>" />
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/bootstrap/css/bootstrap.min.css', NULL, 'css') ?>" />
	<!-- MDB -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/mdbootstrap/css/mdb.min.css', NULL, 'css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/mdbootstrap/css/addons/datatables.min.css', NULL, 'css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/mdbootstrap/css/modules/animations-extended.min.css', NULL, 'css') ?>" />
	<!-- bs-stepper -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/bs-stepper/dist/css/bs-stepper.min.css', NULL, 'css') ?>" />
	<!-- Pagination.js -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/paginationjs/dist/pagination.css', NULL, 'css') ?>" />
	<!------------------------------------------------- Link ------------------------------------------------->
	<!-------------------------------------------------------------------------------------------------------->
	
	
	
	<!-------------------------------------------------------------------------------------------------------->
	<!------------------------------------------------ Script ------------------------------------------------>
	<!-- jQuery -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/jquery/jquery-3.4.1.min.js', NULL, 'js') ?>"></script>
	<!-- JQueryUI -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/jqueryui/jquery-ui.min.js', NULL, 'js') ?>"></script>
	<!-- HTML5Shiv -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/html5shiv/html5shiv.min.js', NULL, 'js') ?>"></script>
	<!-- Respond -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/respond/respond.min.js', NULL, 'js') ?>"></script>
	<!-- FontAwesome -->
	<script type="text/javascript">
		//	Please don't transfer <i> to <svg> automatically!
		window.FontAwesomeConfig = {
			autoReplaceSvg: false
		};
	</script>
	<script type="text/javascript" src="<?= asset_url('assets/ext/fontawesome/js/all.min.js', NULL, 'js') ?>"></script>
	<!-- Bootstrap -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/bootstrap/js/bootstrap.bundle.min.js', NULL, 'js') ?>"></script>
	<!-- MDB -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/mdbootstrap/js/mdb.min.js', NULL, 'js') ?>"></script>
	<script type="text/javascript" src="<?= asset_url('assets/ext/mdbootstrap/js/addons/datatables.min.js', NULL, 'js') ?>"></script>
	<!-- bs-stepper -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/bs-stepper/dist/js/bs-stepper.min.js', NULL, 'js') ?>"></script>
	<!-- readmore -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/readmore-js/readmore.min.js', NULL, 'js') ?>"></script>
	<!-- Moment.js -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/momentjs/moment-with-locales.js', NULL, 'js') ?>"></script>
	<!-- Pagination.js -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/paginationjs/dist/pagination.min.js', NULL, 'js') ?>"></script>
	<!-- ACE -->
	<script type="text/javascript" src="<?= asset_url('assets/ext/ace-builds-master/src-noconflict/ace.js', NULL, 'js') ?>"></script>
	<script type="text/javascript" src="<?= asset_url('assets/ext/ace-builds-master/src-noconflict/ext-static_highlight.js', NULL, 'js') ?>"></script>
	<script type="text/javascript" src="<?= asset_url('assets/ext/ace-builds-master/src-noconflict/ext-language_tools.js', NULL, 'js') ?>"></script>
	<script type="text/javascript" src="<?= asset_url('assets/ext/ace-builds-master/src-noconflict/theme-monokai.js', NULL, 'js') ?>"></script>
	<script type="text/javascript" src="<?= asset_url('assets/ext/ace-builds-master/src-noconflict/mode-javascript.js', NULL, 'js') ?>"></script>
	<!------------------------------------------------ Script ------------------------------------------------>
	<!-------------------------------------------------------------------------------------------------------->
	
	<!-- Customize CSS -->
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css', NULL, 'css') ?>" />
	
	<!-- Preload JS Global Variables -->
	<script>
		var availableLanguages = <?= json_encode($this->config->item('available_languages')) ?>;
		var SCLang = <?= json_encode($this->lang->language) ?>;
		var curLang = '<?= $this->config->item('language') ?>';
	</script>
	
	<!-- Customize JS -->
	<script type="text/javascript" src="<?= asset_url('assets/js/general_functions.js', NULL, 'js') ?>"></script>
	<script type="text/javascript" src="<?= asset_url('assets/js/initialize.js', NULL, 'js') ?>"></script>
</head>

<body>
	<div id="bg-img"></div>

<div id="body-container">
	<!-- Header -->
	<header>
		<nav id="navCourschemaster" class="navbar navbar-expand-md navbar-dark lighten-1">
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
						<?php $active = (ucfirst($this->config->item('language')) == 'English') ? 'active' : ''; ?>
						<a class="language nav-link <?= $active ?>" href="javascript:void(0);" data-language="english">
							English
						</a>
					</li>
					<li class="nav-item">
						<?php $active = ($this->config->item('language') == '简体中文') ? 'active' : ''; ?>
						<a class="language nav-link <?= $active ?>" href="javascript:void(0);" data-language="简体中文">
							简体中文
						</a>
					</li>
					<li class="nav-item phd"><a class="nav-link" href="javascript:void(0);"></a></li>
					<li class="nav-item avatar header_user_name">
						<div class="nav-link p-0">
							<?php if ($logged_in == 'true'): ?>
								<span class="user_data">
									<?= $user_sid . ' ' . $user_name ?>
								</span>
								&nbsp;
								<a class="btns" href="<?= site_url('user/logout') ?>">
									<i class="fas fa-running"></i>&ensp;<?= lang('logout') ?>
								</a>
							<?php elseif ($logged_in == 'false'): ?>
								<a class="btns" href="<?= site_url('user/login') ?>">
									<i class="fas fa-sign-in-alt"></i>&ensp;<?= lang('login') ?>
								</a>
							<?php endif; ?>
						</div>
					</li>
				</ul>
			</div>
		</nav> 
	</header>
	
	<!-- Later: notification -->
	<div id="notification"></div>

	<!-- Later: loading icon -->
	<div id="loading">
		<div class="spinner-grow text-danger" role="status">
			<span class="sr-only">Loading...</span>
		</div>
		<div class="spinner-grow text-warning" role="status">
			<span class="sr-only">Loading...</span>
		</div>
		<div class="spinner-grow text-info" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
	
	<!-- Main Block Started -->
	<div id="main-block">
