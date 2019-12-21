window.MatryonaTranslateClass = window.MatryonaTranslateClass || {};	// Browser Compatibility

/**
 *
 * An example of a Static Class
 *
 * @module StaticClass
 */
(function (exports) {

	'use strict';	// strict mode execution: This means no undeclared variable usage.

	// an example static method
	// to call this method, write `StaticClass.exampleStaticMethod('Hi')`
	/**
	 * @return {string}
	 */
	exports.Matryona_to_List = function (){
		//get the list
		//here we need give it a courschema by click*************
		let courschema = load("计算机科学与技术 1+3 (2018).cmc");

		var files = courschema.split("INCLUDE = ");
		for (var i=0; i<files.length; i++){
			files[i] = files[i].split(";")[0];
		}
		var all = courschema;
		for (var i=0; i<files.length; i++){
			let file_content = load(files[i]);
			all = all + file_content;
		}

		//base information of courschema
		var NAME = courschema.split("NAME = ")[1].split("\"")[1];
		var EN_NAME = courschema.split("EN_NAME = ")[1].split("\"")[1];
		var G = courschema.split("GROUP = (")[1].split(");")[0].replace(/\"/g, " ").split(") || (");
		var GROUP = [];
		for (var i=0; i<G.length; i++){
			GROUP.push(G[i].replace(" && "," "));
		}

		var VERSION = courschema.split("VERSION = ")[1].split(";")[0];
		var PROGRAM_LENGTH = courschema.split("PROGRAM_LENGTH = ")[1].split(";")[0];
		var INTRO = courschema.split("INTRO = ")[1].split("\"")[1];
		var EN_INTRO = courschema.split("EN_INTRO = ")[1].split("\"")[1];
		var OBJECTIVES = courschema.split("OBJECTIVES = ")[1].split("\"")[1];
		var EN_OBJECTIVES = courschema.split("EN_OBJECTIVES = ")[1].split("\"")[1];
		var DEGREE = courschema.split("DEGREE = ")[1].split("\"")[1];
		var EN_DEGREE = courschema.split("EN_DEGREE = ")[1].split("\"")[1];

		//resolve event of courschema
		var temp = all.split("Event ");

		var list = [];
		var nest_event;
		var char;
		var char_list = [];

		var expression;

		var event_list = [];
		var event;
		var event_name;

		var description = {
			name: NAME,
			en_name: EN_NAME,
			group: GROUP,
			version: VERSION,
			program_length: PROGRAM_LENGTH,
			intro: INTRO,
			en_intro: EN_INTRO,
			objectives: OBJECTIVES,
			en_objectives: EN_OBJECTIVES,
			degree: DEGREE,
			en_degree: EN_DEGREE
		};
		list.push(description);

		//event object
		for (var i = 1; i < temp.length; i++) {
			if (temp[i].indexOf("GRADUATION") !== -1) {
				event = {id: i - 1, name: "Graduation", rank:0};
				event_list.push(event);
			} else {
				if (temp[i].indexOf("ComEvent") !== -1) {
					event_name = temp[i].split("=")[0].replace(" ","");
					event = {id: i - 1, name:event_name, rank:1};
					event_list.push(event);
				}else if (temp[i].indexOf("CourseEvent") !== -1){
					event_name = temp[i].split("=")[0].replace(" ","");
					event = {id: i - 1, name:event_name, rank:2};
					event_list.push(event);
				}else if (temp[i].indexOf("ScoreEvent") !== -1){
					event_name = temp[i].split("=")[0].replace(" ","");
					event = {id: i - 1, name:event_name, rank:3};
					event_list.push(event);
				}else if (temp[i].indexOf("VariableEvent") !== -1){
					event_name = temp[i].split("=")[0].replace(" ","");
					event = {id: i - 1, name:event_name, rank:4};
					event_list.push(event)
				}
			}
		}

		//json
		for (var j = 1; j < temp.length; j++) {

			char_list = [];
			if (event_list[j-1].rank === 4){
				expression = temp[j].split("Event")[1].split(";")[0].split(", ");
				char = ["variable", expression[0].replace("( ","")];
				char_list.push(char);
				event_name = expression[1].replace(" )","");
				for (var l=0; l<event_list.length; l++){
					if (event_name === event_list[l].name){
						char = ["subevent", event_list[l].name, event_list[l].id];
						break;
					}
				}
				char_list.push(char);
			}else if (event_list[j-1].rank === 3){
				char = ["scorevent", temp[j].split("Event")[1].split(";")[0]];
				char_list.push(char);
			}else if (event_list[j-1].rank === 2){
				expression = temp[j].split("Event")[1].split(";")[0].split(" ");
				for (var k=0; k<expression.length; k++){
					if (expression[k].indexOf("=") !== -1 || expression[k].indexOf("&&") !== -1 || expression[k].indexOf("^") !== -1 || expression[k].indexOf("||") !== -1 || expression[k].indexOf("!") !== -1 || expression[k].indexOf("(") !== -1 || expression[k].indexOf(")") !== -1){
						char = ["operator", expression[k]];
						char_list.push(char);
					}else{
						char = ["course", expression[k]];
						char_list.push(char);
					}
				}
			}else{
				expression = temp[j].split("Event")[1].split(";")[0].split(" ");
				for (var k=0; k<expression.length; k++){
					if (expression[k].indexOf("=") !== -1 || expression[k].indexOf("&&") !== -1 || expression[k].indexOf("^") !== -1 || expression[k].indexOf("||") !== -1 || expression[k].indexOf("!") !== -1 || expression[k].indexOf("(") !== -1 || expression[k].indexOf(")") !== -1){
						char = ["operator", expression[k]];
						char_list.push(char);
					}else{
						for (var l=0; l<event_list.length; l++){
							if (expression[k] === event_list[l].name){
								char = ["subevent", event_list[l].name, event_list[l].id];
								break;
							}
						}
						char_list.push(char);
					}
				}
			}

			nest_event = {
				event_id:event_list[j-1].id,
				event_name:event_list[j-1].name,
				event_rank:event_list[j-1].rank,
				event_expression:char_list
			};
			list.push(nest_event);
		}
		return JSON.stringify(list);
	};

	/**
	 * @return {string}
	 */
	exports.Matryona_to_Graph = function (){//get the graph
		let courschema = load("计算机科学与技术 1+3 (2018).cmc");

		var files = courschema.split("INCLUDE = ");
		for (var i=0; i<files.length; i++){
			files[i] = files[i].split(";")[0];
		}
		var all = courschema;
		for (var i=0; i<files.length; i++){
			let file_content = load(files[i]);
			all = all + file_content;
		}
		window.list = [];
		var status_list = [];

		//base information of courschema
		var NAME = courschema.split("NAME = ")[1].split("\"")[1];
		var EN_NAME = courschema.split("EN_NAME = ")[1].split("\"")[1];
		var G = courschema.split("GROUP = (")[1].split(");")[0].replace(/\"/g, " ").split(") || (");
		var GROUP = [];
		for (var i = 0; i < G.length; i++) {
			GROUP.push(G[i].replace(" && ", " "));
		}

		var VERSION = courschema.split("VERSION = ")[1].split(";")[0];
		var PROGRAM_LENGTH = courschema.split("PROGRAM_LENGTH = ")[1].split(";")[0];
		var INTRO = courschema.split("INTRO = ")[1].split("\"")[1];
		var EN_INTRO = courschema.split("EN_INTRO = ")[1].split("\"")[1];
		var OBJECTIVES = courschema.split("OBJECTIVES = ")[1].split("\"")[1];
		var EN_OBJECTIVES = courschema.split("EN_OBJECTIVES = ")[1].split("\"")[1];
		var DEGREE = courschema.split("DEGREE = ")[1].split("\"")[1];
		var EN_DEGREE = courschema.split("EN_DEGREE = ")[1].split("\"")[1];

		var description = {
			name: NAME,
			en_name: EN_NAME,
			group: GROUP,
			version: VERSION,
			program_length: PROGRAM_LENGTH,
			intro: INTRO,
			en_intro: EN_INTRO,
			objectives: OBJECTIVES,
			en_objectives: EN_OBJECTIVES,
			degree: DEGREE,
			en_degree: EN_DEGREE
		};
		list.push(description);


		var node;
		var node_list = [];
		var id_num;
		var node_id;
		var node_name;
		var node_type;
		var event_type;

		var temp = all.split("Event ");
		for (var i = 1; i < temp.length; i++) {
			node_id = i - 1;
			node_name = temp[i].split(" = ")[0];
			event_type = temp[i].split(" = ")[1].split("(")[0];
			if (node_name === "GRADUATION") {
				node_type = 2;                 //root
			} else {
				node_type = 0;
			}
			node = {node_id: node_id, node_name: node_name, node_type: node_type};
			node_list.push(node);
		}
		id_num = temp.length - 1;
		
		var nest_node;
		var son;
		var son_list;
		var s;
		var status = [];   //avoid course repeat


		for (var i = 1; i < temp.length; i++) {
			event_type = temp[i].split(" = ")[1].split("(")[0];
			if (event_type === "ScoreEvent") {
				s = temp[i].split("Event")[1].split(";")[0];
				node = {node_id: id_num, node_name: s, node_type: 3};
				node_list.push(node);
				id_num++;

				son_list = [];
				son = {node_id: node.node_id, node_name: node.node_name};
				son_list.push(son);
				nest_node = {
					node_id: node_list[i - 1].node_id,
					node_name: node_list[i - 1].node_name,
					node_type: node_list[i - 1].node_type,
					node_son: son_list
				};
				if (status_list[nest_node.node_name] !== true){
					list.push(nest_node);
					status_list[nest_node.node_name] = true;
				}

				//varevent
			} else if (event_type === "VariableEvent") {
				//son1
				son_list = [];
				s = temp[i].split("Event")[1].split(";")[0].replace("( ", "").replace(" )", "").split(",");
				node = {node_id: id_num, node_name: s[0], node_type: 3};
				node_list.push(node);
				id_num++;
				son = {node_id: node.node_id, node_name: node.node_name};
				son_list.push(son);
				//son2
				s[1] = s[1].replace(" ", "");
				for (var j = 0; j < node_list.length; j++) {
					if (node_list[j].node_name === s[1]) {
						break;
					}
				}
				son = {node_id: node_list[j].node_id, node_name: s[1]};
				son_list.push(son);
				//nest_node
				nest_node = {
					node_id: node_list[i - 1].node_id,
					node_name: node_list[i - 1].node_name,
					node_type: node_list[i - 1].node_type,
					node_son: son_list
				};
				if (status_list[nest_node.node_name] !== true){
					list.push(nest_node);
					status_list[nest_node.node_name] = true;
				}
				//comevent
			} else if (event_type === "ComEvent") {
				s = temp[i].split("Event")[1].split(";")[0];
				if (s.indexOf("||") === -1) {
					s = Remove_parentheses(s);
					s = s.split(" && ");
					son_list = [];
					for (var j = 0; j < s.length; j++) {
						for (var k = 0; k < node_list.length; k++) {
							if (node_list[k].node_name === s[j].replace(" ", "")) {
								break;
							}
						}
						son = {node_id: node_list[k].node_id, node_name: node_list[k].node_name};
						son_list.push(son);
					}
					nest_node = {
						node_id: node_list[i - 1].node_id,
						node_name: node_list[i - 1].node_name,
						node_type: node_list[i - 1].node_type,
						node_son: son_list
					};
					if (status_list[nest_node.node_name] !== true){
						list.push(nest_node);
						status_list[nest_node.node_name] = true;
					}
				} else {
					son_list = [];
					//node = {node_id: id_num, node_name: s, node_type: 1};
					//node_list.push(node);
					//id_num++;
					s = Remove_parentheses(s);
					s = s.split(" || ");
					son_list = [];
					for (var j = 0; j < s.length; j++) {
						for (var k = 0; k < node_list.length; k++) {
							if (node_list[k].node_name === s[j]) {
								break;
							}
						}
						son = {node_id: node_list[k].node_id, node_name: node_list[k].node_name};
						son_list.push(son);
					}
					nest_node = {
						node_id: node_list[i - 1].node_id,
						node_name: node_list[i - 1].node_name,
						node_type: node_list[i - 1].node_type,
						node_son: son_list
					};
					if (status_list[nest_node.node_name] !== true){
						list.push(nest_node);
						status_list[nest_node.node_name] = true;
					}
				}
				//course event
			} else {
				son_list = [];
				s = temp[i].split("Event")[1].split(";")[0];
				s = Remove_parentheses(s);
				//没有或关系存在
				if (s.indexOf("||") === -1) {
					s = s.split(" && ");
					for (var j = 0; j < s.length; j++) {
						if (status[s[j]] !== true) {
							node = {node_id: id_num, node_name: s[j], node_type: 4};
							node_list.push(node);
							id_num++;
							status[s[j]] = true;
							son = {node_id: node.node_id, node_name: node.node_name};
							son_list.push(son);
						} else {
							for (var k = 0; k < node_list.length; k++) {
								if (node_list[k].node_name === s[j]) {
									break;
								}
							}
							son = {node_id: node_list[k].node_id, node_name: node_list[k].node_name};
							son_list.push(son);
						}
					}
					nest_node = {
						node_id: node_list[i - 1].node_id,
						node_name: node_list[i - 1].node_name,
						node_type: node_list[i - 1].node_type,
						node_son: son_list
					};
					if (status_list[nest_node.node_name] !== true){
						list.push(nest_node);
						status_list[nest_node.node_name] = true;
					}
					//有或关系存在
				} else {
					let q = new Queue();
					s = s + " &";
					s = s.split("");
					var parentheses = 0;
					var coursecom;
					son_list = [];
					for (var l = 0; l < s.length; l++) {
						if (s[l] === "&") {

							if (parentheses === 0) {
								coursecom = "";
								while (q.size() !== 0) {
									coursecom = coursecom + q.pop().ele;
								}
								//此处coursecom是课程事件里的每一个课程逻辑组合
								/****************************************************************************/
								if (coursecom.indexOf("(") !== -1) {
									if (status[coursecom] === true) {
										for (var m = 0; m < node_list.length; m++) {
											if (node_list[m].node_name === coursecom) {
												break;
											}
										}
										node = {
											node_id: node_list[m].node_id,
											node_name: node_list[m].node_name,
											node_type: 1
										};
									} else {
										node = {node_id: id_num, node_name: coursecom, node_type: 1};
										node_list.push(node);
										status[coursecom]=true;
										id_num++;
									}
									son = {node_id: node.node_id, node_name: node.node_name};
									son_list.push(son);

									//二层儿子
									coursecom = Remove_parentheses(coursecom).split(" || ");
									var node2;
									var son2;
									var son2_list = [];
									var coursecombin;
									// 用或分隔后的课程逻辑组合
									for (var k = 0; k < coursecom.length; k++) {
										//多个课程且
										if (coursecom[k].indexOf("&") !== -1) {
											var node3;
											var son3;
											var son3_list = [];
											if (status[coursecom[k]] !== true){
												node2 = {node_id: id_num, node_name: coursecom[k], node_type: 0};
												node_list.push(node2);
												status[coursecom[k]] = true;
												id_num++;
												son2 = {node_id: node2.node_id, node_name: coursecom[k]};
												son2_list.push(son2);
												//三层儿子
												/*********************/
												coursecombin = Remove_parentheses(coursecom[k]).split(" && ");
												for (var p = 0; p < coursecombin.length; p++) {
													coursecombin[p] = coursecombin[p].replace(" ", "");
													//单个课程
													if (status[coursecombin[p]] !== true) {
														node3 = {node_id: id_num, node_name: coursecombin[p], node_type: 4};
														node_list.push(node3);
														id_num++;
														status[coursecombin[p]] = true;
														son3 = {node_id: node3.node_id, node_name: node3.node_name};
														son3_list.push(son3);
													} else {
														for (var m = 0; m < node_list.length; m++) {
															if (coursecombin[p] === node_list[m].node_name) {
																break;
															}
														}
														son3 = {
															node_id: node_list[m].node_id,
															node_name: node_list[m].node_name
														};
														son3_list.push(son3);
													}
												}
												nest_node = {
													node_id: node2.node_id,
													node_name: node2.node_name,
													node_type: node2.node_type,
													node_son: son3_list
												};
												if (status_list[nest_node.node_name] !== true){
													list.push(nest_node);
													status_list[nest_node.node_name] = true;
												}
												/*********************/
											}else if(status[coursecom[k]] === true){
												for (var h = 0; h < node_list.length; h++) {
													if ( coursecom[k] === node_list[h].node_name) {
														break;
													}
												}
												son2 = {node_id: node_list[h].node_id, node_name: coursecom[k]};
												son2_list.push(son2);
												coursecombin = Remove_parentheses(coursecom[k]).split(" && ");
												for (var p = 0; p < coursecombin.length; p++) {
													coursecombin[p] = coursecombin[p].replace(" ", "");
													//单个课程
													if (status[coursecombin[p]] !== true) {
														node3 = {node_id: id_num, node_name: coursecombin[p], node_type: 4};
														node_list.push(node3);
														id_num++;
														status[coursecombin[p]] = true;
														son3 = {node_id: node3.node_id, node_name: node3.node_name};
														son3_list.push(son3);
													} else {
														for (var m = 0; m < node_list.length; m++) {
															if (coursecombin[p] === node_list[m].node_name) {
																break;
															}
														}
														son3 = {
															node_id: node_list[m].node_id,
															node_name: node_list[m].node_name
														};
														son3_list.push(son3);
													}
												}
												nest_node = {
													node_id: node_list[h].node_id,
													node_name: node_list[h].node_name,
													node_type: node_list[h].node_type,
													node_son: son3_list
												};
												if (status_list[nest_node.node_name] !== true){
													list.push(nest_node);
													status_list[nest_node.node_name] = true;
												}
											}
											/**********************************************************/
											//单个课程
										} else {
											coursecom[k] = coursecom[k].replace(" ", "");
											if (status[coursecom[k]] !== true) {
												node2 = {node_id: id_num, node_name: coursecom[k], node_type: 4};
												node_list.push(node2);
												id_num++;
												status[coursecom[k]] = true;

												son2 = {node_id: node2.node_id, node_name: node2.node_name};
											} else {
												for (var p = 0; p < node_list.length; p++) {
													if (coursecom[k] === node_list[p].node_name) {
														break;
													}
													son2 = {
														node_id: node_list[p].node_id,
														node_name: node_list[p].node_name
													};

												}
											}
											son2_list.push(son2);
										}
									}
									nest_node = {
										node_id: node.node_id,
										node_name: node.node_name,
										node_type: node.node_type,
										node_son: son2_list
									};
									if (status_list[nest_node.node_name] !== true){
										list.push(nest_node);
										status_list[nest_node.node_name] = true;
									}
									/********************************************************************************************/
									//单个课程
								} else {
									if (status[coursecom] !== true) {
										node = {node_id: id_num, node_name: coursecom, node_type: 4};
										node_list.push(node);
										id_num++;
										status[coursecom] = true;
										son = {node_id: node.node_id, node_name: node.node_name};
										son_list.push(son);
									} else {
										for (var k = 0; k < node_list.length; k++) {
											if (node_list[k].node_name === coursecom) {
												break;
											}
										}
										son = {node_id: node_list[k].node_id, node_name: node_list[k].node_name};
										son_list.push(son);
									}
								}
								l = l + 1;
							} else {
								q.push(s[l]);
							}
						} else if (s[l] === "(") {
							parentheses++;
							q.push(s[l]);
						} else if (s[l] === ")") {
							parentheses--;
							q.push(s[l]);
						} else if (s[l] === " ") {
							if (parentheses !== 0) {
								q.push(s[l]);
							}
						} else {
							q.push(s[l]);
						}
					}
					nest_node = {
						node_id: node_list[i - 1].node_id,
						node_name: node_list[i - 1].node_name,
						node_type: node_list[i - 1].node_type,
						node_son: son_list
					};
					if (status_list[nest_node.node_name] !== true){
						list.push(nest_node);
						status_list[nest_node.node_name] = true;
					}
				}
			}

		}
		//console.log(node_list);

		var List = [];
		var courses = [];
		var courses_name = [];
		var courses_exsitence = [];
		var noexistence_courses = [];
		var pre_courses = [];
		var course_plus_precourse;
		for (var i = 0; i < list.length; i++) {
			List.push(list[i]);
		}
		for (var i = 0; i < node_list.length; i++) {
			if (node_list[i].node_type === 4) {
				courses.push(node_list[i]);
				courses_name.push(node_list[i].node_name);
			}else if(node_list[i].node_type === 3){
				List.push(node_list[i]);
			}
		}

		courses_exsitence = check_course_existence(courses_name);

		// for (var i=0; i<courses.length; i++){
		//     courses_exsitence[i] = true;
		// }
		//courses_exsitence[10] = false;

		for (var i = 0; i < courses_exsitence.length; i++) {
			if (courses_exsitence[i] === false) {
				noexistence_courses.push(courses_name[i]);
			}
		}
		if (noexistence_courses.length !== 0) {
			console.log(noexistence_courses);
		} else {
			pre_courses = get_Pre_course(courses_name);

			for (var i=0; i<courses.length; i++){
				pre_courses[i] = [];
			}
		}
		// pre_courses[14] = [{"main": "CS307", "pre": "CS201", "type": "1"},
		//      {"main": "CS307", "pre": "CS202", "type": "1"},
		//      {"main": "CS307", "pre": "CS208", "type": "2"}];
		// pre_courses[13] = [{"main": "CS208", "pre": "MA101A", "type": "1"},
		//     {"main": "CS208", "pre": "MA102A", "type": "1"},
		//     {"main": "CS208", "pre": "CS102A", "type": "2"}];

		for (var i = 0; i < pre_courses.length; i++) {
			course_plus_precourse = {
				node_id: courses[i].node_id,
				node_name: courses[i].node_name,
				node_type: courses[i].node_type,
				node_pre: pre_courses[i]
			};
			List.push(course_plus_precourse);
		}
		//console.log(List);
		return JSON.stringify(List);
	}

	function check_course_existence(courses) {
		var posturl = GlobalVariables.baseUrl + '/index.php/MatryonaIDE_api/ajax_check_courses_existence';
		var postData = {
			csrfToken: GlobalVariables.csrfToken,
			courses_arr:JSON.stringify(courses)
		};
		$.post(posturl, postData, function (response) {
			if(!GeneralFunctions.handleAjaxExceptions(response)){
				return;
			}
			return response;
			//console.log(response);
		}.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
	}
	function get_Pre_course(courses) {
		var posturl = GlobalVariables.baseUrl + '/index.php/MatryonaIDE_api/ajax_find_courses_Pre-course';
		var postData = {
			csrfToken: GlobalVariables.csrfToken,
			courses_arr:JSON.stringify(courses)
		};
		$.post(posturl, postData, function (response) {
			if(!GeneralFunctions.handleAjaxExceptions(response)){
				return;
			}
			return response;
			//console.log(response);
		}.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
	}
	/**
	 * @return {string}
	 */
	function load(Matyrona_file_name){
		let r = new XMLHttpRequest(),
			okStatus = document.location.protocol === "file:" ? 0 : 200;
		r.open('GET', Matyrona_file_name, false);
		r.overrideMimeType("text/html;charset=utf-8");
		r.send(null);
		return r.status === okStatus ? r.responseText : null;
	}
	function Remove_parentheses(str) {
		//remove "(" and ")" in the left side and right side
		var s1 = str.split("");
		var s2 = "";
		if (s1[1] === " " && s1[s1.length-2] === " "){
			for (var i=2; i<s1.length-2; i++){
				s2 = s2 + s1[i];
			}
		}else if (s1[1] === " " && s1[s1.length-2] !== " "){
			for (var i=2; i<s1.length-1; i++){
				s2 = s2 + s1[i];
			}
		}else if (s1[1] !== " " && s1[s1.length-2] === " "){
			for (var i=1; i<s1.length-2; i++){
				s2 = s2 + s1[i];
			}
		}else{
			for (var i=1; i<s1.length-1; i++){
				s2 = s2 + s1[i];
			}
		}
		return s2;
	}

	function Queue() {
		let Node = function (ele) {
			this.ele = ele;
			this.next = null;
		};

		let length = 0,
			front, //队首指针
			rear; //队尾指针
		this.push = function (ele) {
			let node = new Node(ele),
				temp;

			if (length === 0) {
				front = node;
			} else {
				temp = rear;
				temp.next = node;
			}
			rear = node;
			length++;
			return true;
		};

		this.pop = function () {
			let temp = front;
			front = front.next;
			length--;
			temp.next = null;
			return temp;
		};

		this.size = function () {
			return length;
		};
		this.getFront = function () {
			return front;
			// 有没有什么思路只获取队列的头结点,而不是获取整个队列
		};
		this.getRear = function () {
			return rear;
		};
		this.toString = function () {
			let string = '',
				temp = front;
			while (temp) {
				string += temp.ele + ' ';
				temp = temp.next;
			}
			return string;
		};
		this.clear = function () {
			front = null;
			rear = null;
			length = 0;
			return true;
		}
	}

})(window.MatryonaTranslateClass);


