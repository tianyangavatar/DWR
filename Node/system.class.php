<?php
	//you should create a databse named system like this 
	//"CREATE DATABASE system DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

	define('ADMINDEPARTMENTID', 0);
	//DEFINED THE ADMIN'S DEPARTMENTID IS 0
	define('CONFIRMED', 1);
	define('TOPDEPARTMENT', 0);
	define('ADMINREALNAME', 'administrator');
	define('ADMINAUTHORITY', -1);
	define('TOPTREERANK', 0);
	define('TOPDEPARTMENTNAME', 'MyEnterprise');
	define('TOPDEPARTMENTHIGHERDEPARTMENTID', '-1');
	define('TOPDEPARTMENTFUNCTIONDES', 'Control all the department');
	define('TOPDEPARTMENTREMARKS', 'MyEnterprise');
	define('DEPARTENTAUTHORITY', 1);
	define('STAFFAUTHORITY', 2);
	define('ADMINNAME', 'admin');
	
	$system = new System("localhost",
		"root","","system","departments","staffs","work_matters","projects","day_works","project_relations","project_staffs");
	$system->set_rand_key('qwerasdfzxcv');
	class System
	{
		private $host;
		private $user;
		private $pass;
		private $database;
		//departments count and table name
		private $department_ct;
		private $department_tname;
		//enterprise's staffs count and table name 
		private $staff_ct;
		private $staff_tname;
		//staff work matters count and table name
		private $work_matter_ct;
		private $work_matter_tname;
		//projects count and table name
		private $project_ct;
		private $project_tname;
		//staff's work of day table name
		private $day_work_tname;
		//projects relations table name
		private $projects_relation_tname;
		//project staffs table name
		private $project_staff_tname; 
		
		private $rand_key;
		public $error;

		function System($host,$user,$pass,$database,
			$department_tname,
			$staff_tname,
			$work_matter_tname,
			$project_tname,
			$day_work_tname,
			$projects_relation_tname,
			$project_staff_tname
			)
		{
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->database = $database;
			$this->department_tname = $department_tname;
			$this->staff_tname = $staff_tname;
			$this->work_matter_tname = $work_matter_tname;
			$this->project_tname = $project_tname;
			$this->day_work_tname = $day_work_tname;
			$this->projects_relation_tname = $projects_relation_tname;
			$this->project_staff_tname = $project_staff_tname;
		}

		public function set_rand_key($rk)
		{
			$this->rand_key = $rk;
		}

		public function _gethost()
		{
			return $this->host;
		}
		public function _sethost($host)
		{
			$this->host = $host;
		}
		public function _getuser()
		{
			return $this->user;
		}
		public function _setuser($user)
		{
			$this->user = $user;
		}
		public function _getpass()
		{
			return $this->pass;
		}
		public function _setpass($pass)
		{
			$this->pass = $pass;
		}
		public function _getdatabase()
		{
			return $this->database;
		}
		public function _setdatabase($database)
		{
			$this->database = $database;
		}
		public function Getdepartment()
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->department_tname ORDER BY id";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	//print("Very large cities are: "); 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res; 
		}
		public function LinkDB()
		{
			$link = mysqli_connect( 
                $this->host,  
                $this->user,      
                $this->pass, 
                $this->database
            );    
            if (!$link) { 
            	printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error()); 
            	exit; 
            }
            else
            {
            	return $link;
            } 
		}
		//create all tables
		public function Ensuretable(&$link)
		{
			$result = mysqli_query($link,"SHOW COLUMNS FROM $this->department_tname");   
            if(!$result)
            {
                if(!$this->CreatedepartmentsTable($link))
                	return false;
            }
            $result = mysqli_query($link,"SHOW COLUMNS FROM $this->staff_tname");   
            if(!$result)
            {
                if(!$this->CreatestaffsTable($link))
                	return false;
            }
            $result = mysqli_query($link,"SHOW COLUMNS FROM $this->day_work_tname");   
            if(!$result)
            {
                if(!$this->CreateDay_work_Table($link))
                	return false;
            }
            $result = mysqli_query($link,"SHOW COLUMNS FROM $this->work_matter_tname");   
            if(!$result)
            {
                if(!$this->CreateWork_mattersTable($link))
                	return false;
            }
            //add for project
            $result = mysqli_query($link,"SHOW COLUMNS FROM $this->project_tname");   
            if(!$result)
            {
                if(!$this->CreateProjectTable($link))
                	return false;
            }
            $result = mysqli_query($link,"SHOW COLUMNS FROM $this->projects_relation_tname");   
            if(!$result)
            {
                if(!$this->CreateProjectRelationTable($link))
                	return false;
            }
            $result = mysqli_query($link,"SHOW COLUMNS FROM $this->project_staff_tname");   
            if(!$result)
            {
                if(!$this->CreateProjectStaffTable($link))
                	return false;
            }
            //add for project
            return true;
		}
		//create departments' table
		public function CreatedepartmentsTable(&$link)
		{
			$sql = "Create table $this->department_tname(
				id INT NOT NULL AUTO_INCREMENT,
				name varchar(64) not null,
				higher_department_id int not null,
				leader_id int not null,
				function_des varchar(256),
				remarks varchar(128),
				primary key(id))";
			$result = mysqli_query($link,$sql);
			if(!$result)
				return false;
			else
				return true;   
		}
		//create staffs' tables
		public function CreatestaffsTable(&$link)
		{
			$sql = "Create table $this->staff_tname(
				id INT NOT NULL AUTO_INCREMENT,
				name varchar(64) not null,
				password varchar(64) not null,
				department_id int not null,
				email varchar(64) not null,
				realname varchar(64) not null,
				authority int not null,
				primary key(id))";
			//权限应该设置常量，现在默认，2 中心领导 ，1，部门领导，0，员工，-1：管理员
			$result = mysqli_query($link,$sql);
			if(!$result)
				return false;
			else
				return true;   
		}
		//create table of every staff day_works
		public function CreateDay_work_Table(&$link)
		{
			$sql = "Create table $this->day_work_tname(
				id int not null auto_increment,
				staff_id INT NOT NULL,
				work_date varchar(64) not null,
				work_load int not null,
				starttime varchar(64) not null,
				endtime varchar(64) not null,
				progress int,
				work_day int not null,
				confirm int not null,
				primary key(id))";
			//echo $sql;
			$result = mysqli_query($link,$sql);
			if(!$result)
				return false;
			else
				return true; 
		}
		//create table of every staff's workmatters
		public function CreateWork_mattersTable(&$link)
		{
			$sql = "Create table $this->work_matter_tname(
				work_matter_id int not null auto_increment,
				staff_id INT NOT NULL ,
				matter_date varchar(64) not null,
				project_id int not null,
				work_matter_name varchar(64),
				work_matter_time varchar(16) not null,
				work_matter_content varchar(2000),
				work_matter_remark varchar(2000),
				primary key(work_matter_id))";
			//echo $sql;
			$result = mysqli_query($link,$sql);
			if(!$result)
				return false;
			else
				return true; 
		}
		//add for porject by ty
		//create project table
		public function CreateProjectTable(&$link)
		{
			$sql = "Create table $this->project_tname(
				project_id int not null auto_increment,
				project_tree_rank int not null,
				department_id INT NOT NULL ,
				project_name varchar(128) not null,
				project_des  varchar(1024),
				leader_id varchar(64),
				need_time varchar(64) not null,
				progress varchar(64) not null,
				project_remark varchar(256),
				starttime varchar(128) not null,
				endtime varchar(128) not null,
				primary key(project_id))";
			//echo $sql;
			$result = mysqli_query($link,$sql);
			if(!$result)
				return false;
			else
				return true; 
		}
		//create project relation table 
		public function CreateProjectRelationTable(&$link)
		{
			//顶级项目的higher_project_id为-1,tree_rank=0
			$sql = "Create table $this->projects_relation_tname(
				project_id INT NOT NULL,
				higher_project_id INT NOT NULL ,
				primary key(project_id,higher_project_id))";
			//echo $sql;
			$result = mysqli_query($link,$sql);
			if(!$result)
				return false;
			else
				return true; 
		}
		//create project and staff relation table
		public function CreateProjectStaffTable(&$link)
		{
			$sql = "Create table $this->project_staff_tname(
				project_id INT NOT NULL,
				staff_id INT NOT NULL ,
				contribute_time VARCHAR(128) NOT NULL ,
				primary key(project_id,staff_id))";
			//echo $sql;
			$result = mysqli_query($link,$sql);
			if(!$result)
				return false;
			else
				return true; 
		}
		/////////////////////////////////////
		//add a new department into enterprise
		public function AddDepartment($department_name,$higher_department_id,$leader_id,$function_des,$remarks)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "insert into $this->department_tname (name, higher_department_id,
            	leader_id,function_des,remarks) values ('$department_name'
            	,'$higher_department_id','$leader_id','$function_des','$remarks')";
			echo $sql;
            $result = mysqli_query($link, $sql);
            mysqli_close($link);
            return $result;
		}
		//add a new staff into enterprise
		public function AddStaff($login_name,$login_pass,$department_id,$realname,$email,$authority)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$login_name = trim($login_name);
			$login_pass = trim($login_pass);
			$login_pass = md5($login_pass);
            $sql = "insert into $this->staff_tname (name, password,department_id,email,realname,authority) values 
            ('$login_name','$login_pass','$department_id','$email','$realname','$authority')";
            $result = mysqli_query($link, $sql);
            mysqli_close($link);
            return $result;
		}
		//add a new work matter of a staff on a day
		public function AddworkMatters($staff_id,$work_matter_name,$work_matter_content,$work_matter_time
			,$work_matter_remark,$project_id,$matter_date)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "insert into $this->work_matter_tname (staff_id,matter_date,project_id,
             	work_matter_name,work_matter_time,work_matter_content,work_matter_remark)
             	 values('$staff_id','$matter_date','$project_id','$work_matter_name',
             	 	'$work_matter_time','$work_matter_content'
             	 	,'$work_matter_remark')";
			echo $sql;
            if ($result = mysqli_query($link, $sql)) { 
            	mysqli_close($link);
            	return true;	
            } 
            echo $sql;
            return false;		
		}
		//add a new project into enterprise
		function AddNewProject($project_tree_rank,$department_id,$project_name,
			$project_des,$leader_id,$need_time,$progress,$project_remark,$starttime,$endtime)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "insert into $this->project_tname (project_tree_rank, department_id, project_name,
            	project_des,leader_id,need_time,progress,project_remark,starttime,endtime) 
				values ('$project_tree_rank','$department_id','$project_name','$project_des',
					'$leader_id','$need_time','$progress','$project_remark','$starttime','$endtime')";
            $result = mysqli_query($link, $sql);
            mysqli_close($link);
            return $result;
		}
		//add a new project relation into the relations of all projects when you add a new project into enterprise
		function AddProjectRelation($cur_projectid,$higher_project_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "insert into $this->projects_relation_tname (project_id, higher_project_id) 
				values ('$cur_projectid','$higher_project_id')";
            $result = mysqli_query($link, $sql);
            mysqli_close($link);
            return $result;
		}
		//Add a staff to work for a project
		function AddProjectStaff($cur_projectid,$staff_id,$contribute_time)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "insert into $this->project_staff_tname (project_id, staff_id,contribute_time) 
				values ('$project_id','$staff_id','$contribute_time')";
            $result = mysqli_query($link, $sql);
            mysqli_close($link);
            return $result;
		}

		//get all the staffs of enterpirse 
		public function Getstaffs()
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->staff_tname ORDER BY id";
            $res = array();
            if ($result = mysqli_query($link, $sql)) {  
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res;
		}
		// Get the counters of the staffs in a department
		public function GetStaffCountinDepartment($department_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT count(*) as ct FROM $this->staff_tname where department_id='$department_id'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res[0]['ct'];
		}
		//Get real name by staff_id
		public function GetRealnamebystaff_id($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->staff_tname where id='$staff_id'";
            //echo $sql;
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            //print_r($res);
            return $res[0]['realname'];	
		}
		//Get department name by department id
		public function GetDepartmentNamebydepartment_id($department_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->department_tname where id='$department_id'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            if(!empty($res))
            	return $res[0]['name'];
            else
            	return "";	
		}
		//Get department id by leader of the department id 
		public function Getdepartment_idbyLeaderid($leader_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->department_tname where leader_id='$leader_id'";
            //echo $sql;
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	//print("Very large cities are: "); 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res[0]['name'];		
		}
		//Get the work time of one staff on a day
		public function GetWorkloadofstaff_idDate($staff_id,$date)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT a.id,a.name,a.realname,b.work_load,b.starttime,b.endtime,b.progress,b.work_day 
            FROM $this->staff_tname as a,$this->day_work_tname as b where a.id=b.staff_id 
            and b.work_date='$date' and a.id='$staff_id'";
            //echo $sql;
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		$staff_id = $row['id'];
            		$work_matters = $this->GetWorkmattersbystaff_idonDate($staff_id,$date);
            		$row['work_matters'] = $work_matters;
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res;
		}
		//Get all the work loads of a departments' staff
		public function GetWorkloadofDepartment($department_id,$date)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT a.id,a.name,b.work_load,b.starttime,b.endtime,b.progress,b.work_day 
            FROM $this->staff_tname as a,$this->day_work_tname as b where a.id=b.staff_id 
            and b.work_date='$date' and a.department_id='$department_id'";
            //echo $sql;
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		$staff_id = $row['id'];
            		$work_matters = $this->GetWorkmattersbystaff_idonDate($staff_id,$date);
            		//print_r($work_matters);
            		$row['work_matters'] = $work_matters;
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res;
		}
		//Get all the work matters of one staff on a date 这个函数跟项目无关联
		public function GetWorkmattersbystaff_idonDate($staff_id,$date)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}

            $sql = "SELECT * FROM $this->work_matter_tname where staff_id = '$staff_id' and 
            matter_date = '$date'";
            //echo $sql;
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res;
		}
		//Get all the work matters of one staff on a date 这个函数是和项目相关联的函数
		public function GetWorkmattersbystaff_idonDate1($date,$staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT a.work_matter_id,b.name,a.work_matter_time,
            a.work_matter_content,a.work_matter_remark FROM $this->work_matter_tname as a,
            $this->project_tname as b where a.project_id = b.project_id and 
            a.work_date = '$date' and a.staff_id='$staff_id'";
            echo $sql;
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res;
		}
		//Get all work matters of a staff on a day
		public function GetWorkmatterofStaffonDay($staff_id,$date)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->work_matter_tname where staff_id = '$staff_id' and 
            work_date = '$date'";
            //echo $sql;
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res;	
		}
		//Delete a work matter from  the staff work matters
		public function DeleteWorkmatterByWMid($wmid)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "delete from $this->work_matter_tname where work_matter_id='$wmid'";
            if ($result = mysqli_query($link, $sql)) { 
            	mysqli_close($link);
            	return true;	
            } 
            echo $sql;
            return false;	
		}
		//confirm the whole works of a staff in a day
		public function ConfirmDayWork($staff_id,$date,$work_load,$st,$et,$prg,$work_day)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			if($this->IsFieldContentExsitinTable($this->day_work_tname,'staff_id',$staff_id)&&
				$this->IsFieldContentExsitinTable($this->day_work_tname,'work_day',$date))
				return false;
            $sql = "insert into $this->day_work_tname (staff_id,work_date,work_load,
            	starttime,endtime,progress,confirm,work_day) 
            values (
            	'$staff_id',
            	'$date','$work_load','$st','$et','$prg','".CONFIRMED."','$work_day'
            	)";
            if ($result = mysqli_query($link, $sql)) { 
            	mysqli_close($link);
            	return true;	
            } 
            //echo $sql;
            return false;
		}
		//Get the last day work whitch one that has not been confirmed
		public function GetnotConfirmedLast($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "SELECT * from $this->day_work_tname where staff_id='$staff_id' and confirm='
            ".CONFIRMED."' ORDER BY id DESC";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            if(empty($res))
            {
            	return date("Y-m-d",time());
            }
            else
            {
            	$d =  $res[0]['work_date'];
            	$time = strtotime($d)+86400;
    			$qrd = date("Y-m-d",intval($time));
    			//echo "qrd=$qrd";
    			return $qrd;	
    		}
		}
		//Get staff id by staff login_name
		public function Getstaff_idbydLoginname($login_name)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "SELECT * from $this->staff_tname where name='$login_name'";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            //echo $sql;
            mysqli_close($link);
            return $res[0]['id'];	
		}
		//Checking the staff is leader or not
		public function IsLeader($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * from $this->department_tname where leader_id='$staff_id'";
            //echo $sql;
            $res = array();
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            if (!empty($res)) 
            {
            	//print_r($res);
            	return true;
            }
            else
            	return false; 
		}
		//Get the department of the leader by leader's staff id
		public function GetDepartmentofLeader($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "SELECT * from $this->department_tname where leader_id='$staff_id'";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res[0]['id'];
		}
		//Check session login or not
		public function CheckSessionLogin()
		{
			if(!isset($_SESSION)){ session_start(); }
			if(isset($_SESSION[$this->GetSessionVar()]))
				return true;
			else
				return false;
		}
		//check all the staff login
		public function Login($username,$password)
		{
			if(empty($_POST['username']))
			{
				echo "Username id empty!";
				return false;
			}
			if(empty($_POST['password']))
			{
				echo "password id empty!";
				return false;
			}
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			if(!$this->CheckLoginInDB($username,$password))
            {
                return false;
            }
            $userid = $this->Getstaff_idbydLoginname($username);
            if(!isset($_SESSION))
			{ 
				session_start();
			}
			$_SESSION[$this->GetSessionVar()]=$userid;
			return true;
		}
		//Get session var savaed username
		public function GetSessionVar()
		{
			$retvar = md5($this->rand_key);
			$retvar = 'user_'.substr($retvar,0,10);
			return $retvar;
		}
		//Check log in or not in database
		public function CheckLoginInDB($u,$p)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
			//encode password
			$p = md5($p);
            $sql = "SELECT * from $this->staff_tname where name='$u'";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            $p = trim($p);
            if(empty($res))
            {
            	$this->error="username is not exist";
            	return false;
            }
            if ($res[0]['password']===$p)
            {
            	return true;	
            }
            else
            {
            	$this->error="password is not crrect";
            	return false;
            }
		}
		//the function for staff changing password 
		public function ChangePassword($username,$password)
		{
			$username = trim($username);
			$password = trim($password);
			$password = md5($password);
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "update $this->staff_tname set password='$password' where name='$username'";
            if ($result = mysqli_query($link, $sql)) 
            	return true;
            else
            	return false;
		}
		//Checking the old password is right or not
		public function IsOldpassRight($staff_id,$oldpass)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "SELECT * from $this->staff_tname where id='$staff_id'";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            $p = trim($oldpass);
            //encode password
            $p = md5($p);
            if ($res[0]['password']===$p)
            {
            	return true;	
            }
            else
            	return false;
		}
		//Get staff by staff id
		public function GetStaffbystaff_id($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "SELECT * from $this->staff_tname where id='$staff_id'";
            //echo $sql;
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res[0];
		}
		//the funtion for staff loggint out
		public function LogOut()
		{
			session_start();
			$sessionvar = $this->GetSessionVar();
			$_SESSION[$sessionvar] = NULL;
			unset($_SESSION[$sessionvar]);
			session_destroy();
		}
		//Get department by department id
		public function GetDepartmentbydepartment_id($department_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "SELECT * from $this->department_tname where id='$department_id'";
            //echo $sql;
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            if(!empty($res))
            	return $res[0];
            else
            	return 0;
		}
		//the function for staff updating self information
		public function UpdateStaff($login_name,$login_pass,$department_id,$realname,$email,$staff_id,$authority)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "UPDATE $this->staff_tname SET name='$login_name',password='$login_pass',
            department_id='$department_id',email='$email',realname='$realname',
            authority='$authority' WHERE id='$staff_id'";
            echo $sql;
            
            if ($result = mysqli_query($link, $sql)) {
             mysqli_close($link);
            	return true;
            } 
            else
            	return 0;	
		}
		//the function for Update the department information
		public function UpdateDepartment($department_name,$higher_department_id, 
			$leader_id,$function_des,$remarks,$department_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "UPDATE $this->department_tname SET name='$department_name',
            higher_department_id='$higher_department_id',
            leader_id='$leader_id',function_des='$function_des',remarks='$remarks' WHERE id='$department_id'";
            //echo $sql;
            if ($result = mysqli_query($link, $sql)) {
            	mysqli_close($link); 
            	return true;
            } 
            else
            	return 0;		
		}
		//Delete department !!!!!!!!!!the staff belonged to the department will not get department
		public function DeleteDepartment($department_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
			
            $sql = "DELETE from $this->department_tname WHERE id='$department_id'";
            if ($result = mysqli_query($link, $sql)) {
             mysqli_close($link);
            	return true;
            } 
            else
            	return 0;	
		}
		//Delete staff by admin or department leader
		public function DeleteStaff($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();

            $sql = "DELETE from $this->staff_tname WHERE id='$staff_id'";
            if ($result = mysqli_query($link, $sql)) {
            	mysqli_close($link); 
            	return true;
            } 
            else
            	return 0;	
		}
		//generate admin for setup dwr system !!!!!!!!!!!!!!!!!!!!!!!!!!! move to admin class
		public function GenerateAdmin($admin_email)
		{
			//管理员的权限是-1；
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$ps = $this->randomkeys(6);
			//encode password
			$psi = md5($ps);
			if($this->IsFieldContentExsitinTable($this->staff_tname,'name',ADMINNAME))
				return false;

			$sql = "insert into $this->staff_tname (name, password,department_id,email,realname,authority)
			 values ('".ADMINNAME."'
            	,'$psi','".TOPDEPARTMENT."','".trim($admin_email)."','".ADMINREALNAME."','".ADMINAUTHORITY."')";
			if (!$result = mysqli_query($link, $sql)) {
            	return false;
            }
            else
            {
            	$sql = "SELECT LAST_INSERT_ID() as id";
            	$result = mysqli_query($link, $sql);
            	$row = mysqli_fetch_assoc($result);
            	$id = ($row['id']);
            	$sql = "insert into $this->department_tname (name, higher_department_id,leader_id,
            		function_des,remarks)
            	 values ('".TOPDEPARTMENTNAME."'
            	,'".TOPDEPARTMENTHIGHERDEPARTMENTID."','$id','".TOPDEPARTMENTFUNCTIONDES."','".
            	TOPDEPARTMENTREMARKS."')";
				//echo $sql;
				if (!$result = mysqli_query($link, $sql)) {
            		return false;
            	}
            	else
            		return $ps;
            } 
		}
		//Generate random keys
		public function randomkeys($length)
		{
			$pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
			$key="";
			for($i=0;$i<$length;$i++)
			{
				$key .= $pattern{mt_rand(0,35)};    //生成php随机数
			}
	 		return $key;
		}
		//Get a staff work maters by staff id and date
		public function GetWorkmattersbystaff_id($staff_id,$date)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "SELECT * from $this->work_matters where staff_id='$staff_id' and md_date='$date'";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res[0];
		}
		//Delete a staff's day work
		public function DeleteDayWork($staff_id,$date)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "DELETE from $this->day_work_tname where staff_id='$staff_id' and work_date='$date'";
            //echo $sql;
            if ($result = mysqli_query($link, $sql)) { 
            	return true;
            }
            else
            	return false;
		}
		//Check the staff is a department or not
		public function IsDepartmentLeader($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
			$staff_id = trim($staff_id);
            $sql = "SELECT * from $this->staff_tname where id='$staff_id'";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            $bid= $res[0]['authority'];  
            //define!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            if($bid==DEPARTENTAUTHORITY)
            	return true;
            else
            	return false;
		}
		//
		public function IsEnterpriseLeader($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
			$staff_id = trim($staff_id);
            $sql = "SELECT * from $this->staff_tname where id='$staff_id'";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            $bid= $res[0]['authority']; 
            //define!!!!!!!!!!!!!!!!!!!!!!!!!!!! authority 
            if($bid==STAFFAUTHORITY)
            	return true;
            else
            	return false;
		}
		//Checking the staff is admin or not
		public function IsAdmin($staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
			$staff_id = trim($staff_id);
            $sql = "SELECT * from $this->staff_tname where id='$staff_id'";
             if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            $bid= $res[0]['authority'];
            //authority = -1 is the admin authority  
            if($bid==-1)
            	return true;
            else
            	return false;
		}
		//Checking the date is work day nor not (work day:monday---friday)
		public function IsWorkday($date)
		{
			$xqj = date('w',strtotime($date)); 
			if($xqj>0&&$xqj<6)
				return true;
			else
				return false;
		}

		

		
		//Get project by project id
		function GetProjectByid($project_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->project_tname WHERE project_id='$project_id'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	//print("Very large cities are: "); 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res; 
		}
		//Get all the projects
		function GetAllProjects()
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->project_tname ORDER by project_id";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res; 
		}
		//Get all the top projects
		function GetRank0Projects()
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->project_tname ORDER by project_id 
            WHERE project_tree_rank='".TOPTREERANK."'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res; 
		}
		//Get all projects by department id
		function GetAllProjectsByDepartmentid($department_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			//!!!!!!!!!!!!!!!now the project belonged to the department is top rank?????
			$sql = ($department_id==ADMINDEPARTMENTID)?"SELECT * FROM $this->project_tname WHERE project_tree_rank='".TOPTREERANK."'":
            "SELECT * FROM $this->project_tname WHERE department_id='$department_id' and project_tree_rank='".TOPTREERANK."'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) {  
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            }
            //echo $sql; 
            mysqli_close($link);
            return $res; 
		}
		//Get project by project name
		function GetProjectByname($project_name)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->project_tname WHERE project_name='$project_name'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res[0]; 
		}
		//Update project by project information's key and value
		function UpdateProject($fieldname,$fieldcontent,$project_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "update $this->project_tname set $fieldname='$fieldcontent' where project_id='$project_id'";
            if ($result = mysqli_query($link, $sql)) 
            	return true;
            else
            	return false;
		}
		//delete project by project id
		function DeleteProject($project_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "delete from $this->project_tname where project_id='$project_id'";
            if ($result = mysqli_query($link, $sql)) { 
            	mysqli_close($link);
            	return true;	
            } 
            echo $sql;
            return false;	
		}

		//update project relationship
		function UpdateProjectRelation($cur_projectid,$higher_project_id,$higher_project_id_former)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "update $this->projects_relation_tname 
            set higher_project_id='$higher_project_id' 
            where project_id='$cur_projectid' and higher_project_id='$higher_project_id_former'";
            if ($result = mysqli_query($link, $sql)) 
            	return true;
            else
            	return false;
		}
		//Get projects higher relation project id
		function GetProjectHihgerRelation($project_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT * FROM $this->projects_relation_tname WHERE project_id='$project_id'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            return $res['higher_project_id']; 
		}
		//Get the all the projects that belonged to the current project not recursion
		function GetLowerProjects($project_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "SELECT project_id FROM $this->projects_relation_tname WHERE higher_project_id='$project_id'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) {
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            $resp = array();
            //print_r($res);
            foreach ($res as $key => $value) {
            	$pid = $value['project_id'];
            	$pro = $this->GetProjectByid($pid);
            	$pro = $pro[0];
            	$resp[$pid]=$pro;
            }
            //print_r($resp);
            return $resp; 
		}
		//delete the project relation
		function DeleteProjectRelation($project_id,$higher_project_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "delete from $this->projects_relation_tname 
            where project_id='$project_id' and higher_project_id='$higher_project_id'";
            if ($result = mysqli_query($link, $sql)) { 
            	mysqli_close($link);
            	return true;	
            } 
            echo $sql;
            return false;	
		}
		//update the staff contribute time to the project
		function UpdateProjectStaffContributetime($project_id,$staff_id,$contribute_time)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
			$res = array();
            $sql = "update $this->project_staff_tname set contribute_time='$contribute_time' 
            where project_id='$project_id' and staff_id='$staff_id'";
            if ($result = mysqli_query($link, $sql)) 
            	return true;
            else
            	return false;
		}
		//delete the staff belonged to the project
		function DeleteProjectStaff($project_id,$staff_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            $sql = "delete from $this->project_staff_tname
             where project_id='$project_id' and staff_id='$staff_id'";
            if ($result = mysqli_query($link, $sql)) { 
            	mysqli_close($link);
            	return true;	
            } 
            echo $sql;
            return false;	
		}
		//get project tree depth
		function GetProjectTreeDepth($projectid)
		{ 
			$lpros = $this->GetLowerProjects_sel($projectid);
			if(empty($lpros))
			{
				return 1;
			}
			else 
			{
	
					$om = array();
					foreach ($lpros as $key => $value) {
						//echo "</br>value=";
						//print_r($value);
						$od = $this->GetProjectTreeDepth($value['project_id'])+1;
						array_push($om,$od);
					}
					$cu = 1;
					echo "</br>projid=$projectid...om=";
					print_r($om);
					foreach ($om as $key => $value) {
						if($value>$cu)
							$cu=$value;
					}
					return $cu;
			}
				
		}
		//Get lower projects for selected
		function GetLowerProjects_sel($project_id)
		{
			$link = $this->LinkDB();
			if(!$this->Ensuretable($link))
			{
				printf("table ensure is false");
				return false;
			}
            if($project_id==0)
			{
				$sql = "SELECT * FROM $this->project_tname WHERE project_tree_rank ='0'";
				$res = array();
            	if ($result = mysqli_query($link, $sql)) { 
            		while( $row = mysqli_fetch_assoc($result) ){ 
            			array_push($res,$row);
            		} 
            	mysqli_free_result($result); 
            	} 
            	mysqli_close($link);
            	//print_r($res);
            	return $res;
			}
			$sql = "SELECT project_id FROM $this->projects_relation_tname WHERE higher_project_id='$project_id'";
            $res = array();
            if ($result = mysqli_query($link, $sql)) { 
            	while( $row = mysqli_fetch_assoc($result) ){ 
            		array_push($res,$row);
            	} 
            	mysqli_free_result($result); 
            } 
            mysqli_close($link);
            $resp = array();

            if(!empty($res))
            {
            	foreach ($res as $key => $value) {
            		$pid = $value['project_id'];
            		$pro = $this->GetProjectByid($pid);
            		$pro = $pro[0];
            		$resp[$pid]=$pro;
            	}
        	}
            return $resp; 
		}

		//add for project by ty
		function IsFieldContentExsitinTable($tablename,$fieldname,$fieldcontent)
		{
			$link = $this->LinkDB();
            if(!empty($tablename)&&!empty($fieldname)&&!empty($fieldcontent))
			{
				$sql = "SELECT * FROM $tablename WHERE $fieldname ='$fieldcontent'";
            	if ($result = mysqli_query($link, $sql)) { 
            		$row=mysqli_fetch_assoc($result);
            		if(!empty($row))
            		{
            			return true;
            		}
            		return false;
            	} 
            	mysqli_close($link);
            	//print_r($res);
            	return false;
			}
			return false;
		}
	}
?>