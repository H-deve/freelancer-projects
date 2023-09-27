<?php
class student_model extends CI_Model {
	
	function user_data($user_id)
	{
		$q="SELECT * FROM user where id=?";
		$sql=$this->db->query($q,array($user_id)); 
		if ($sql->num_rows == 0)
           { return 0;}
		else {
			foreach ($sql->result() as $raw ) {
					$data[]=$raw;
				}
			return $data;
		}			 
	}
	
	function add_student()
	{
		$bar_code=isset($_POST['bar_code'])?$_POST['bar_code']:'';
		$q="INSERT INTO student(bar_code,name,father_name,last_name,birthdate,part_number,address,phone,gender,level,created_on)  VALUES(?,?,?,?,?,?,?,?,?,?,DATE_FORMAT(NOW(),'%Y-%m-%e'))";
		$sql=$this->db->query($q,array($bar_code,$_POST['name'],$_POST['father_name'],$_POST['last_name'],$_POST['birhtdate'],$_POST['part_number'],$_POST['address'],$_POST['phone'],$_POST['gender'],$_POST['level'])); 
		$student_id=$this->db->insert_id();
		$ret=is_uploaded_file ($_FILES['fics']['tmp_name']);
		if ( !$ret )
		{
			echo "error on uploading";
//			return false;
			$filename= 'default.jpg';
		}
		else
		{
			$tmp_name=$_FILES['fics']['tmp_name'];
			$filename= $student_id.'.jpg';
			  $location=realpath($_SERVER['DOCUMENT_ROOT'])."\\".basename(getcwd())."\\uploads\\".$filename;
			move_uploaded_file($tmp_name, $location);
			 $this->db->where('id', $student_id);
			$result=$this->db->update("student",array('bar_code'=>$student_id,'url'=>$filename));
				
		}
		$q="INSERT INTO student_course(student_id,course_id,register_date)  SELECT '".$student_id."',MAX(id),DATE_FORMAT(NOW(),'%Y-%m-%e') FROM course";
		$sql=$this->db->query($q); 
		
		$student_course_id=$this->db->insert_id();
		$q="INSERT INTO course_day(student_course_id,come_date,come_time)VALUES (?,DATE_FORMAT(NOW(),'%Y-%m-%e'),DATE_FORMAT(NOW(),'%H:%i:%s'))";
		$sql=$this->db->query($q,array($student_course_id)); 
		return $student_id;
	}
	function get_student($bar_code)
	{
		$q="SELECT *, CONCAT(name,' ',father_name,'  ',last_name)as student_name FROM student
		where bar_code=?";
		$sql=$this->db->query($q,array($bar_code)); 
		if ($sql->num_rows > 0)
		{
			foreach($sql->result() as $raw)
			{
				$data[]=$raw;
			}
			return $data;
		}
		else
			return false;
	}
	function get_student_day($student_id)
	{
		
		$q="SELECT MAX(id)as m_id FROM course";
		$sql=$this->db->query($q,array($student_id)); 
		foreach($sql->result() as $raw)
		{
			$data[]=$raw;
		}
		$x=$data[0]->m_id;
		$q="SELECT register_date,SUM(pages)as page_num,COUNT(course_day.id)as days_num FROM student_course
		inner join course_day on student_course_id=student_course.id
		where course_id=? and student_id=?";
		$sql=$this->db->query($q,array($x,$student_id)); 
		foreach($sql->result() as $raw)
		{
			$data2[]=$raw;
		}
		return $data2;
	}
	function get_student_table($student_id)
	{
		
		$q="SELECT MAX(id)as m_id FROM course";
		$sql=$this->db->query($q,array($student_id)); 
		foreach($sql->result() as $raw)
		{
			$data[]=$raw;
		}
		$x=$data[0]->m_id;
		$q="SELECT come_date,come_time,leave_time,pages FROM student_course
		inner join course_day on student_course_id=student_course.id
		where course_id=? and student_id=? order by course_day.id DESC";
		$sql=$this->db->query($q,array($x,$student_id)); 
		foreach($sql->result() as $raw)
		{
			$data2[]=$raw;
		}
		return $data2;
	}
	function get_student_table_dates($student_id,$dates0,$dates1)
	{
		
		$q="SELECT come_date,come_time,leave_time,pages FROM student_course
		inner join course_day on student_course_id=student_course.id
		where student_id=? AND come_date BETWEEN STR_TO_DATE('".$dates0."','%m/%e/%Y') AND STR_TO_DATE('".$dates1."','%m/%e/%Y') order by course_day.id DESC";
		$sql=$this->db->query($q,array($student_id)); 
		if($sql->num_rows()>0)
		{
			foreach($sql->result() as $raw)
			{
				$data2[]=$raw;
			}
			return $data2;
		}
		
	}
	function new_course($summer)
	{
		$q="INSERT INTO course (summer,date)VALUES(?,DATE_FORMAT(NOW(),'%Y-%m-%e'))";
		$sql=$this->db->query($q,array($summer));
	}
	function enter_student($bar_code)
	{
		$q="SELECT MAX(id)as m_id FROM course";
		$sql=$this->db->query($q); 
		foreach($sql->result() as $raw)
		{
			$data2[]=$raw;
		}
		$x=$data2[0]->m_id;
		$q="SELECT student_course.id as s_c_id from student 
			inner join student_course on student.id=student_id
			where bar_code=? AND course_id=?";
		$sql=$this->db->query($q,array($bar_code,$x)); 
		if($sql->num_rows()==0)
		{
			$q="INSERT INTO student_course(student_id,course_id,register_date)  SELECT id,".$x.",DATE_FORMAT(NOW(),'%Y-%m-%e') FROM student where bar_code=?";
			$sql=$this->db->query($q,array($bar_code)); 
			$x=$this->db->insert_id();
		}
		else
		{
			foreach($sql->result() as $raw)
			{
				$data3[]=$raw;
			}
			$x=$data3[0]->s_c_id;
		}
		
		$q="INSERT INTO course_day(student_course_id,come_date,come_time)VALUES (?,DATE_FORMAT(NOW(),'%Y-%m-%e'),DATE_FORMAT(NOW(),'%H:%i:%s'))";
		$sql=$this->db->query($q,array($x)); 
	}
	function leave_student($bar_code,$pages)
	{
		$q="UPDATE course_day SET leave_time=DATE_FORMAT(NOW(),'%H:%i:%s') , pages=? 
			WHERE student_course_id=(SELECT student_course.id FROM student_course 
			inner join student on student.id=student_id 
			inner join course on course.id=course_id 
			where bar_code=?
			HAVING MAX(course_id))
			AND come_date=DATE_FORMAT(NOW(),'%Y-%m-%e')
			";
			$sql=$this->db->query($q,array($pages,$bar_code)); 
	}
	function search($search_input,$search_by)
	{
		if($search_by==1)
		{
			$where="name like '%".$search_input."%'";
		}
		else if($search_by==2)
		{
			$where="last_name like '%".$search_input."%'";
		}
		else if($search_by==3)
		{
			$where="bar_code =".$search_input;
		}
		else if($search_by==4)
			{
			$where="phone =".$search_input;
		}
		else{
			$where ="CONCAT(name,' ',last_name) like '%".$search_input."%'";
		}
			$q=" SELECT *,CONCAT(name,' ',last_name) as student_name from student where ".$where;
		$sql=$this->db->query($q); 
		if($sql->num_rows()>0)
			return $sql->result();
		return false;
		
	}
	function get_statistics()
	{
		$q="SELECT MAX(id)as m_id FROM course";
		$sql=$this->db->query($q); 
		foreach($sql->result() as $raw)
		{
			$data2[]=$raw;
		}
		$x=$data2[0]->m_id;
		
		$q="
		(SELECT sum_pages,std_day,bar_code,CONCAT(name,' ',last_name) as student_name,course_id,register_date,phone,level, @level_rank := IF(@current_level = student.level, @level_rank + 1, 1) AS level_rank, @current_level := student.level FROM 
		(SELECT *,SUM(pages)as sum_pages,COUNT(id)as std_day FROM course_day GROUP BY student_course_id) as corse_day_table 
		inner join student_course on student_course_id=student_course.id 
		inner join student on student.id=student_id  WHERE course_id=? ORDER BY level,sum_pages DESC )";
		$sql=$this->db->query($q,array($x)); 
		foreach($sql->result() as $raw)
		{
			$data[$raw->level][]=$raw;
		}
		return $data;
	}
	
}