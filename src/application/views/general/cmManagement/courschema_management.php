<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/cmManagement/courschema_management.css', NULL, 'css') ?>" />
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/courschema_management/courschema_management_helper.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/cmManagement/courschema_management/courschema_management.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		CourschemaManagement.initialize(true);
    });
</script>

<!-- Main content -->
<div id="courschema_management" class="main-content">
	<h1 class="hide-for-now">Courschema Management</h1>
	<hr class="hide-for-now" />
	<!-- card group -->
	<div class="alert alert-info alert-dismissible fade show tutorial" role="alert">
		<?= lang('courschema_tutorial') ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="card">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs" id="list-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link font-weight-bold active" id="specify_courschema" data-toggle="tab" title="<?= lang('specify_courschema') ?>" href="#specify_courschema-content" role="tab" aria-controls="specify_courschema-content" aria-selected="true"><?= lang('specify_courschema') ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link font-weight-bold" id="courschema_editor" data-toggle="tab" title="<?= lang('courschema_editor') ?>" href="#courschema_editor-content" role="tab" aria-controls="courschema_editor-content" aria-selected="false"><?= lang('courschema_editor') ?></a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			<div class="tab-content" id="list-tabs-content">
				<div class="tab-pane fade show active" id="specify_courschema-content" role="tabpanel" aria-labelledby="specify_courschema">
					<!-- add & upload -->
					<div class="row pl-3 pr-3 mb-3">
						<button type="button" class="btn btn-sm tool-btn new" data-toggle="tooltip" data-title="<?= lang('new') ?>"><i class="fas fa-plus fa-lg"></i></button>
						&ensp;&ensp;
						<button type="button" class="btn btn-sm tool-btn upload" data-toggle="tooltip" data-title="<?= lang('upload') ?>"><i class="fas fa-cloud-upload-alt fa-lg"></i></button>
					</div>
					<!-- select -->
					<?php
						$courschema_table_headers = array(
							lang('courschema_id'), lang('courschema_name'), lang('courschema_major'), lang('courschema_department')
						);
					?>
					<div class="table-responsive"><table id="courschemas-datatable" class="table table-bordered table-hover table-condensed text-center">
						<thead>
							<tr>
								<?php
									for ($i = 0; $i < count($courschema_table_headers); $i++) {
										echo('<th class="th-sm justify-content-center">' . $courschema_table_headers[$i] . '</th>');
									}
								?>
							</tr>
						</thead>
						<tbody></tbody>
					</table></div>
				</div>
				<div class="tab-pane fade" id="courschema_editor-content" role="tabpanel" aria-labelledby="courschema_editor">
    				<div class="container-fluid">
    					<div class="row">
    						<div class="col-xs-12 col-lg-6">
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><?= lang('file_name') ?></span>
									</div>
									<input id="editor-filename" type="text" class="form-control" />
									<div class="input-group-append">
										<span class="input-group-text">
											<select name="editor-file-extension" id="editor-file-extension">
												<option value="cmh" selected>.cmh</option>
												<option value="cmc">.cmc</option>
											</select>
										</span>
									</div>
								</div>
    							<pre id="editor">
INCLUDE = "SUSTech_english_requirement.cmh";
INCLUDE = "思想政治品德课程.cmh";
INCLUDE = "军训体育课程.cmh";
INCLUDE = "中文写作与交流.cmh";
INCLUDE = "公选课.cmh";

NAME
EN_NAME

VERSION

GROUP

INTRO
EN_INTRO

OBJECTIVES
EN_OBJECTIVES

PROGRAM_LENGTH = 4;

DEGREE = "工程学学士";
EN_DEGREE = "Bachelor of Engineering";

Event GRADUATION =
    							</pre>
    						</div>
    						<div class="col-xs-12 col-lg-6">
    							<div class="btn-toolbar justify-content-end mb-2 editor-btns">
    								<div class="btn-group">
    									<button id="editor-compile" type="button" class="btn btn-sm font-weight-bold editor-btn">
    										<?= lang('compile') ?>
    									</button>
    								</div>
    								<div class="btn-group">
    									<button id="editor-submit" type="button" class="btn btn-sm font-weight-bold editor-btn">
    										<?= lang('submit') ?>
    									</button>
    								</div>
    							</div>
								<div class="card border-light mb-3 list-graph-window">
									<div class="card-header"><?= lang('graph') ?></div>
									<div class="card-body">
										
									</div>
								</div>
    						</div>
    					</div>
    				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- courseWindow -->
<div class="modal fade top" id="uploadWindow" tabindex="-1" role="dialog" aria-labelledby="uploadWindowLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg side-modal modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="uploadWindowLabel"><?= lang('upload') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><?= lang('upload-courschema-support-file-types') ?></span>
						</div>
						<div class="custom-file">
							<input type="file" multiple class="custom-file-input" id="choose-files" aria-describedby="submit-files" />
							<label class="custom-file-label" for="choose-files"><?= lang('choose_file') ?></label>
						</div>
						<div class="input-group-append">
							<span class="input-group-text" id="submit-files" title="<?= lang('submit') ?>"><i class="fas fa-spell-check fa-sm"></i></span>
						</div>
					</div>
				</div>
				<h3 class="h3-responsive font-weight-bold mt-3 pl-2"><code>cmh</code></h3>
				<ul id="upload-cmh-list" class="list-group"></ul>
				<h3 class="h3-responsive font-weight-bold mt-3 pl-2"><code>cmc</code></h3>
				<ul id="upload-cmc-list" class="list-group"></ul>
			</div>
			<div class="modal-footer">
				<button id="upload-courschema" type="button" class="btn btn-primary btn-sm"><?= lang('upload') ?></button>
				<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
			</div>
		</div>
	</div>
</div>
