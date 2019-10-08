

<p style="text-align:center; font-weight:bold; font-size:38px; border-top: 1px black solid; border-bottom: 1px black solid; padding: 15px; ">
    SUSTech CS309 OOAD 2019 Fall<br />Project Proposal
</p>





<table>
    <tr>
    	<td style="background-color:rgb(45,45,100); color:snow;">Project</td>
        <td>Courschema</td>
    </tr>
    <tr>
    	<td style="background-color:rgb(45,45,100); color:snow;">Prohect Name</td>
        <td>Courschemaster</td>
    </tr>
    <tr>
    	<td style="background-color:rgb(45,45,100); color:snow;">Last-Modified Date</td>
        <td>2019/10/8</td>
    </tr>
</table>





<p style="text-align:center; font-weight:bold; font-size:15px; border-top: 1px black solid; border-bottom: 1px black solid; padding: 15px; ">
    Group Members<br />
    <table>
    <tr>
        <th style="background-color:rgb(45,45,100); color:snow;">name</th>
        <th style="background-color:rgb(45,45,100); color:snow;">en_name</th>
        <th style="background-color:rgb(45,45,100); color:snow;">sid</th>
    </tr>
    <tr>
    	<td>沈静然</td>
        <td>Peter S</td>
        <td>11710116</td>
    </tr>
    <tr>
    	<td>孙挺</td>
        <td>Sunt</td>
        <td>11710108</td>
    </tr>
        <tr>
    	<td>孙龙朝</td>
        <td>LongZhao Sun</td>
        <td>11710511</td>
    </tr>
        <tr>
    	<td>欧阳晖</td>
        <td>Hui Ouyang</td>
        <td>11710106</td>
    </tr>
        <tr>
    	<td>王炜皓</td>
        <td>Mike Chester Wang</td>
        <td>11710403</td>
    </tr>
</table>
</p>



----

---



## Motivation

#### What is the problem?

1. Current format of course schema needs to be unified. 
2. Current documents are still difficult to understand.
3. Students need a platform or tool to compare his/her current plan and the course schema he/she want to finish.



#### What is your vision for solving the problem?

1. Use a simple way to unify the format and use a general representation to explain all the course schemas.
2. Visualize the course schemas. Make it easy to be modify and read.
3. Provide a platform to directly search the course schemas that the users want to see.
4. Provide a platform for users to create and modify the course schema.
5. Provide a general representing method to adapt all the course schemas.
6. Provide a content combining the courses which have been learned already and the course schemas.



#### What are your "silver bullets"?

1. Team cohesiveness
2. Efficient approaches of development



#### Feature Description

...



#### Formalize with UML

Teacher end (Use Cases)

![teacher_end_use_case](..\archived\img\teacher_end_use_case.svg)



Student end (Use Cases)

![Student end- Use Case](C:\AppServ\Courschemaster\archived\img\Student end- Use Case.png)

## Requirements

#### Functional requirements

1. User authentication
2. Functions in different groups
   - Teacher
     - General
       - Check all the course schemas
       - Download course schemas
       - Check visible students' information
     - Secretary
       - Upload course schema
       - Modify and create course schema via visualized window
       - Delete course schema
       - Contact to Administrators
       - Assign course schema to students
     - Teaching Affairs Department
       - Create new courses
       - Synchronise course information
       - Audit course schema deletion request
       - Audit course schema upload request
       - Audit course schema modification request
       - Audit course schema assignment request
   - Student
     - General
       - Download course schemas
       - Check all the course schemas
       - Check his/her current course schema assigned to him/her
       - Check "My Plan"
       - Modify "My Plan"
       - Download "My Plan"
       - Collect course schemas
       - Undo collections
       - Check the courses he/she has already passed
       - Contact to Administrators
   - Visitor
     - Check all the course schemas
     - Download course schemas



#### Non-functional requirements

- Performance
  - Support 6,000 people online at the same time
- Storage
  - Support to store data for 10,000 students
  - Support to store 1,000 course schemas
- Cost per user for deployment
  - 0 (Auto-complete with the help of CAS)



## Design document

#### Architecture

Database scheme (ER diagram, .svg)

![database scheme](..\archived\img\database scheme.svg)

```JSON
'orange'      : Entity

'Bright Blue' : Connections, Relations

'Light Blue'  : Property
```



Communication between frontend and backend (Sequence Diagram, .svg)

![Ajax request - sequence diagram](C:\AppServ\Courschemaster\archived\img\Ajax request - sequence diagram.svg)



Login, user authentication (Sequence Diagram, .svg)

![login - sequence diagram](C:\AppServ\Courschemaster\archived\img\login - sequence diagram.svg)



#### Timeline

- Current Progress

  - Frontend : draft

  - Backend : UML, set up environment(framework deployment, CAS)

  - Other : git deployment, REDAME, proposal

    

- Oct. 10th, 2019 : Requirements & Designs

- Before the next presentation : Fundamental Implementatio

- Before the last presentation : Advanced Implementation & Verification

- Regular meetings for every week



- Effort required in number of hours
  - 84 hrs



- Roles

  <table>
      <tr>
      	<td style="background-color:rgb(45,45,100); color:snow;">Database Design</td>
          <td>欧阳晖(Hui Ouyang), 王炜皓(Mike Chester Wang)</td>
      </tr>
      <tr>
      	<td style="background-color:rgb(45,45,100); color:snow;">Framework Deployment, Maintanence</td>
          <td>王炜皓(Mike Chester Wang)</td>
      </tr>
      <tr>
      	<td style="background-color:rgb(45,45,100); color:snow;">Appearance Design</td>
          <td>孙龙朝(LongZhao Sun), 孙挺(Sunt), 沈静然(Peter S)</td>
      </tr>
       <tr>
      	<td style="background-color:rgb(45,45,100); color:snow;">Frontend</td>
          <td>孙龙朝(LongZhao Sun), 孙挺(Sunt), 沈静然(Peter S)</td>
      </tr>
      <tr>
      	<td style="background-color:rgb(45,45,100); color:snow;">Backend</td>
          <td>欧阳晖(Hui Ouyang), 王炜皓(Mike Chester Wang)</td>
      </tr>
      <tr>
      	<td style="background-color:rgb(45,45,100); color:snow;">Server Management</td>
          <td>沈静然(Peter S), 王炜皓(Mike Chester Wang)</td>
      </tr>
      <tr>
      	<td style="background-color:rgb(45,45,100); color:snow;">Regular Meeting Host</td>
          <td>王炜皓(Mike Chester Wang)</td>
      </tr>
  </table>



#### APIs, services

- PHP, CodeIgniter
- Boostrap, jQuery
- MySQL
- Apache
- Git
- Composer



## Feasibility

1. Lack of familiarity with APIs

   - Visualization tools for frontend
   - PDF tools for backend.
   - docker

2. Cost excessive

   - Health Examination

   - Medical Cost

   - Party Building Funds

3. Third party APSs/service may not reilable
   - License issues
   - Existing bugs in framework
   - The development environment may not compatible with the production environment

​     