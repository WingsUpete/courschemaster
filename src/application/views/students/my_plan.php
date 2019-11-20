<script type="text/javascript" src="<?= asset_url('assets/js/students/my_plan/my_plan.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/students/my_plan/my_plan_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		StudentsMyPlan.initialize(true);
    });
</script>

<!-- Main content -->
<div id="students_my_plan" class="main-content" style="padding: 20px;">
	<h2>My Plan</h2>
	<hr />
	<!-- Others -->
    <ul class="nav nav-tabs" id="courschema_list" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="First_grade_one-tab" data-toggle="tab" href="#First_grade_one" role="tab" aria-controls="First_grade_one"
                   aria-selected="true">大一秋</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="First_grade_two-tab" data-toggle="tab" href="#First_grade_two" role="tab" aria-controls="First_grade_two"
                   aria-selected="false">大一春</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="First_grade_three-tab" data-toggle="tab" href="#First_grade_three" role="tab" aria-controls="First_grade_three"
                   aria-selected="false">大一夏</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Second_grade_one-tab" data-toggle="tab" href="#Second_grade_one" role="tab" aria-controls="Second_grade_one"
                   aria-selected="false">大二秋</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Second_grade_two-tab" data-toggle="tab" href="#Second_grade_two" role="tab" aria-controls="Second_grade_two"
                   aria-selected="false">大二春</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Second_grade_three-tab" data-toggle="tab" href="#Second_grade_three" role="tab" aria-controls="Second_grade_three"
                   aria-selected="false">大二下</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Third_grade_one-tab" data-toggle="tab" href="#Third_grade_one" role="tab" aria-controls="Third_grade_one"
                   aria-selected="false">大三秋</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Third_grade_two-tab" data-toggle="tab" href="#Third_grade_two" role="tab" aria-controls="Third_grade_two"
                   aria-selected="false">大三春</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Third_grade_three-tab" data-toggle="tab" href="#Third_grade_three" role="tab" aria-controls="Third_grade_three"
                   aria-selected="false">大三夏</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Fourth_grade_one-tab" data-toggle="tab" href="#Fourth_grade_one" role="tab" aria-controls="Fourth_grade_one"
                   aria-selected="false">大四秋</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Fourth_grade_two-tab" data-toggle="tab" href="#Fourth_grade_two" role="tab" aria-controls="Fourth_grade_two"
                   aria-selected="false">大四春</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="First_grade_one" role="tabpanel" aria-labelledby="First_grade_one-tab">
                <table id="First_grade_one_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS102A</td>
                        <td>计算机程序设计基础A</td>
                        <td>64</td>
                        <td>4</td>
                        <td>无</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>MA107A</td>
                        <td>线性代数A</td>
                        <td>64</td>
                        <td>4</td>
                        <td>无</td>
                        <td>数学系</td>
                    </tr>
                    <tr>
                        <td>BIO102B</td>
                        <td>生命科学概论</td>
                        <td>48</td>
                        <td>3</td>
                        <td>无</td>
                        <td>生物系</td>
                    </tr>
                    <tr>
                        <td>PHY104B</td>
                        <td>基础物理实验</td>
                        <td>32</td>
                        <td>1.5</td>
                        <td>无</td>
                        <td>物理系</td>
                    </tr>
                    <tr>
                        <td>IPE101</td>
                        <td>思想道德修养和法律基础</td>
                        <td>32</td>
                        <td>2</td>
                        <td>无</td>
                        <td>思政中心</td>
                    </tr>
                    <tr>
                        <td>CLE021</td>
                        <td>SUStech English I</td>
                        <td>32</td>
                        <td>4</td>
                        <td>无</td>
                        <td>语言中心</td>
                    </tr>
                    <tr>
                        <td>GE131</td>
                        <td>体育 I</td>
                        <td>32</td>
                        <td>1</td>
                        <td>无</td>
                        <td>体育中心</td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="First_grade_two" role="tabpanel" aria-labelledby="First_grade_two-tab">
                <table id="First_grade_two_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS201</td>
                        <td>离散数学</td>
                        <td>64</td>
                        <td>3</td>
                        <td>高等数学(下)A、线性代数A</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS202</td>
                        <td>计算机组成原理</td>
                        <td>64</td>
                        <td>3</td>
                        <td>数字逻辑</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>MA212</td>
                        <td>概率论与数理统计</td>
                        <td>48</td>
                        <td>3</td>
                        <td>数学分析II或高等数学(下)A</td>
                        <td>数学系</td>
                    </tr>
                    <tr>
                        <td>CS203</td>
                        <td>数据结构与算法分析</td>
                        <td>64</td>
                        <td>3</td>
                        <td>计算机程序设计基础A</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS201</td>
                        <td>离散数学</td>
                        <td>64</td>
                        <td>3</td>
                        <td>高等数学(下)A、线性代数A</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS202</td>
                        <td>计算机组成原理</td>
                        <td>64</td>
                        <td>3</td>
                        <td>数字逻辑</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>MA212</td>
                        <td>概率论与数理统计</td>
                        <td>48</td>
                        <td>3</td>
                        <td>数学分析II或高等数学(下)A</td>
                        <td>数学系</td>
                    </tr>
                    <tr>
                        <td>CS203</td>
                        <td>数据结构与算法分析</td>
                        <td>64</td>
                        <td>3</td>
                        <td>计算机程序设计基础A</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS201</td>
                        <td>离散数学</td>
                        <td>64</td>
                        <td>3</td>
                        <td>高等数学(下)A、线性代数A</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS202</td>
                        <td>计算机组成原理</td>
                        <td>64</td>
                        <td>3</td>
                        <td>数字逻辑</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>MA212</td>
                        <td>概率论与数理统计</td>
                        <td>48</td>
                        <td>3</td>
                        <td>数学分析II或高等数学(下)A</td>
                        <td>数学系</td>
                    </tr>
                    <tr>
                        <td>CS203</td>
                        <td>数据结构与算法分析</td>
                        <td>64</td>
                        <td>3</td>
                        <td>计算机程序设计基础A</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="First_grade_three" role="tabpanel" aria-labelledby="First_grade_three-tab">
                <table id="First_grade_three_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS205</td>
                        <td>C/C++程序设计</td>
                        <td>64</td>
                        <td>4</td>
                        <td>考试</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>MA107A</td>
                        <td>线性代数A</td>
                        <td>64</td>
                        <td>4</td>
                        <td>考试</td>
                        <td>数学系</td>
                    </tr>
                    <tr>
                        <td>BIO102B</td>
                        <td>生命科学概论</td>
                        <td>48</td>
                        <td>3</td>
                        <td>考试</td>
                        <td>生物系</td>
                    </tr>
                    <tr>
                        <td>PHY104B</td>
                        <td>基础物理实验</td>
                        <td>32</td>
                        <td>1.5</td>
                        <td>答辩</td>
                        <td>物理系</td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="Second_grade_one" role="tabpanel" aria-labelledby="Second_grade_one-tab">
                <table id="Second_grade_one_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS205</td>
                        <td>C/C++程序设计</td>
                        <td>64</td>
                        <td>4</td>
                        <td>无</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>MA333</td>
                        <td>大数据挖掘</td>
                        <td>64</td>
                        <td>3</td>
                        <td>概率论和数理统计或概率论</td>
                        <td>数学系</td>
                    </tr>
                    <tr>
                        <td>EE205</td>
                        <td>信号和系统</td>
                        <td>64</td>
                        <td>3</td>
                        <td>考试</td>
                        <td>电子与电气工程系</td>
                    </tr>
                    <tr>
                        <td>CS101A</td>
                        <td>计算机导论A</td>
                        <td>32</td>
                        <td>2</td>
                        <td>考试</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="Second_grade_two" role="tabpanel" aria-labelledby="Second_grade_two-tab">
                <table id="Second_grade_two_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS102A</td>
                        <td>计算机程序设计基础A</td>
                        <td>64</td>
                        <td>4</td>
                        <td>考试</td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>MA107A</td>
                        <td>线性代数A</td>
                        <td>64</td>
                        <td>4</td>
                        <td>考试</td>
                        <td>数学系</td>
                    </tr>
                    <tr>
                        <td>BIO102B</td>
                        <td>生命科学概论</td>
                        <td>48</td>
                        <td>3</td>
                        <td>考试</td>
                        <td>生物系</td>
                    </tr>
                    <tr>
                        <td>PHY104B</td>
                        <td>基础物理实验</td>
                        <td>32</td>
                        <td>1.5</td>
                        <td>答辩</td>
                        <td>物理系</td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="Second_grade_three" role="tabpanel" aria-labelledby="Second_grade_three-tab">
                <table id="Second_grade_three_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS470</td>
                        <td>工业实习</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS490</td>
                        <td>毕业论文</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="Third_grade_one" role="tabpanel" aria-labelledby="Third_grade_one-tab">
                <table id="Third_grade_one_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS470</td>
                        <td>工业实习</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS490</td>
                        <td>毕业论文</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="Third_grade_two" role="tabpanel" aria-labelledby="Third_grade_two-tab">
                <table id="Third_grade_two_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS470</td>
                        <td>工业实习</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS490</td>
                        <td>毕业论文</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>

                </table>
            </div>
            <div class="tab-pane fade" id="Third_grade_three" role="tabpanel" aria-labelledby="Third_grade_three-tab">
                <table id="Third_grade_three_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS470</td>
                        <td>工业实习</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS490</td>
                        <td>毕业论文</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="Fourth_grade_one" role="tabpanel" aria-labelledby="Fourth_grade_one-tab">
                <table id="Fourth_grade_one_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS470</td>
                        <td>工业实习</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS490</td>
                        <td>毕业论文</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>

                </table>
            </div>
            <div class="tab-pane fade" id="Fourth_grade_two" role="tabpanel" aria-labelledby="Fourth_grade_two-tab">
                <table id="Fourth_grade_two_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="alert-primary">
                    <tr>
                        <th class="th-sm justify-content-center">Course ID</th>
                        <th class="th-sm">Course Name</th>
                        <th class="th-sm">Period</th>
                        <th class="th-sm">Course Credit</th>
                        <th class="th-sm">Prerequisite</th>
                        <th class="th-sm">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CS470</td>
                        <td>工业实习</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                    <tr>
                        <td>CS490</td>
                        <td>毕业论文</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>计算机科学与工程系</td>
                    </tr>
                </table>
            </div>
        </div>
</div>
