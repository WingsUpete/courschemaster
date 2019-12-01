# Frontend To-Do List

Created by *Peter S* on *2019-12-1*

-   Completion of logic of Home page redirection links

    首页链接跳转逻辑完善

-   Wrap up `sidebar.php` into a general component, so other ends can customize their own sidebars by passing in different parameters

    `sidebar.php` 封装成为 general 组件，其他端可以通过传参定制自己的 sidebar

-   Completion of responsive styles in `header.php`

    `header.php` 中移动端的样式调整完善

-   `current_courschema` is considered as a module, with `courschema_id` as an input, using *ajax* to grab courschema data. This can be used generally in *Staff* and *Students* ends.

    `current_courschema` 作为模板组件，以 `courschema_id` 为输入，通过*ajax*拿取改培养方案数据。教工端、学生端通用。

-   `all_courschemas` is considered as a module, including choosing department, major and year, and also the `current_courschema` component. It starts with a list of departments as an input, and uses *ajax* to grab data layer by layer. All ends can use this.

    `all_courschemas` 作为模板组件，包括选择院系专业年份部分以及 `current_courschema` 组件，以院系列表为输入，通过*ajax*逐层拿取数据。全端通用。

-   `collection` is considered as a module, with sid as an input and a list of collected courschemas as the output. *Students* and *Staff* ends can use it.

    `collection` 作为模板组件，输入为学工号，输出收藏培养方案列表。学生端、教工端通用。

-   `my_plan` does not need to be a module. It contains the top `plans` tabs, and the following `current_plan` data. In `current_plan`, users can choose courses they want to learn and get a list. After *Matryona* is fully implemented, it can provide some statistics information, such as selectable learning directions, credit addition, additional advice.

    `my_plan` 无需作为模板组件。其包括顶层的 `plans`  tabs，以及接下来的 `current_plan` 数据。在 `current_plan` 中，用户可以选择计划修读的课程，并获得一个列表。在后期 *Matryona* 完善之后，可以提供一系列统计信息，包括展示可选方向的图，学分统计，附加建议等

-   `learned` does not need to be a module. It only has to get the learned courses of students from database. Backend database will connect to the interface those teachers provide and get the data we need.

    `learned` 无需作为模板组件。其只需通过数据库拿到学生已学的课程即可。后端数据库将会与老师提供的接口对接，完成数据传递。

-   *Staff* can check the information of the students they are responsible for, also just a matter of interfaces.

    教工可以查看自己负责学生的信息，这不过是又一个接口的问题。

-   *Secretary* and *TAO* can manage the courses. This can be designed as a module `course_management` to help modify certain information of certain courses. After modifications, *TAO* must pass a confirmation window, and *Secretary* must submit an application to *TAO*.

    秘书和教工部可以对课程进行管理，这可以作为一个通用模板组件 `course_management` ，以修改某一门课程的某些信息。修改完成后，教工部需要通过一个确认框，而秘书必须提交申请至教工部。

-   *Secretary* and *TAO* can manage the courschemas. This can be designed as a module `courschema_management`, with two main operations: assign students with courschemas, modify courschemas. Modifying courschemas uses real-time parsing of *Matryona*, and users can also upload course files and courschema files in the format of *Matryona*. After operations, *TAO* must pass a confirmation window, and *Secretary* must submit an application to *TAO*.

    秘书和教工部可以对培养方案进行管理，这可以作为一个通用模板组件 `courschema_management` ，其中主要有两种操作：给学生分配培养方案、修改培养方案。修改培养方案通过 *Matryona* 实时解析进行，同时用户也可上传 *Matryona* 的课程文件以及培养方案文件。操作完成后教工部将要通过一个确认框，而秘书必须提交操作申请至教工部。

-   *Secretary* has a `application_status` module to check the review status of the submitted applications. These status include **Submitted**, **Under Review**, **Reviewed (Accepted, Denied)**. There is a text area storing additional information for communications. All information above is read-only.

    秘书有一个 `appliaction_status` 通用模板组件用于查看自己提交操作申请的审核状态。其中分类包括**已提交**、**审核中**、**已审核（通过、驳回）**，并有一个文本框存储附加沟通信息。以上信息都为只读。

-   *TAO*'s review page can use the `application_status` module. For *TAO*, when entering a review application from the review list, the application’s status will automatically change to **Under Review**. When *TAO* chooses **Accept**, the status will automatically change to **Reviewed (Accepted)**; When *TAO* chooses **Deny**, the status will automatically change to **Reviewed (Denied)**. The status can be changed several times and every change will be recorded in the database. Also, the text area for additional communications is editable and for a status of **Reviewed (Denied)**, *TAO* must write in it the reasons.

    教工部的审核页面可以套用 `application_status` 模板。对于教工部而言，点击进入审核列表中的一项审核申请，该申请将自动更改状态为**审核中**。当教工部选择通过，状态将自动更改为**已审核（通过）**；当教工部选择驳回，状态将自动更改为**已审核（不通过）**。教工部可以多次修改审核状态。每次修改都会被数据库记录。此外，附加沟通信息的文本框是可以编辑的，对于驳回状态，教工部必须在该文本框中填写原因。

-   `QA` module includes a question search box with a label selector, a question list (title, mark of official certification, number of answers, latest response time), and a recommendation sub-column (FAQs, latest questions). The layout of a single question can refer to the one from *Baidu Zhidao*.

    `QA` 模块包括一个提问搜索框以及标签选择器、问题列表（标题、官方认证标签、回答数、最新反馈日期）、一个推荐子栏（FAQs, 最新提问）。单个问题的页面参考百度知道的布局。