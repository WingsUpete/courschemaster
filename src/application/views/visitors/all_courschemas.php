<script type="text/javascript" src="<?= asset_url('assets/js/students/all_courschemas/all_courschemas.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/students/all_courschemas/all_courschemas_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		StudentsAllCourschemas.initialize(true);
    });
</script>

<!-- Main content -->
<div id="students_all_courschemas" class="main-content" style="padding: 20px;">
	<h2>All Courschemas</h2>
	<hr />
	<!-- Others -->
<div id="student_checkallcourschema" class="student_checkallcourschema">
    <div class="accordion" id="selection_accordion">
        <div class="card z-depth-0 bordered">
            <div class="card-header" id="headingOne2">
                <h5 class="mb-0">
                    <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseOne2"
                            aria-expanded="true" aria-controls="collapseOne2">
                        Choose Department
                    </button>
                </h5>
            </div>
            <div id="collapseOne2" class="collapse" aria-labelledby="headingOne2"
                 data-parent="#selection_accordion">
                <div class="card card-image" style="background-image:url(https://mdbootstrap.com/img/Photos/Others/gradient1.jpg);background-size:cover;">
                    <div class="text-white text-center py-5 px-4">
                        <div class="py-5">
                            <div class="row">
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Computer Science</a>
                                </div>
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Electronic</a>
                                </div>
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Finance</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Chemistry</a>
                                </div>
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Biology</a>
                                </div>
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Physics</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Mathematics</a>
                                </div>
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Mechanical Engineer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card z-depth-0 bordered">
            <div class="card-header" id="headingTwo2">
                <h5 class="mb-0">
                    <button class="btn collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                        Choose Major
                    </button>
                </h5>
            </div>
            <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo2"
                 data-parent="#selection_accordion">
                <div class="card card-image" href="student_checkspecificcourschema" style="background-image:url(https://mdbootstrap.com/img/Photos/Others/gradient1.jpg);background-size:cover;">
                    <div class="text-white text-center py-5 px-4">
                        <div class="py-5">
                            <div class="row">
                                <div class="col-xs-12 col-lg-4">
                                    <a class="btn peach-gradient"><i class="fa-3x"></i>&ensp;Computer Science</a>
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