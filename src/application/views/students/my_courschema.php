<script type="text/javascript" src="<?= asset_url('assets/js/students/my_courschema/my_courschema.js', NULL, 'js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('assets/js/students/my_courschema/my_courschema_helper.js', NULL, 'js') ?>"></script>
<script>
    var GlobalVariables = {
        csrfToken          : <?= json_encode($this->security->get_csrf_hash()) ?>,
		baseUrl            : <?= json_encode($base_url) ?>
    };

    $(document).ready(function() {
		StudentsMyCourschema.initialize(true);
    });
</script>

<!-- Main content -->
<div id="students_all_courschemas" class="main-content" style="padding: 20px;">
	<h2>My Courschema</h2>
	<hr />
	<div id="student_checkspecificcourschema" class="student_checkspecificcourschema">
		<ul class="nav nav-tabs" id="courschema_list" role="tablist">
			<li class="nav-item">
				<!--通识先修课-->
				<a class="nav-link active" id="General_compulsory-tab" data-toggle="tab" href="#General_compulsory" role="tab" aria-controls="General_compulsory" aria-selected="true">General compulsory</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="Professional_foundation-tab" data-toggle="tab" href="#Professional_foundation" role="tab" aria-controls="Professional_foundation" aria-selected="false">Professional foundation</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="Professional_core-tab" data-toggle="tab" href="#Professional_core" role="tab" aria-controls="Professional_core" aria-selected="false">Professional core</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="Professional_elective-tab" data-toggle="tab" href="#Professional_elective" role="tab" aria-controls="Professional_elective" aria-selected="false">Professional elective</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="General_elective-tab" data-toggle="tab" href="#General_elective" role="tab" aria-controls="General_elective" aria-selected="false">General elective</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="Practice-tab" data-toggle="tab" href="#Practice" role="tab" aria-controls="Practice" aria-selected="false">Practice</a>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="General_compulsory" role="tabpanel" aria-labelledby="General_compulsory-tab">
				<table id="General_compulsory_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
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
						</tfoot>
				</table>
			</div>
			<div class="tab-pane fade" id="Professional_foundation" role="tabpanel" aria-labelledby="Professional_foundation-tab">
				<table id="Professional_foundation_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
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
							<td>CS208</td>
							<td>算法设计与分析</td>
							<td>64</td>
							<td>3</td>
							<td>计算机程序设计基础A、数据结构与算法分析</td>
							<td>计算机科学与工程系</td>
						</tr>
						<tr>
							<td>CS202</td>
							<td>数字逻辑</td>
							<td>64</td>
							<td>3</td>
							<td>无</td>
							<td>计算机科学与工程系</td>
						</tr>
						<tr>
							<td>CS301</td>
							<td>嵌入式系统与微机原理</td>
							<td>64</td>
							<td>3</td>
							<td>数字逻辑</td>
							<td>计算机科学与工程系</td>
						</tr>
						<tr>
							<td>CS307</td>
							<td>数据库原理</td>
							<td>64</td>
							<td>3</td>
							<td>无</td>
							<td>计算机科学与工程系</td>
						</tr>
						<tr>
							<td>CS305</td>
							<td>计算机网络</td>
							<td>64</td>
							<td>3</td>
							<td>计算机程序设计基础A</td>
							<td>计算机科学与工程系</td>
						</tr>
						<tr>
							<td>CS303</td>
							<td>人工智能</td>
							<td>64</td>
							<td>3</td>
							<td>计算机程序设计基础A、数据结构与算法分析、概率论与数理统计</td>
							<td>计算机科学与工程系</td>
						</tr>
						<tr>
							<td>CS309</td>
							<td>面向对象</td>
							<td>64</td>
							<td>3</td>
							<td>计算机程序设计基础A、数据结构与算法分析</td>
							<td>计算机科学与工程系</td>
						</tr>
						</tfoot>
				</table>
			</div>
			<div class="tab-pane fade" id="Professional_core" role="tabpanel" aria-labelledby="Professional_core-tab">
				<table id="Professional_core_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
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
						</tfoot>
				</table>
			</div>
			<div class="tab-pane fade" id="Professional_elective" role="tabpanel" aria-labelledby="Professional_elective-tab">
				<table id="Professional_elective_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
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
						</tfoot>
				</table>
			</div>
			<div class="tab-pane fade" id="General_elective" role="tabpanel" aria-labelledby="General_elective-tab">
				<table id="General_elective_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
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
						</tfoot>
				</table>
			</div>
			<div class="tab-pane fade" id="Practice" role="tabpanel" aria-labelledby="Practice-tab">
				<table id="Practice_courselist" class="table table-striped table-bordered table-hover table-condensed text-center">
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
						</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="container">
		<p class="note note-warning" style="margin: 0;"><strong>介绍 : </strong>
		</p>
	</div>
</div>