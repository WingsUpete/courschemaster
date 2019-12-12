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
	exports.exampleStaticMethod = function (param0) {
		// do sth
		console.log(param0);
	};
	load = function (Matyrona_file_name){
		let r = new XMLHttpRequest(),
			okStatus = document.location.protocol === "file:" ? 0 : 200;
		r.open('GET', name, false);
		r.overrideMimeType("text/html;charset=utf-8");
		r.send(null);
		return r.status === okStatus ? r.responseText : null;
	};
	/**
	 * @return {string}
	 */
	exports.Matryona_to_List = function (){
		let courschema = load("courschema.cmc");

		let english_req = load("english_req.cmh");

		let political_class_req = load("political_class_req.cmh");

		let public_elective_class_req = load("public_elective_class_req.cmh");

		var all = courschema + english_req + political_class_req + public_elective_class_req;

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

})(window.MatryonaTranslateClass);


