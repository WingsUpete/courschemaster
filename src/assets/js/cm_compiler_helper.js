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

	//上传cmh文件
	exports.registerCmhFiles = function(cmhFiles){
		//上传的所有.cmh文件的File对象数组
		MatryonaTranslateClass.cmh = [];
		MatryonaTranslateClass.cmh = cmhFiles;

		var check_cmhfiles_result = [];

		for (var i=0; i<MatryonaTranslateClass.cmh.length; i++){
			check_cmhfiles_result.push(check_cmhfiles(MatryonaTranslateClass.cmh[i]));
		}
		return check_cmhfiles_result;
	};

	function check_cmhfiles(specific_cmh){
		var cmh_content = "";
		var reader = new FileReader();
		reader.onload = function (e) {
			cmh_content = e.target.result;
		};
		reader.readAsText(specific_cmh);
		var name = specific_cmh.name;
		var message = "";
		if (cmh_content.indexOf("event") !== -1){
			message = message + "Event, not event; ";
		}
		if (cmh_content.split("(").length !== cmh_content.split(")").length){
			message = message +  "Parentheses error; ";
		}
		if (message === ""){
			return {name:name, status:"accepted", message:"accepted"};
		}else{
			return {name:name, status:"rejected", message:message};
		}
	}

	//检查依赖性和语法准缺性
	exports.check = function(cmcFile){
		//输入：cmc文件，cmhFiles[]
		//检查上传的cmc和cmh文件的依赖关系和语法正确性

		//读cmc文件
		MatryonaTranslateClass.all = "";
		var cmc_content = "";
		var reader = new FileReader();
		reader.onload = function (e) {
			cmc_content = e.target.result;
		};
		reader.readAsText(cmcFile);
		MatryonaTranslateClass.all = cmc_content;

		var cmh_notfound = []; //cmc需要的，但是没有在上传的文件中找到的cmh
		var cmh_content; //cmh内容

		//检查依赖关系
		//找到此cmc文件INCLUDE的文件，首先在注册的cmhFiles中匹配文件名
		var cmh_need_temp = cmc_content.split("INCLUDE = ");
		var cmh_need = [];
		for (var i=1; i<cmh_need_temp.length; i++){
			cmh_need_temp[i] = cmh_need_temp[i].split(";")[0].split("\"").join("");
			cmh_need.push(cmh_need_temp[i])
		}
		for (var i=0; i<cmh_need.length; i++){
			for (var j=0; j<MatryonaTranslateClass.cmh.length; j++){
				if (cmh_need[i] === MatryonaTranslateClass.cmh[j].name){
					//读文件并把文件内容与cmc_content拼接起来
					reader = new FileReader();
					reader.onload = function (e) {
						cmh_content = e.target.result;
					};
					reader.readAsText(MatryonaTranslateClass.cmh[j]);
					MatryonaTranslateClass.all = MatryonaTranslateClass.all + cmh_content;
					break;
				}
			}
			if (j === MatryonaTranslateClass.cmh.length){
				cmh_notfound.push(cmh_need[i]);
			}
		}
		if (cmh_notfound.length !== 0){ // 如果部分cmh未找到，则去数据库中找这些文件
			var cmh_database_check = find_cmh(cmh_notfound);
			if (cmh_database_check[0].status === true){
				for (var j=1; j<cmh_database_check.length; j++){
					MatryonaTranslateClass.all = MatryonaTranslateClass.all + cmh_database_check[j].cmh_content;
				}
			}else{
				return {status:"rejected",message:"Cmh files are insufficient !"}
			}

		}else{//所用到的cmh在上传的文件中全部找到，返回{status:accepted, message: accepted}, 此时的all即为全部内容，可以直接解析
			// 检查正确性
			MatryonaTranslateClass.all = MatryonaTranslateClass.all.split("（").join("(");
			MatryonaTranslateClass.all = MatryonaTranslateClass.all.split("）").join(")");
			MatryonaTranslateClass.all = MatryonaTranslateClass.all.split("“").join("\"");
			MatryonaTranslateClass.all = MatryonaTranslateClass.all.split("”").join("\"");

			if (MatryonaTranslateClass.all.indexOf("GRADUATION") === -1){
				return {status: "rejected", message:"No Graduation !"};
			}else if (MatryonaTranslateClass.all.indexOf("NAME") === -1 || MatryonaTranslateClass.all.indexOf("EN_NAME") || MatryonaTranslateClass.all.indexOf("VERSION") === -1 || MatryonaTranslateClass.all.indexOf("GROUP") || MatryonaTranslateClass.all.indexOf("PROGRAM_LENGTH") === -1){
				return {status: "rejected", message:"Missing basic information !"};
			}else{
				return {status:"accepted",message:"accepted"}
			}
		}
	};

	/**
	 * @return {string}
	 */
	exports.Matryona_to_List = function (){
		var temp = MatryonaTranslateClass.all.split("Event ");

		var list = [];
		var nest_event;
		var char;
		var char_list = [];

		var event_list = [];
		var event;
		var event_name;

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
				var expression = temp[j].split("Event")[1].split(";")[0].split(", ");
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
				var expression = temp[j].split("Event")[1].split(";")[0].split(" ");
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
				var expression = temp[j].split("Event")[1].split(";")[0].split(" ");
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
		//console.log(JSON.stringify(list));
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

		courses_exsitence = check_courses_existence(courses_name);

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
			return JSON.stringify(noexistence_courses);
			//console.log(noexistence_courses);
		} else {
			for (var i=0; i<courses.length; i++){
				pre_courses[i] = [];
			}
			pre_courses = find_courses_pre_course(courses_name);
		}
		// pre_courses[14] = [{"main": "CS307", "pre": "CS201", "type": "1"},
		//     {"main": "CS307", "pre": "CS202", "type": "1"},
		//     {"main": "CS307", "pre": "CS208", "type": "2"}];
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
					// for(var o=0; o<event_queue.size(); o++){
					//     console.log(event_queue.getFront().ele);
					// }

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


	//ajax : check cmh existence and their content in the database
	function find_cmh(cmh_notfound) {
		var posturl = GlobalVariables.baseUrl + '/index.php/MatryonaIDE_api/ajax_find_cmh';
		var postData = {
			csrfToken: GlobalVariables.csrfToken,
			courses_arr:JSON.stringify(cmh_notfound)
		};
		$.post(posturl, postData, function (response) {
			if(!GeneralFunctions.handleAjaxExceptions(response)){
				return;
			}
			return response;
			//console.log(response);
		}.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
	}

	//ajax : check course existence and their content
	function check_courses_existence(courses) {
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

	//ajax : get the pre course
	function find_courses_pre_course(courses) {
		var posturl = GlobalVariables.baseUrl + '/index.php/MatryonaIDE_api/ajax_find_courses_pre_course';
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

	//ajax : get the information of courses
	function get_courses_info(courses) {
		var posturl = GlobalVariables.baseUrl + '/index.php/MatryonaIDE_api/ajax_get_courses_info';
		var postData = {
			csrfToken: GlobalVariables.csrfToken,
			courses_arr:JSON.stringify(courses)
		};
		$.post(posturl, postData, function (response) {
			if(!GeneralFunctions.handleAjaxExceptions(response)){
				return;
			}
			return response;
		}.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
	}

	//ajax : delete cmh files;
	function delete_cmh(cmhfiles) {
		var posturl = GlobalVariables.baseUrl + '/index.php/matryonaide_api/ajax_delete_cmh';
		var postData = {
			csrfToken: GlobalVariables.csrfToken,
			courses_arr:JSON.stringify(cmhfiles)
		};
		$.post(posturl, postData, function (response) {
			if(!GeneralFunctions.handleAjaxExceptions(response)){
				return;
			}
			return response;
		}.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
	}

	//ajax : upload cmh files;
	function uploadCourschemas(cmhfiles) {
		var postUrl = GlobalVariables.baseUrl + '/index.php/courschemas_api/ajax_upload_courshcemas';
		var postData = new FormData();
		postData.append('csrfToken', GlobalVariables.csrfToken);
		postData.append('target_file[]', cmhfiles);

		return $.ajax({
			url: postUrl,
			type: 'POST',
			data: postData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response) {
				//	Test whether response is an exception or a warning
				if (!GeneralFunctions.handleAjaxExceptions(response)) {
					return;
				}
				console.log(response);
				if (response.status === 'success') {
					GeneralFunctions.displayMessageAlert(SCLang.upload_courses_success, 'success', 6000);
				} else if (response.status === 'fail') {
					GeneralFunctions.displayMessageAlert(SCLang.upload_courses_failure, 'danger', 6000);
				} else {
					GeneralFunctions.displayMessageAlert('ABNORMAL RESPONSE IN QA-POST-QUESTIONS', 'warning', 60000);
				}
			},
			error: function(e) {
				console.error(e);
			}
		});
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
