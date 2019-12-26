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

	//检查语法准缺性
	exports. registerCmhFiles= function(cmhFile){
		alert("register");
		//上传一个集成的cmh
		var register = [];
		MatryonaTranslateClass.all = "";     //拼接Matryona的内容
		var reader = new FileReader();
		reader.onload = function (e) {
			var cmh_content = e.target.result;
			alert(cmh_content);
            MatryonaTranslateClass.all = cmh_content;
			var message = "";
			var name = cmhFile.name;
			if (cmh_content.indexOf("event") !== -1){
				message = message + "Event, not event; ";
			}
			if (cmh_content.indexOf("&&&") !== -1 || cmh_content.indexOf("|||") !== -1){
				message = message + "Symbol error; "
			}
			if (cmh_content.split("(").length !== cmh_content.split(")").length){
				message = message + "Parentheses error; ";
			}

			if (message === ""){
				register.push({name:name, status:"accepted", message:"accepted"});
				return register;
			}else{
				register.push({name:name, status:"accepted", message:message});
				return register;
			}


		};
		reader.readAsText(cmhFile[0]);
	};

	exports.check = function(cmcFile){
		if(typeof(MatryonaTranslateClass.all) == "undefined"){
			alert("undefined");
			setTimeout(function () {
				exports.check(cmcFile);
			},500);
		}else{
			alert("check");
			console.log(MatryonaTranslateClass.all);
			var reader = new FileReader();
			reader.onload = function (e) {
				var cmc_content = e.target.result;
				MatryonaTranslateClass.all = cmc_content + MatryonaTranslateClass.all;

				var response;
				alert(MatryonaTranslateClass.all);
				//检查依赖关系
				//找到此cmc文件INCLUDE的文件
				MatryonaTranslateClass.all = MatryonaTranslateClass.all.split("（").join("(").split("）").join(")").split("“").join("\"").split("”").join("\"");

				if (MatryonaTranslateClass.all.indexOf("GRADUATION") === -1){
					alert("a");
					response = {status: "rejected", message:"No Graduation !"};
				}else if (MatryonaTranslateClass.all.indexOf("NAME") === -1 || MatryonaTranslateClass.all.indexOf("EN_NAME") || MatryonaTranslateClass.all.indexOf("VERSION") === -1 || MatryonaTranslateClass.all.indexOf("GROUP") || MatryonaTranslateClass.all.indexOf("PROGRAM_LENGTH") === -1) {
					alert("aa");
					response = {status: "rejected", message: "Missing basic information !"};
				}else if(MatryonaTranslateClass.all.split("INCLUDE")-1 > 1) {
					alert("aaa");
					response = {status: "rejected", message: "Include cmh files too much !"};
				}else if(MatryonaTranslateClass.all.split("INCLUDE")-1 === 0){
					alert("aaaa");
					response = {status: "rejected", message: "No INCLUDE !"}
				}else if(MatryonaTranslateClass.all.indexOf("VariableEvent") === -1){
					alert("aaaaa");
					response = {status: "rejected", message: "English requirements file : No VariableEvents !"};
				}else{
					alert("aaaaaa");
					response = {status:"accepted",message:"accepted"};
				}
				console.log(response);
				return JSON.stringify(response);

			};
			reader.readAsText(cmcFile);
		}

	};


	/**
	 * @return {string}
	 */
	exports.Matryona_to_Graph = function (){//get the graph
		var list = [];
		var status_list = [];

		//base information of courschema
		var NAME = MatryonaTranslateClass.all.split("NAME = ")[1].split("\"")[1];
		var EN_NAME = MatryonaTranslateClass.all.split("EN_NAME = ")[1].split("\"")[1];
		var G = MatryonaTranslateClass.all.split("GROUP = (")[1].split(");")[0].replace(/\"/g, " ").split(") || (");
		var GROUP = [];
		for (var i = 0; i < G.length; i++) {
			GROUP.push(G[i].replace(" && ", " "));
		}

		var VERSION = MatryonaTranslateClass.all.split("VERSION = ")[1].split(";")[0];
		var PROGRAM_LENGTH = MatryonaTranslateClass.all.split("PROGRAM_LENGTH = ")[1].split(";")[0];
		var INTRO = MatryonaTranslateClass.all.split("INTRO = ")[1].split("\"")[1].split("\n").join("").replace(/\s+/g, "");
		var EN_INTRO = MatryonaTranslateClass.all.split("EN_INTRO = ")[1].split("\"")[1].split("\n").join("").replace(/\s+/g, " ");
		var OBJECTIVES = MatryonaTranslateClass.all.split("OBJECTIVES = ")[1].split("\"")[1].split("\n").join("").replace(/\s+/g, "");
		var EN_OBJECTIVES = MatryonaTranslateClass.all.split("EN_OBJECTIVES = ")[1].split("\"")[1].split("\n").join("").replace(/\s+/g, " ");
		var DEGREE = MatryonaTranslateClass.all.split("DEGREE = ")[1].split("\"")[1];
		var EN_DEGREE = MatryonaTranslateClass.all.split("EN_DEGREE = ")[1].split("\"")[1];

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

		var temp = MatryonaTranslateClass.all.split("Event ");
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
											coursecom[k] = coursecom[k].split(" ").join("");
											if (status[coursecom[k]] !== true) {
												node2 = {node_id: id_num, node_name: coursecom[k], node_type: 4};
												node_list.push(node2);
												id_num++;
												status[coursecom[k]] = true;

												son2 = {node_id: node2.node_id, node_name: node2.node_name};
												console.log(node2.node_name);
											} else {
												for (var p = 0; p < node_list.length; p++) {
													if (coursecom[k] === node_list[p].node_name) {
														break;
													}
												}
												son2 = {
													node_id: node_list[p].node_id,
													node_name: node_list[p].node_name
												};
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

		var List = [];
		var courses = [];
		var courses_name = [];

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


		for (var i=0; i<courses.length; i++){
			pre_courses[i] = [];
		}
		pre_courses = find_courses_pre_course(courses_name);
        //**********************************************

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
	};

	/**
	 * @return {string}
	 */
	exports.Matryona_to_Pdf = function () {
		//base information of courschema
		var NAME = MatryonaTranslateClass.all.split("NAME = ")[1].split("\"")[1];
		var EN_NAME = MatryonaTranslateClass.all.split("EN_NAME = ")[1].split("\"")[1];
		var G = MatryonaTranslateClass.all.split("GROUP = (")[1].split(");")[0].replace(/\"/g, " ").split(") || (");
		var GROUP = [];
		for (var i = 0; i < G.length; i++) {
			GROUP.push(G[i].replace(" && ", " "));
		}

		var VERSION = MatryonaTranslateClass.all.split("VERSION = ")[1].split(";")[0];
		var PROGRAM_LENGTH = MatryonaTranslateClass.all.split("PROGRAM_LENGTH = ")[1].split(";")[0];
		var INTRO = MatryonaTranslateClass.all.split("INTRO = ")[1].split("\"")[1].split("\n").join("").replace(/\s+/g, "");
		var EN_INTRO = MatryonaTranslateClass.all.split("EN_INTRO = ")[1].split("\"")[1].split("\n").join("").replace(/\s+/g, " ");
		var OBJECTIVES = MatryonaTranslateClass.all.split("OBJECTIVES = ")[1].split("\"")[1].split("\n").join("").replace(/\s+/g, "");
		var EN_OBJECTIVES = MatryonaTranslateClass.all.split("EN_OBJECTIVES = ")[1].split("\"")[1].split("\n").join("").replace(/\s+/g, " ");
		var DEGREE = MatryonaTranslateClass.all.split("DEGREE = ")[1].split("\"")[1];
		var EN_DEGREE = MatryonaTranslateClass.all.split("EN_DEGREE = ")[1].split("\"")[1];


		var temp = MatryonaTranslateClass.all.split("Event ");

		var event;
		var event_name;
		var list = [];
		var event_list = [];
		var subevent_list = [];
		var course_list = [];
		var comment;
		var comment_list = [];
		var event_express = [];
		var courses;
		var parentheses = 0;
		var q;
		var c;
		var cou;
		var all_course = [];
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

		//type : Graduation:0     ComEvent:1     VariableEvent:2      ScoreEvent:3    CourseEvent:4
		for (var i = 1; i < temp.length; i++) {
			if (temp[i].indexOf("GRADUATION") !== -1) {
				subevent_list = [];
				event_express = Remove_parentheses(temp[i].split("Event")[1].split(";")[0]).split(" && ");
				for (var j=0; j < event_express.length; j++){
					subevent_list.push(event_express[j]);
				}

				event = {id: i - 1, name: "Graduation",event_type:0,subevent_list:subevent_list};
				event_list.push(event);
			} else {
				if (temp[i].indexOf("ComEvent") !== -1) {
					subevent_list = [];
					if (temp[i].indexOf("English_requirements") !== -1){
						event_express = Remove_parentheses(temp[i].split("Event")[1].split(";")[0]).split(" || ");
						for (var j=0; j<event_express.length; j++){
							subevent_list.push(event_express[j]);
						}
					}else{
						event_express = Remove_parentheses(temp[i].split("Event")[1].split(";")[0]).split(" && ");
						for (var j=0; j<event_express.length; j++){
							subevent_list.push(event_express[j]);
						}
					}
					event_name = temp[i].split("=")[0].replace(" ","");
					event = {id: i - 1, name:event_name, event_type:1,subevent_list:subevent_list};
					event_list.push(event);
				}else if (temp[i].indexOf("CourseEvent") !== -1){
					course_list = [];
					comment_list = [];
					event_express = Remove_parentheses(temp[i].split("Event")[1].split(";")[0]);

					courses = event_express.split("||").join("&&").split("(").join("").split(")").join("");
					courses = courses.split("&&");
					for (var j=0; j<courses.length; j++){
						cou = courses[j].split(" ").join("");
						course_list.push(cou);
						if(all_course.indexOf(cou) === -1){
							all_course.push(cou);
						}
					}

					comment = event_express + "&";
					q = new Queue();
					comment = comment.split("");
					for(var l=0; l<comment.length; l++){
						if(comment[l] === "&"){
							if(parentheses === 0){
								c = "";
								while(q.size() !== 0){
									c = c + q.pop().ele;
								}
								if(c.indexOf("||") !== -1){
									comment_list.push(c);
								}
								l = l + 1;
							}else{
								q.push(comment[l]);
							}
						}else if(comment[l] === "("){
							parentheses++;
							q.push(comment[l]);
						}else if(comment[l] === ")"){
							parentheses--;
							q.push(comment[l]);
						}else if(comment[l] === " "){
							if(parentheses !== 0){
								q.push(comment[l]);
							}
						}else{
							q.push(comment[l]);
						}
					}
					event_name = temp[i].split("=")[0].replace(" ","");

					event = {id: i - 1, name:event_name, event_type:4,courses_list:course_list, comment_list:comment_list};
					event_list.push(event);
				}else if (temp[i].indexOf("ScoreEvent") !== -1){
					comment_list = [];
					event_express = Remove_parentheses(temp[i].split("Event")[1].split(";")[0]);
					comment_list.push(event_express);
					event_name = temp[i].split("=")[0].replace(" ","");
					event = {id: i - 1, name:event_name, event_type:3,comment_list:comment_list};
					event_list.push(event);
				}else if (temp[i].indexOf("VariableEvent") !== -1){
					subevent_list = [];
					event_express = Remove_parentheses(temp[i].split("Event")[1].split(";")[0]).split(", ");
					for (var j=0; j < event_express.length; j++){
						subevent_list.push(event_express[j]);
					}
					event_name = temp[i].split("=")[0].replace(" ","");

					event = {id: i - 1, name:event_name, event_type:2,subevent_list:subevent_list};
					event_list.push(event);
				}
			}
		}
		for (var i=0; i<event_list.length; i++){
			if(event_list[i].name === "Graduation"){
				break;
			}
		}
		//向后端发送课程信息请求

		var all_courses_info = get_courses_info(all_course);

		//******************************8

		var table;
		var table_name;
		var table_courses = [];
		var table_commit = [];
		var SecondEvent = event_list[i].subevent_list;
		var English_req = [];

		let event_queue = new Queue();
		var e;
		for (var j=0; j<SecondEvent.length; j++){
			if (SecondEvent[j] === 'English_requirements'){

				for(var o=0; o<event_list.length; o++){
					if(event_list[o].name === 'English_requirements'){
						break;
					}
				}
				for(var l=0; l<event_list[o].subevent_list.length; l++){//

					table_name = event_list[o].subevent_list[l]; // English 1 / 2 / 3
					//English 1
					if (table_name.indexOf("II") === -1 && table_name.indexOf("III") === -1){
						table_courses = [];
						table_commit = [];
						for(var m=0; m<event_list.length; m++){
							if(event_list[m].name === table_name){
								break;
							}
						}
						table_commit.push(event_list[m].subevent_list[0]);
						for(var n=0; n<event_list.length; n++){
							if(event_list[n].name === event_list[m].subevent_list[1]){
								break;
							}
						}
						//console.log(event_list[n]);
						for(var p=0; p<event_list[n].courses_list.length; p++){
							table_courses.push(all_courses_info[event_list[n].courses_list[p]]);
						}
						//English 2 / 3
					}else{
						table_courses = [];
						table_commit = [];
						for(var m=0; m<event_list.length; m++){
							if(event_list[m].name === table_name){
								break;
							}
						}
						table_commit.push(event_list[m].subevent_list[0]);
						for(var n=0; n<event_list.length; n++){
							if (event_list[n].name === event_list[m].subevent_list[1]){
								break;
							}
						}
						for(var x=0; x<event_list.length; x++){
							if(event_list[x].name === event_list[n].subevent_list[0]){
								break;
							}
						}
						for (var r=0; r<event_list[x].courses_list.length; r++){
							table_courses.push(all_courses_info[event_list[x].courses_list[r]]);
						}
						for(var p=0; p<event_list.length; p++){
							if(event_list[p].name === event_list[n].subevent_list[1]){
								break;
							}
						}
						table_commit = table_commit.concat(event_list[p].comment_list);
					}
					table = {table_name:table_name, table_courses:table_courses, table_commit:table_commit};
					English_req.push(table);
				}
				var English_req_commit = "";
				for (var y=0; y<English_req.length; y++){
					if (y === 0){
						English_req_commit = English_req[y].table_name;
					}else{
						English_req_commit = English_req_commit + " || " + English_req[y].table_name;
					}
				}
				table_commit = [];
				table_commit.push(English_req_commit);
				list.push({table_name:'English_requirements', subtables:English_req, table_commit:table_commit})
			}else {
				table_courses = [];
				table_commit = [];
				table_name = SecondEvent[j];
				event_queue.push(SecondEvent[j]);
				while(event_queue.size() !== 0){
					e = event_queue.pop().ele;
					for(var k=0; k<event_list.length; k++) {
						if (event_list[k].name === e) {
							break;
						}
					}

					if (event_list[k].event_type === 3){
						table_commit = table_commit.concat(event_list[k].comment_list);
					}else if(event_list[k].event_type === 4){
						table_commit = table_commit.concat(event_list[k].comment_list);
						for (var m=0; m<event_list[k].courses_list.length; m++){
							table_courses.push(all_courses_info[event_list[k].courses_list[m]]);
						}
					}else if(event_list[k].event_type === 1){
						for (var m=0; m<event_list[k].subevent_list.length; m++){
							event_queue.push(event_list[k].subevent_list[m]);
						}
					}
				}
				table = {table_name:table_name, table_courses:table_courses, table_commit:table_commit};
				list.push(table);
			}

		}
		return JSON.stringify(list);
	};

	//ajax : get the pre course
	function find_courses_pre_course(courses) {
		var posturl = GlobalVariables.baseUrl + '/index.php/matryonaide_api/ajax_find_courses_pre_course';
		var postData = {
			csrfToken: GlobalVariables.csrfToken,
			code_list:JSON.stringify(courses)
		};
		$.post(posturl, postData, function (response) {
			if(!GeneralFunctions.handleAjaxExceptions(response)){
				return;
			}
			return response;
			//console.log(response);
		}.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
	}

	//ajax : get the information of courses
	function get_courses_info(courses) {
		var posturl = GlobalVariables.baseUrl + '/index.php/matryonaide_api/ajax_get_courses_info';
		var postData = {
			csrfToken: GlobalVariables.csrfToken,
			code_list:JSON.stringify(courses)
		};
		$.post(posturl, postData, function (response) {
			if(!GeneralFunctions.handleAjaxExceptions(response)){
				return;
			}
			return response;
		}.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
	}

	/**
	 * @return {string}
	 */
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
