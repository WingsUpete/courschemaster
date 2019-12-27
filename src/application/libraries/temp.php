<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class temp
{


	public function compile_to_graph($command_arr)
	{
		/**
		 * test data area: start -------------------------------------------------------------------------------------------
		 */
//		$command_arr = array();
//		$command_arr[0] = ' NAME = "计算机科学与技术2018级 (1+3) 培养方案"';
//		$command_arr[1] = ' VERSION = 201801';
//		$command_arr[2] = ' INTRO = "计算机科学是一门极具发展潜力的专业，高级人才严重短缺。随着计算机技术和现代化企业的迅速发展， 这一现象将越来越严重。当前和未来一段时间，由于市场的集约化、渗透性、跨学科融合、技术创新、激烈竞争， 社会急需高素质的人才。"';
//		$command_arr[3] = ' OBJECTIVES = "本专业培养具有扎实的专业理论知识，掌握前沿计算机系统设计原理，具有相应的研究开发能力， 能熟练运用英语和计算机技术的人才。学生毕业后不仅可以在企业、科研机构、大学从事计算机科学与技术领域的研究、 开发、管理或教学，还可以继续从事计算机科学与技术及相关或交叉学科领域的研究生学习。"';
//		$command_arr[4] = ' PROGRAM_LENGTH = 4';
//		$command_arr[5] = ' DEGREE = "工程学学士"';
//		$command_arr[6] = ' Event GRADUATION = ComEvent(English_requirements && 专业先修课 && 通识必修课 && 通识选修课 && 专业基础课 && 专业核心课 && 专业选修课 && 实践课程)';
//		$command_arr[7] = ' Event 通识必修课 = ComEvent(理工通识基础 && 思想政治品德 && 军训体育 && 中文写作与交流)';
//		$command_arr[8] = ' Event 专业先修课 = ComEvent(其他先修课 && 数学基础)';
//		$command_arr[9] = ' Event 其他先修课 = CourseEvent(MA103A && PHY103B && PHY105B && CS102A && PHY104B)';
//		$command_arr[10] = ' Event 数学基础 = CourseEvent((MA101B && MA102B)||(MA101A && MA102A))';
//		$command_arr[11] = ' Event 理工通识基础 = ComEvent(其它理工通识基础 && 数学基础)';
//		$command_arr[12] = ' Event 其它理工通识基础 = CourseEvent(MA103A && PHY103B && PHY105B && CS102A && PHY104B)';
//		$command_arr[13] = ' Event 思想政治品德 = 思想政治品德课程';
//		$command_arr[14] = ' Event 军训体育 = 军训体育课程';
//		$command_arr[15] = ' Event 中文写作与交流 = CourseEvent(HUM012)';
//		$command_arr[16] = ' Event 通识选修课 = ComEvent(人文课程, 社科课程, 艺术课程)';
//		$command_arr[17] = ' Event 人文课程 = ScoreEvent("HUM", 4)';
//		$command_arr[18] = ' Event 社科课程 = ScoreEvent("SS" || "GE" || "GEJ" || "HEC", 4)';
//		$command_arr[19] = ' Event 艺术课程 = ScoreEvent("GEM" || "DHSSS", 2)';
//		$command_arr[20] = ' Event 专业基础课 = CourseEvent(CS203 && CS207 && CS201 && CS202 && CS208 && CS307 && MA212)';
//		$command_arr[21] = ' Event 专业核心课 = CourseEvent(CS301 && CS309 && CS321 && CS317 && CS302 && CS304 && CS326 && CS318 && CS413 && CS415 && CS470 && CS490)';
//		$command_arr[22] = ' Event 专业选修课 = ScoreEvent("CS_elective", 19)';
//		$command_arr[23] = ' Event 实践课程 = CourseEvent(CS470 && CS490)';
		/**
		 * test data area: end ---------------------------------------------------------------------------------------------
		 */

		$NAME = '';
		$EN_NAME = '';
		$GROUP = array();
		$VERSION = '';
		$PROGRAM_LENGTH = '';
		$INTRO = '';
		$EN_INTRO = '';
		$OBJECTIVES = '';
		$EN_OBJECTIVES = '';
		$DEGREE = '';
		$EN_DEGREE = '';

		$node_id_counter = 0;
		$node_list = array();
		$temp_list = array();

		$list = array();
		$status_list = array();
		$course_status = array();

		foreach ($command_arr as $command) {
			$command = trim($command);

			// NAME
			if (strcmp(substr($command, 0, 4), 'NAME') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$NAME = $command;
				continue;
			}

			// EN_NAME
			if (strcmp(substr($command, 0, 7), 'EN_NAME') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$EN_NAME = $command;
				continue;
			}

			// GROUP
			if (strcmp(substr($command, 0, 5), 'GROUP') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$command = trim($command, '()');
				$command = explode('&&', $command);
				$GROUP[0] = trim($command[0]);
				$GROUP[1] = trim($command[0]);
				continue;
			}

			// VERSION
			if (strcmp(substr($command, 0, 7), 'VERSION') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$VERSION = $command;
				continue;
			}

			// PROGRAM_LENGTH
			if (strcmp(substr($command, 0, 14), 'PROGRAM_LENGTH') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$PROGRAM_LENGTH = $command;
				continue;
			}


			// INTRO
			if (strcmp(substr($command, 0, 5), 'INTRO') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$INTRO = $command;
				continue;
			}

			// EN_INTRO
			if (strcmp(substr($command, 0, 8), 'EN_INTRO') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$EN_INTRO = $command;
				continue;
			}

			// OBJECTIVES
			if (strcmp(substr($command, 0, 10), 'OBJECTIVES') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$OBJECTIVES = $command;
				continue;
			}

			// EN_OBJECTIVES
			if (strcmp(substr($command, 0, 13), 'EN_OBJECTIVES') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$EN_OBJECTIVES = $command;
				continue;
			}

			// DEGREE
			if (strcmp(substr($command, 0, 6), 'DEGREE') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$DEGREE = $command;
				continue;
			}

			// EN_DEGREE
			if (strcmp(substr($command, 0, 9), 'EN_DEGREE') == 0) {
				$eq_pos = strpos($command, '=');
				$command = substr($command, $eq_pos + 1);
				$command = trim($command);
				$command = trim($command, '"');
				$EN_DEGREE = $command;
				continue;
			}

			// Event
			if (strcmp(substr($command, 0, 5), 'Event') == 0) {
				$node_id = $node_id_counter;
				$node_id_counter += 1;
				$command = trim(substr($command, 6));
				$eq_pos = strpos($command, '=');

				$node_name = substr($command, 0, $eq_pos);
				$node_name = trim($node_name);
				$node_value = substr($command, $eq_pos + 1);
				$node_value = trim($node_value);

				if (strcmp($node_name, 'GRADUATION') == 0) {
					$node_type = 2;
				} else {
					$node_type = 0;
				}

				$node = array(
					'node_id' => $node_id,
					'node_name' => $node_name,
					'node_type' => $node_type,
				);

				$node_list[$node_id] = $node;
				$temp_list[$node_id] = $node_value;

				continue;
			}
		}

		$description = array(
			'name' => $NAME,
			'en_name' => $EN_NAME,
			'group' => $GROUP,
			'version' => $VERSION,
			'program_length' => $PROGRAM_LENGTH,
			'intro' => $INTRO,
			'en_intro' => $EN_INTRO,
			'objectives' => $OBJECTIVES,
			'en_objectives' => $EN_OBJECTIVES,
			'degree' => $DEGREE,
			'en_degree' => $EN_DEGREE,
		);

		$list[] = $description;

		for ($i = 0; $i < sizeof($temp_list); $i++) {
			$value = $temp_list[$i];
			$left_pos = strpos($value, '(');
			$event_type = substr($value, 0, $left_pos);
			$event_type = trim($event_type);
			$value = substr($value, $left_pos);
			$value = trim($value);

			// ComEvent
			if (strcmp($event_type, 'ComEvent') == 0) {

				// &&
				if (strpos($value, '&&') != FALSE) {
					$value = trim($value, '()');
					$value = explode('&&', $value);

					$son_list = array();

					for ($j = 0; $j < sizeof($value); $j++) {
						$item = $value[$j];
						$item = trim($item);
						$k = 0;
						for (; $k < sizeof($temp_list); $k++) {
							if (strcmp($node_list[$k]['node_name'], $item) == 0) {
								break;
							}
						}
						if ($k < sizeof($temp_list)) {
							$son_list[] = array(
								'node_id' => $node_list[$k]['node_id'],
								'node_name' => $item,
							);
						}
					}

					$nest_node = array(
						'node_id' => $node_list[$i]['node_id'],
						'node_name' => $node_list[$i]['node_name'],
						'node_type' => $node_list[$i]['node_type'],
						'node_son' => $son_list,
					);

					if (!array_key_exists($nest_node['node_name'], $status_list)) {
						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}

					continue;
				}

				// ||
				if (strpos($value, '||') != FALSE) {
					$value = trim($value, '()');
					$value = explode('||', $value);

					$son_list = array();

					for ($j = 0; $j < sizeof($value); $j++) {
						$item = $value[$j];
						$item = trim($item);
						$k = 0;
						for (; $k < sizeof($temp_list); $k++) {
							if (strcmp($node_list[$k]['node_name'], $item) == 0) {
								break;
							}
						}
						$son_list[] = array(
							'node_id' => $node_list[$k]['node_id'],
							'node_name' => $item,
						);
					}

					$nest_node = array(
						'node_id' => $node_list[$i]['node_id'],
						'node_name' => $node_list[$i]['node_name'],
						'node_type' => $node_list[$i]['node_type'],
						'node_son' => $son_list,
					);

					if (!array_key_exists($nest_node['node_name'], $status_list)) {
						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}

					continue;
				}

			}

			// CourseEvent
			if (strcmp($event_type, 'CourseEvent') == 0) {
//			if (false){
				// without ||
				if (strpos($value, '||') == FALSE) {

					$value = trim($value, '()');
					$value = explode('&&', $value);

					$son_list = array();

					for ($j = 0; $j < sizeof($value); $j++) {
						$item = $value[$j];
						$item = trim($item);

						if (array_key_exists($item, $course_status)) {
							$k = 0;
							for (; $k < sizeof($node_list); $k++) {
								if (strcmp($node_list[$k]['node_name'], $item) == 0) {
									break;
								}
							}
							$son_list[] = array(
								'node_id' => $node_list[$k]['node_id'],
								'node_name' => $item,
							);
						} else {
							$node_id = $node_id_counter;
							$node_id_counter++;
							$node_name = $item;
							$node_type = 4;

							$node = array(
								'node_id' => $node_id,
								'node_name' => $node_name,
								'node_type' => $node_type,
							);

							$node_list[$node_id] = $node;
							$course_status[$item] = 1;

							$nest_node = array(
								'node_id' => $node_id,
								'node_name' => $node_name,
								'node_type' => $node_type
							);

							if (!array_key_exists($node_name, $status_list)) {
								$list[] = $nest_node;
								$status_list[$nest_node['node_name']] = 1;
							}

							$son_list[] = array(
								'node_id' => $node_id,
								'node_name' => $item,
							);
						}
					}

					$nest_node = array(
						'node_id' => $node_list[$i]['node_id'],
						'node_name' => $node_list[$i]['node_name'],
						'node_type' => $node_list[$i]['node_type'],
						'node_son' => $son_list,
					);

					if (!array_key_exists($nest_node['node_name'], $status_list)) {
						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}
					continue;

				}

				// with ||
//				if(strpos($value, '||') != FALSE){
				if (FALSE) {

					if (array_key_exists($node_list[$i]['node_name'], $status_list)) {
						continue;
					}

					$sp_temp = str_split($value);

					$para_temp = array();
					$pos_temp = array();
					$pos_temp_counter = 0;

					for ($j = 0; $j < sizeof($sp_temp); $j++) {
						if ($sp_temp == '(') {
							$pos_temp[$pos_temp_counter] = $j;
							$pos_temp_counter++;
						}
						if ($sp_temp == ')') {
							$pos_temp_counter--;
							$para_temp[$pos_temp[$pos_temp_counter]] = $j;
						}
					}

					$son_list = array();
					$flag = 1;

					$little_temp = array();

					for ($j = 1; $j < sizeof($sp_temp); $j++) {
						if ($sp_temp[$j] == '(') {
							echo '<br>';
//							print_r($j + 1);
//							echo '<br>';
//							print_r($para_temp[$j] - $j - 1);
//							echo '<br>';
							$little_name = substr($value,
								$j + 1,
								$para_temp[$j] - $j - 1);
							$little_name = trim($little_name);

							if (array_key_exists($little_name, $course_status)) {
								$k = 0;
								for (; $k < sizeof($node_list); $k++) {
									if (strcmp($node_list[$k]['node_name'], $little_name) == 0) {
										break;
									}
								}
								$son_list[] = array(
									'node_id' => $node_list[$k]['node_id'],
									'node_name' => $little_name,
								);
							} else {
								$little_id = $node_id_counter;
								$node_id_counter++;
								$little_type = 1;

								$node = array(
									'node_id' => $little_id,
									'node_name' => $little_name,
									'node_type' => $little_type,
								);

								$node_list[$little_id] = $node;
								$course_status[$little_name] = 1;

								$nest_node = array(
									'node_id' => $little_id,
									'node_name' => $little_name,
									'node_type' => $little_type
								);

								if (!array_key_exists($little_name, $status_list)) {
									$list[] = $nest_node;
									$status_list[$nest_node['node_name']] = 1;
								}

								$son_list[] = array(
									'node_id' => $little_id,
									'node_name' => $little_name,
								);

								// do something
								$little_temp[] = array(
									'id' => $little_id,
									'left' => $j,
								);
							}
							$j = $para_temp[$j];
							$flag = $j + 1;
						}

						if ($sp_temp[$j] == '&'
							or $sp_temp[$j] == ')') {
							if ($j - $flag < 5) {
								$j = $j + 1;
								$flag = $j + 2;
							} else {
								$little_name = substr($value, $flag, $j - $flag);
								$little_name = trim($little_name);

								if (array_key_exists($little_name, $course_status)) {
									$k = 0;
									for (; $k < sizeof($node_list); $k++) {
										if (strcmp($node_list[$k]['node_name'], $little_name) == 0) {
											break;
										}
									}
									$son_list[] = array(
										'node_id' => $node_list[$k]['node_id'],
										'node_name' => $little_name,
									);
								} else {
									$little_id = $node_id_counter;
									$node_id_counter++;
									$little_type = 3;

									$node = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
										'node_type' => $little_type,
									);

									$node_list[$little_id] = $node;
									$course_status[$little_name] = 1;

									$nest_node = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
										'node_type' => $little_type
									);

									if (!array_key_exists($little_name, $status_list)) {
										$list[] = $nest_node;
										$status_list[$nest_node['node_name']] = 1;
									}

									$son_list[] = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
									);
								}
							}
						}


					}

					$nest_node = array(
						'node_id' => $node_list[$i]['node_id'],
						'node_name' => $node_list[$i]['node_name'],
						'node_type' => $node_list[$i]['node_type'],
						'node_son' => $son_list,
					);

					$list[] = $nest_node;
					$status_list[$nest_node['node_name']] = 1;


					$big_temp = array();
					foreach ($little_temp as $little_little_temp) {

						if (array_key_exists($node_list[$little_little_temp['id']]['node_name'], $status_list)) {
							continue;
						}

						$son_list = array();

						for ($j = $little_little_temp['left'] + 1;
							 $j <= $para_temp[$little_little_temp['left']];
							 $j++) {

							if ($sp_temp[$j] == '(') {
								$little_name = substr($value,
									$j + 1,
									$para_temp[$j] - $j - 1);
								$little_name = trim($little_name);

								if (array_key_exists($little_name, $course_status)) {
									$k = 0;
									for (; $k < sizeof($node_list); $k++) {
										if (strcmp($node_list[$k]['node_name'], $little_name) == 0) {
											break;
										}
									}
									$son_list[] = array(
										'node_id' => $node_list[$k]['node_id'],
										'node_name' => $little_name,
									);
								} else {
									$little_id = $node_id_counter;
									$node_id_counter++;
									$little_type = 0;

									$node = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
										'node_type' => $little_type,
									);

									$node_list[$little_id] = $node;
									$course_status[$little_name] = 1;

									$nest_node = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
										'node_type' => $little_type
									);

									if (!array_key_exists($little_name, $status_list)) {
										$list[] = $nest_node;
										$status_list[$nest_node['node_name']] = 1;
									}

									$son_list[] = array(
										'node_id' => $little_id,
										'node_name' => $little_name,
									);

									// do something
									$big_temp[] = array(
										'id' => $little_id,
										'left' => $j,
									);
								}
								$j = $para_temp[$j];
								$flag = $j + 1;
							}

							if ($sp_temp[$j] == '&'
								or $sp_temp[$j] == ')') {
								if ($j - $flag < 5) {
									$j = $j + 1;
									$flag = $j + 2;
								} else {
									$little_name = substr($value, $flag, $j - $flag);
									$little_name = trim($little_name);

									if (array_key_exists($little_name, $course_status)) {
										$k = 0;
										for (; $k < sizeof($node_list); $k++) {
											if (strcmp($node_list[$k]['node_name'], $little_name) == 0) {
												break;
											}
										}
										$son_list[] = array(
											'node_id' => $node_list[$k]['node_id'],
											'node_name' => $little_name,
										);
									} else {
										$little_id = $node_id_counter;
										$node_id_counter++;
										$little_type = 3;

										$node = array(
											'node_id' => $little_id,
											'node_name' => $little_name,
											'node_type' => $little_type,
										);

										$node_list[$little_id] = $node;
										$course_status[$little_name] = 1;

										$nest_node = array(
											'node_id' => $little_id,
											'node_name' => $little_name,
											'node_type' => $little_type
										);

										if (!array_key_exists($little_name, $status_list)) {
											$list[] = $nest_node;
											$status_list[$nest_node['node_name']] = 1;
										}

										$son_list[] = array(
											'node_id' => $little_id,
											'node_name' => $little_name,
										);
									}
								}
							}

						}

						$nest_node = array(
							'node_id' => $node_list[$little_little_temp['id']]['node_id'],
							'node_name' => $node_list[$little_little_temp['id']]['node_name'],
							'node_type' => $node_list[$little_little_temp['id']]['node_type'],
							'node_son' => $son_list,
						);

						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}

					foreach ($big_temp as $little_little_temp) {

						if (array_key_exists($node_list[$little_little_temp['id']]['node_name'], $status_list)) {
							continue;
						}

						$node_name = $node_list[$little_little_temp['id']]['node_name'];
						$son_list = array();

						$node_name = trim($node_name, '()');
						$node_name = trim($node_name);

						$sb_value = explode('&&', $node_name);

						for ($j = 0; $j < sizeof($sb_value); $j++) {
							$item = $sb_value[$j];
							$item = trim($item);

							if (array_key_exists($item, $course_status)) {
								$k = 0;
								for (; $k < sizeof($node_list); $k++) {
									if (strcmp($node_list[$k]['node_name'], $item) == 0) {
										break;
									}
								}
								$son_list[] = array(
									'node_id' => $node_list[$k]['node_id'],
									'node_name' => $item,
								);
							} else {
								$node_id = $node_id_counter;
								$node_id_counter++;
								$node_name = $item;
								$node_type = 3;

								$node = array(
									'node_id' => $node_id,
									'node_name' => $node_name,
									'node_type' => $node_type,
								);

								$node_list[$node_id] = $node;
								$course_status[$item] = 1;

								$nest_node = array(
									'node_id' => $little_id,
									'node_name' => $little_name,
									'node_type' => $little_type
								);

								if (!array_key_exists($little_name, $status_list)) {
									$list[] = $nest_node;
									$status_list[$nest_node['node_name']] = 1;
								}

								$son_list[] = array(
									'node_id' => $node_id,
									'node_name' => $item,
								);
							}
						}

						$nest_node = array(
							'node_id' => $node_list[$little_little_temp['id']]['node_id'],
							'node_name' => $node_list[$little_little_temp['id']]['node_name'],
							'node_type' => $node_list[$little_little_temp['id']]['node_type'],
							'node_son' => $son_list,
						);

						$list[] = $nest_node;
						$status_list[$nest_node['node_name']] = 1;
					}

					continue;
				}

			}

			// ScoreEvent
			if (strcmp($event_type, 'ScoreEvent') == 0) {
				$node_id = $node_id_counter;
				$node_id_counter++;

				$node_name = $value;
				$node_type = 3;

				$node = array(
					'node_id' => $node_id,
					'node_name' => $node_name,
					'node_type' => $node_type,
				);

				$son_list = array();
				$son_list[0] = array(
					'node_id' => $node_id,
					'node_name' => $node_name
				);

				$node_list[$node_id] = $node;

				$nest_node = array(
					'node_id' => $node_list[$i]['node_id'],
					'node_name' => $node_list[$i]['node_name'],
					'node_type' => $node_list[$i]['node_type'],
					'node_son' => $son_list,
				);

				if (!array_key_exists($nest_node['node_name'], $status_list)) {
					$list[] = $nest_node;
					$status_list[$nest_node['node_name']] = 1;
				}

				continue;
			}

			// VariableEvent
			if (strcmp($event_type, 'VariableEvent') == 0) {
				$value = trim($value, '()');
				$value = explode(',', $value);
				$value[0] = trim($value[0], '"');
				$value[1] = trim($value[1]);

				$son_list = array();

				// son 1
				$node_id = $node_id_counter;
				$node_id_counter++;
				$node_name = $value[0];
				$node_type = 3;

				$node = array(
					'node_id' => $node_id,
					'node_name' => $node_name,
					'node_type' => $node_type,
				);

				$son_list[0] = array(
					'node_id' => $node_id,
					'node_name' => $node_name
				);

				$node_list[$node_id] = $node;

				// son 2
				$j = 0;
				for (; $j < sizeof($temp_list); $j++) {
					if (strcmp($node_list[$j]['node_name'], $value[1]) == 0) {
						break;
					}
				}
				$son_list[1] = array(
					'node_id' => $node_list[$j]['node_id'],
					'node_name' => $value[1],
				);

				$nest_node = array(
					'node_id' => $node_list[$i]['node_id'],
					'node_name' => $node_list[$i]['node_name'],
					'node_type' => $node_list[$i]['node_type'],
					'node_son' => $son_list,
				);

				if (!array_key_exists($nest_node['node_name'], $status_list)) {
					$list[] = $nest_node;
					$status_list[$nest_node['node_name']] = 1;
				}

				continue;
			}

		}

		return $list;

	}

}


