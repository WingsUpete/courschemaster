# 统一培养方案语言 - Matryona语法及示例

-----

### Unified Courschema Language - Matryona

#### Reserved word, Keyword

```
NAME
```

Used to define the display name of this courschema. It is usually a Chinese name 



```
EN_NAME
```

Used to define the display name of this courschema. It is usually a English name



```
VERSION
```

The version of this courschema. If two courschema have the same name, the one with biggest version is valid while the other one is not valid.



```
DESCRIPTION
```

Usually can be the description in Chinese of this courschema. It will be displayed in the courschema.



```
EN_DESCRIPTION
```

Usually can be the description in English of this courschema. It will be displayed in the courschema.



```
STUDENT_VARIABLE
```

Retrieve some student variables from database and assign it a another name. For example, ` STUDENT_VARIABLE database_keyword alias_name`



```
Event
```

Define an event.



#### Events

A event only has one value: true or false. `true` means that this event has been done. `false` means that this event has not been done yet. If event `GRADUATION`, which every courschema should has, is true,  then this student already finish this courschema, he/she can graduate now.

`GRADUATION` event consists of several smaller combinational events or atom events, and a smaller event can consist several smaller events or atom events. This hierarchy ends up with atom events. An atom event cannot be divided.

##### Overview

- Operators

- Atom Event

  - ScoreEvent
  - VariableEvent
  - CourseEvent

- Combinational Event

  

##### Operators

`=` : Assign a value to a event

​	Pass the value of the right equation to left notation

​	For example, `Event e1 = CS308;`  means assigning an event atom enumerated `CS308` to e1, now e1 is CS308. If a student pass CS308, then  e1 is true. `Event e2 = e1;` means that the e2 is true only when e1 is true, e2 is false only when e1 is false. 



`&&` : Logical and

​	`Event e1 = e2 && e3;` means e1 is true only when e2 and e3 are both true.



`||` : Logical or

​	`Event e1 = e2 || e3;` means e1 is true when one of e2 and e3 is true or both of them are true.



`^` : Logical xor

​	`Event e1 = e2 ^ e3;` means e1 is true only when e2 is true while e3 is false, or e2 is false while e3 is true. Only one of e2 or e3 is true, and the other one is false, can e1 be true.



`!` : Logical not

​	`Event e1 = !e2;` means that if e2 is true, then e1 is false; if e2 is false, then e1 is true.



##### ScoreEvent

ScoreEvent is a event requiring the total credit of a specific kind of passed courses is larger than a specified value.

For example, `Event e = ScoreEvent("HUM", 4);` means that event e is true only when a student pass more than (included) 2 courses with "HUM" label. (If all the courses with "HUM" label has 2 credits).

The label can also be combinational, for example, `Event e = ScoreEvent("GENERAL" && !"CLE", 52);` means event e is true only when a student has earned more than (included) 52 credits by passing courses with "GENERAL" label but not with "CLE" label.



##### VariableEvent

This event is specially developed for the graded teaching policy.

`Event e = VariableEvent("english_level >= 3", English_III_Event);`

In this example, `english_level` is a STUDENT_VARIABLE retrieved from database. This event can be true only when `english_level` is equal or larger than 3 and also finish `English_III_Event`; 



##### CourseEvent

A course event only consists of courses and logical variables connecting them together.

`Event e = CourseEvent(CS101 && CS208);` means event e is true only when the student pass both CS101 and CS208.



##### ComEvent

A event can consist of several events with some operators connecting these events together. For example, 

`Event English_requirements = ComEvent(SUSTech_English_I || SUSTech_English_II || SUSTech_English_III);`



#### Example

**.cmc** file

Computer Science Requirement

```java
INCLUDE = SUSTech_english_requirement_201902.cmh;

NAME = "计算机科学2017级";
EN_NAME = "Computer Science Courschema 2017";

GROUP = ("2017"&&"CSE") || ("2018"&&"CSE") || ("2019"&&"CSE");
VERSION = 201702;

DESCRIPTION = "进入专业前需修完7门专业基础课且合格，建议修读计算机系统设计及应用A; 转专业需修完7门专业基础课且各课程绩点均3.3以上";
EN_DESCRIPTION = "Before enrolled in computer science, all seven basic courses should at least be passed. Moving to computer science requires the GPA of these seven basic courses are ALL above 3.3";


Event GRADUATION = ComEvent(通修通识课必修 && 专业基础课 && 专业核心课 && 专业先修课 && 实践课程 && 毕业最低学分要求 && English_requirements && 思政要求);

Event 通修通识课必修 = ComEvent(通修通识课必修_学分要求 && 通修通识课必修_课程要求);

Event 通修通识课必修_学分要求 = ScoreEvent("通识必修课" && !"CLE", 52.5);

Event 通修通识课必修_课程要求 = 
	((MA101B && MA102B)||(MA101A && MA102A)) && 
	MA103A && (PHY103B||PHY105B) && CH101-B && 
	BIO102B && CS102A;

Event 专业基础课 = CourseEvent(CS102A && CS203 && CS2017 && MA212 && CS201 && CS202 && CS307 && CS208);

Event 专业核心课 = CourseEvent(CS301 && CS303 && CS305 && CS309 && CS302 && CS304 && CS317 && CS318 && CS415);


Event 实践课程 = CourseEvent(
	(
	(计算机科学创新实验I && 计算机科学创新实验II && 计算机科学创新实验III)
	||
	(计算机科学创新实验II && 计算机科学创新实验III && 计算机科学创新实验IV)
	||
	(计算机科学创新实验I && 计算机科学创新实验III && 计算机科学创新实验IV)
	||
	(计算机科学创新实验I && 计算机科学创新实验II && 计算机科学创新实验IV)
	)
	&&
	CS470 && CS490);

Event 毕业最低学分要求 = ScoreEvent("ALL" && ! "CLE", 136.5);
```



English Requirement

**.cmh** file

<img src="C:\Users\ASUS\AppData\Roaming\Typora\typora-user-images\image-20191120130415895.png" alt="image-20191120130415895" style="zoom:70%;" />

```Java
STUDENT_VARIABLE entrolled_english_level english_level;

Event English_requirements = ComEvent(SUSTech_English_I || SUSTech_English_II || SUSTech_English_III);

Event SUSTech_English_I = VariableEvent("english_level >= 1", English_I_req);

Event SUSTech_English_II = VariableEvent("english_level >= 2", English_II_req);

Event SUSTech_English_III = VariableEvent("english_level >= 3", English_III_req);

Event English_I_req = CourseEvent(CLE021 && CLE022 && CLE023 && CLE030);

Event English_II_req = ComEvent(English_II_basic_req && English_Elective_req);

Event English_III_req = ComEvent(English_III_basic_req && English_Elective_req);

Event English_II_basic_req = CourseEvent(CLE022 & CLE023 && CLE030);

Event English_III_basic_req = CourseEvent(CLE023 && CLE030);

Event English_Elective_req = ScoreEvent("CLE_Elective", 2);

```

##### 