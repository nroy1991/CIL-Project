<?php
class Model_designation extends CI_Model{
	function __construct(){
			parent::__construct();	//call the model contructor
		}
		public function create_designation(){

			$q="CREATE TABLE if not exists `cil`.`designation` ( `sno` INT(11) NOT NULL AUTO_INCREMENT , `grade` VARCHAR(10) NOT NULL , `design` VARCHAR(255) NOT NULL, `remark` VARCHAR(255) NULL DEFAULT NULL , `discipline` VARCHAR(10) NULL DEFAULT NULL , PRIMARY KEY (`sno`)) ENGINE = InnoDB;";
			$this->db->query($q);
		}

		public function all_grade(){
			//$this->create_designation();
			$result = $this->db->get('designation')
			->result_array();
			//print_r($result);exit;
			return $result;
		}

		public function insert_data($data, $table){
			$this->db->insert($table, $data);
		}

		public function prev_grade($grade_id){
			$res=$this->db->where('sno', $grade_id)
			->get('designation')
			->result_array();
			return $res[0];
		}

		public function update_data_desig($data){
			$this->db->set($data)
			->where('sno', $data['sno'])
			->update('designation', $data);
		}

		//function to delete a grade
		 public function delete_grade($grade_id){
		 	$this->db->where('sno', $grade_id)
		 			 ->delete('designation');
		 }


		//ankit; to get all mines 
		public function all_mines()
		{
			$result = $this->db->select('mine_id, minecategory, munit' )->order_by('mine_id','ASC')->get('minetype')->result_array();
            //echo $result[0];
           // var_dump($result);
			return $result ;
		}
        // ankit ;to locate the mine from the match data form 

		public function get_submine_type($mine_type,$mine_prod)
		{   
			$where = "mcode= $mine_type AND plower_lim > $mine_prod AND pupper_lim <= $mine_prod";
			$result = $this->db->select('mine_id')->where($where )->get('minesubtype')->result_array();
			return $result;
		}
        //ankit; to get data of the submine used in match_view 
		public function get_submine_type_data($mine_submine_type){
			$result = $this->db->where('mcode' , $mine_submine_type)->get('std_mine_data')->result_array();
			return $result ;

		}
		 public function get_mine_mcode()
		 {
		 	$sql="SELECT a.mcode as mcode, b.minecategory as minecategory, a.plower_lim as plower_lim, a.pupper_lim as pupper_lim, b.munit as munit, a.wef as wef, a.status as status FROM minesubtype a INNER JOIN minetype b ON a.mine_id=b.mine_id ORDER BY a.mcode";
		 	$query=$this->db->query($sql)->result_array();
		 	//print_r($query);die();
		 	return $query;
		 }

		  public function get_mine_mcode_mixed()
		 {
		 	$sql="SELECT a.mcode_mixed as mcode_mixed, b.minecategory as minecategory, a.plower_lim_UG as plower_lim_UG, a.pupper_lim_UG as pupper_lim_UG, a.plower_lim_OC as plower_lim_OC, a.pupper_lim_OC as pupper_lim_OC,  b.munit as munit, a.wef as wef, a.status as status FROM minesubtype_mixed a INNER JOIN minetype b ON a.mine_id=b.mine_id ORDER BY a.mcode_mixed";
		 	$query=$this->db->query($sql)->result_array();
		 	//print_r($query);die();
		 	return $query;
		 }



		//ankit; this function is used for login of user it matches the username and password 
		public function checkCredentials($name,$password){
			$data['correct'] = false;

			if(!isset($name)||!isset($password)){
				return $data;
			}
			// echo $name . $password;
			$user = $this->db->select('id,username AS name,password,user_type')->where([
				'username'	=>	$name,
				'password'	=> 	$password,
			])->get('users')->result_array();
			$data['correct'] = (count($user)===1);
			// echo $data['correct'];
			if($data['correct']){
				$data['id'] = $user[0]['id'];
				$data['user_type'] = $user[0]['user_type'];
			}
			else{
				$data['id'] = 0;
			}
			return $data;
		}

		public function registerUser(){
			$this->load->library('form_validation');
 	 		$this->form_validation->set_rules('name','Name','required');
  			$this->form_validation->set_rules('company-name','Company Name','required');
  			$this->form_validation->set_rules('employee-id','Employee Id','required');
  			$this->form_validation->set_rules('mine-name','Mine Name','required');
  			$this->form_validation->set_rules('mine-address','Mine Address','required');
  			$this->form_validation->set_rules('email','Email ID','required|valid_email');
  			$this->form_validation->set_rules('reg-username','Username','required');
  			$this->form_validation->set_rules('reg-password','Password','required');
			$username = $this->input->post('reg-username');
			$isInvalid = !!(count($this->db->where('username',$username)->get('users')->result_array()) !== 0);
			if($isInvalid){
				// Show error message
				redirect();
			}

			
  			if($this->form_validation->run())
		{
			$data = [
				'name'			=>	$this->input->post('name'),
				'company_name'	=>	$this->input->post('company-name'),
				'employee_id'	=>	$this->input->post('employee-id'),
				'mine_name'		=>	$this->input->post('mine-name'),
				'mine_address'	=>	$this->input->post('mine-address'),
				'email'			=>	$this->input->post('email'),
				'username'		=>	$this->input->post('reg-username'),
				'password'		=>	$this->input->post('reg-password'),
			];
			if($this->db->insert('users',$data)){
				// Show success
				redirect();
			}
			else{
				// Show error
				redirect();
			}
			
		}

	}

		public function get_values(){
			
			$mine_type = $this->input->post('minecategory');
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			$mine_name=$this->input->post('mine_name');
			$year_name=$this->input->post('year_name');

			$temp = $this->model_designation->get_minetype($mine_type);
			$minecategory = $temp[0]['minecategory'];
			//print_r($minecategory);exit();
			
			//print_r($production);print_r($tot_excavation_dept);exit();
			//print_r($mine_type);exit();
			if($minecategory=="Partly Departmental & Partly Outsourced Mechanized Opencast Mines")
			{
				$var="SELECT a.production FROM mines a WHERE a.mine_id=$mine_name AND a.year_id=$year_name";
			    $varx="SELECT a.tot_excavation_dept FROM mines a WHERE a.mine_id=$mine_name AND a.year_id=$year_name";
				$query=$this->db->query($var)->result_array();
				$queryx=$this->db->query($varx)->result_array();
			//echo $this->db->last_query();
			//print_r($query[0]['production']);exit();
				$production = $query[0]['production'];
				$tot_excavation_dept = $queryx[0]['tot_excavation_dept'];


				$sqlx ="SELECT * FROM (SELECT cd.cil_cadre AS cadre, sm.E1 as e1, sm.E2 as e2, sm.E3 as e3, sm.E4 as e4, sm.E5 as e5, sm.E6    as e6, sm.E7 as e7, sm.E8 as e8 from standard_manpower sm INNER JOIN cadre cd ON cd.sno=sm.cadre 
					INNER JOIN minesubtype ms ON sm.mcode=ms.mcode WHERE ms.mine_id = $mine_type AND 
					$tot_excavation_dept > ms.plower_lim AND $tot_excavation_dept <= ms.pupper_lim AND cd.cil_cadre 
					IN ('Excavation', 'E&M', 'MM')  UNION ALL 
					SELECT cd.cil_cadre AS cadre, sm.E1 as e1, sm.E2 as e2, sm.E3 as e3, sm.E4 as e4, sm.E5 as e5, sm.E6 as e6, sm.E7 as e7, sm.E8 as e8 from standard_manpower sm INNER JOIN cadre cd ON cd.sno=sm.cadre 
					INNER JOIN minesubtype ms ON sm.mcode=ms.mcode WHERE ms.mine_id = $mine_type AND 
					$production > ms.plower_lim AND $production <= ms.pupper_lim AND cd.cil_cadre NOT IN ('Excavation', 'E&M', 'MM')) as y GROUP BY y.cadre ORDER BY y.cadre";  
				
				$resultx=$this->db->query($sqlx)->result_array();

				// echo '<pre>';
			 //    print_r($resultx);die();
			 //    echo '<\pre>';

				$sql="SELECT a.mcode from minesubtype a WHERE a.mine_id=$mine_type AND $production > a.plower_lim AND $production <= a.pupper_lim";
			$query=$this->db->query($sql)->result_array();
			//echo $this->db->last_query();die();
			//print_r($query);exit();
			$var1=$query[0]['mcode'];
			//print_r($var1);exit();

			$sql2="SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) AS e4, SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 from standard_manpower_dynamic smd 
				INNER JOIN cadre cd
				ON cd.sno=smd.cadre
				WHERE smd.mcode=$var1 AND $production > smd.min_prod AND $production <=smd.max_prod GROUP BY cd.cil_cadre ORDER BY cd.cil_cadre";
			    $result2=$this->db->query($sql2)->result_array();
				
				//print_r($result2);die();
				//echo '<pre>';
			    //print_r($result2);die();
			    //echo '<\pre>';
				return array($resultx,$result2);
				}

				else if($minecategory=="Partly Departmental & Partly Outsourced Mechanized Mixed Mines"||$minecategory=="Fully Departmental Mechanized Mixed Mines")
				{

					$var="SELECT a.tot_coal_UG FROM mines_mixed a WHERE a.mine_id=$mine_name AND a.year_id=$year_name";
					$varx="SELECT a.tot_excavation FROM mines_mixed a WHERE a.mine_id=$mine_name AND a.year_id=$year_name";
					$query=$this->db->query($var)->result_array();
					$queryx=$this->db->query($varx)->result_array();
			//echo $this->db->last_query();
			//print_r($query[0]['production']);exit();
					$tot_coal_UG = $query[0]['tot_coal_UG'];
					$tot_excavation = $queryx[0]['tot_excavation'];


					$sqlx ="SELECT cd.cil_cadre AS cadre, sm.E1 as e1, sm.E2 as e2, sm.E3 as e3, sm.E4 as e4, sm.E5 as e5, sm.E6    as e6, sm.E7 as e7, sm.E8 as e8 from standard_manpower sm INNER JOIN cadre cd ON cd.sno=sm.cadre 
					INNER JOIN minesubtype_mixed ms ON sm.mcode=ms.mcode_mixed WHERE ms.mine_id = $mine_type AND 
					$tot_excavation > ms.plower_lim_OC AND $tot_excavation <= ms.pupper_lim_OC AND $tot_coal_UG > ms.plower_lim_UG AND $tot_coal_UG <= ms.pupper_lim_UG
				   ORDER BY cil_cadre ASC";
					 
				
				$resultx=$this->db->query($sqlx)->result_array();
				$result2=array();
				return array($resultx,$result2);
				}
				else
				{

					$var="SELECT a.production FROM mines a WHERE a.mine_id=$mine_name AND a.year_id=$year_name";
					$varx="SELECT a.tot_excavation_dept FROM mines a WHERE a.mine_id=$mine_name AND a.year_id=$year_name";
					$query=$this->db->query($var)->result_array();
					$queryx=$this->db->query($varx)->result_array();
			//echo $this->db->last_query();
			//print_r($query[0]['production']);exit();
					$production = $query[0]['production'];
					$tot_excavation_dept = $queryx[0]['tot_excavation_dept'];


			$cond = [
				'MS.mine_id'		=>	$mine_type,
				'MS.plower_lim <'	=>	$production,
				'MS.pupper_lim >='	=>	$production,
				'SM.status'         =>  "active",
			];
			$select_string1='CD.cil_cadre as cadre, SM.E1 as e1, SM.E2 as e2, SM.E3 as e3, SM.E4 as e4, SM.E5 as e5, SM.E6 as e6, SM.E7 as e7, SM.E8 as e8';
			$result1=$this->db->select($select_string1)->join('standard_manpower SM','MS.mcode=SM.mcode')->join('cadre CD','CD.sno=SM.cadre')->where($cond)->order_by('CD.cil_cadre', 'ASC')->get('minesubtype MS')->result_array();
			 //echo $this->db->last_query();die();

			//echo '<pre>';
			//print_r($result1);die();
			//echo '<\pre>';
			$sql="SELECT a.mcode from minesubtype a WHERE a.mine_id=$mine_type AND $production > a.plower_lim AND $production <= a.pupper_lim";
			$query=$this->db->query($sql)->result_array();
			//echo $this->db->last_query();die();
			$var1=$query[0]['mcode'];

			$sql2="SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) AS e4, SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 from standard_manpower_dynamic smd 
				INNER JOIN cadre cd
				ON cd.sno=smd.cadre
				WHERE smd.mcode=$var1 AND $production > smd.min_prod AND $production <=smd.max_prod GROUP BY cd.cil_cadre ORDER BY cd.cil_cadre";
			$result2=$this->db->query($sql2)->result_array();
			//echo $this->db->last_query();die();
			//echo '<pre>';
			//print_r($result2);die();
			//echo '<\pre>';

			return array($result1,$result2);
		}

		}

		public function get_home_table(){
			$mine_type=$this->input->post('submine');
			$production=$this->input->post('mine_production');
			$var4="SELECT mt.minecategory FROM minetype mt WHERE mt.mine_id=$mine_type";
			$mine_type_string=$this->db->query($var4)->result_array();
			$var1="SELECT a.mcode FROM minesubtype a WHERE a.plower_lim<=$production and a.pupper_lim>=$production AND a.mine_id=$mine_type";
			$query_search=$this->db->query($var1)->result_array();
			$result=$query_search[0]['mcode'];
			$sql="SELECT * FROM standard_manpower sm WHERE sm.mcode=$result";
			$query1=$this->db->query($sql)->result();
			$i=1;
			$main=array();
			foreach($query1 as $row)
			{
				$find=$row->cadre;
				$var2="SELECT c.cil_cadre FROM cadre c WHERE c.sno=$find";
				$query2=$this->db->query($var2)->result_array();	
				$main[$i]['cadre']=$query2[0]['cil_cadre'];
				$main[$i]['E1']=$row->E1;
				$main[$i]['E2']=$row->E2;
				$main[$i]['E3']=$row->E3;
				$main[$i]['E4']=$row->E4;
				$main[$i]['E5']=$row->E5;
				$main[$i]['E6']=$row->E6;
				$main[$i]['E7']=$row->E7;
				$main[$i]['E8']=$row->E8;
				$i++;

			}
			if($main==NULL)
			{$main[1]['cadre']=NULL;}
			$main[1]['production']=$production;
			$main[1]['mine_type']=$mine_type_string[0]['minecategory'];
			return $main;
		}
		
		public function get_compare_for_mine()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			$mine_name=$this->input->post('mine_name');
			$year_name=$this->input->post('year_name');
			$mine_type=$this->input->post('minecategory');
			$var="SELECT a.production FROM mines a WHERE a.mine_id=$mine_name AND a.year_id=$year_name";
			$varx="SELECT a.tot_excavation_dept FROM mines a WHERE a.mine_id=$mine_name AND a.year_id=$year_name";
			$query1=$this->db->query($var)->result_array();
			$queryx=$this->db->query($varx)->result_array();
			//echo $this->db->last_query();
			//print_r($query[0]['production']);exit();
			$production = $query1[0]['production'];
			$tot_excavation_dept = $queryx[0]['tot_excavation_dept'];

			$temp = $this->model_designation->get_minetype($mine_type);
			$minecategory = $temp[0]['minecategory'];

			if($minecategory=="Partly Departmental & Partly Outsourced Mechanized Opencast Mines")
			{
				$sqlx ="SELECT xz.cadre AS cadre, yz.e1 - xz.e1 AS newe1,yz.e2 - xz.e2 AS newe2,yz.e3 - xz.e3 AS newe3,yz.e4 - xz.e4 AS newe4, yz.e5 - xz.e5 AS newe5, yz.e6 - xz.e6 AS newe6, yz.e7 - xz.e7 AS newe7, yz.e8 - xz.e8 AS newe8
				FROM (SELECT * FROM (SELECT cd.cil_cadre AS cadre, sm.E1 as e1, sm.E2 as e2, sm.E3 as e3, sm.E4 as e4, sm.E5 as e5, sm.E6    as e6, sm.E7 as e7, sm.E8 as e8 from standard_manpower sm INNER JOIN cadre cd ON cd.sno=sm.cadre 
					INNER JOIN minesubtype ms ON sm.mcode=ms.mcode WHERE ms.mine_id = $mine_type AND 
					$tot_excavation_dept > ms.plower_lim AND $tot_excavation_dept <= ms.pupper_lim AND cd.cil_cadre 
					IN ('Excavation', 'E&M', 'MM')  UNION ALL 
					SELECT cd.cil_cadre AS cadre, sm.E1 as e1, sm.E2 as e2, sm.E3 as e3, sm.E4 as e4, sm.E5 as e5, sm.E6 as e6, sm.E7 as e7, sm.E8 as e8 from standard_manpower sm INNER JOIN cadre cd ON cd.sno=sm.cadre 
					INNER JOIN minesubtype ms ON sm.mcode=ms.mcode WHERE ms.mine_id = $mine_type AND 
					$production > ms.plower_lim AND $production <= ms.pupper_lim AND cd.cil_cadre NOT IN ('Excavation', 'E&M', 'MM')) as y GROUP BY y.cadre ORDER BY y.cadre) as xz
					INNER JOIN (SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
				existing_manpower em
				INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
				em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name AND em.mine_id=$mine_name AND em.year_id=$year_name  GROUP BY em.cadre ORDER BY cd.cil_cadre ASC)
				AS yz
				ON xz.cadre = yz.cadre";  
				
				$resultx=$this->db->query($sqlx)->result_array();

				$sql="SELECT a.mcode from minesubtype a WHERE a.mine_id=$mine_type AND $production > a.plower_lim AND $production <= a.pupper_lim";
			$query=$this->db->query($sql)->result_array();
			//echo $this->db->last_query();die();
			$var1=$query[0]['mcode'];

			$sql2="SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) AS e4, SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 from standard_manpower_dynamic smd 
				INNER JOIN cadre cd
				ON cd.sno=smd.cadre
				WHERE smd.mcode=$var1 AND $production > smd.min_prod AND $production <=smd.max_prod  GROUP BY cd.cil_cadre ORDER BY cd.cil_cadre";
			    $result2=$this->db->query($sql2)->result_array();
				
				//print_r($result2);die();
				return array($resultx,$result2);
				}
			else
			{
			$sql="SELECT xz.cadre AS cadre, yz.e1 - xz.e1 AS newe1,yz.e2 - xz.e2 AS newe2,yz.e3 - xz.e3 AS newe3,yz.e4 - xz.e4 AS newe4, yz.e5 - xz.e5 AS newe5, yz.e6 - xz.e6 AS newe6, yz.e7 - xz.e7 AS newe7, yz.e8 - xz.e8 AS newe8
				FROM (SELECT cd.cil_cadre AS cadre, sm.E1 AS e1, sm.E2 AS e2, sm.E3 AS e3, sm.E4 AS e4, sm.E5 AS e5, sm.E6 AS e6, sm.E7 AS e7, sm.E8 AS e8 FROM mines a
				INNER JOIN minesubtype b
				ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim
				INNER JOIN standard_manpower sm
				ON b.mcode = sm.mcode
				INNER JOIN cadre cd
				ON cd.sno = sm.cadre 
				WHERE a.mine_id=$mine_name AND a.year_id=$year_name AND a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name
				GROUP BY sm.cadre ORDER BY cd.cil_cadre ASC) AS xz
				INNER JOIN (SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
				existing_manpower em
				INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
				em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name AND em.mine_id=$mine_name AND em.year_id=$year_name  GROUP BY em.cadre ORDER BY cd.cil_cadre ASC)
				AS yz
				ON xz.cadre = yz.cadre";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();die();
			$sql1="SELECT a.mcode from minesubtype a WHERE a.mine_id=$mine_type AND $production > a.plower_lim AND $production <= a.pupper_lim";
			$query1=$this->db->query($sql1)->result_array();
			//echo $this->db->last_query();die();
			$var1=$query1[0]['mcode'];

			$sql2="SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) AS e4, SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 from standard_manpower_dynamic smd 
				INNER JOIN cadre cd
				ON cd.sno=smd.cadre
				WHERE smd.mcode=$var1 AND $production > smd.min_prod AND $production <=smd.max_prod  GROUP BY cd.cil_cadre ORDER BY cd.cil_cadre";
			$result2=$this->db->query($sql2)->result_array();
			return array($query,$result2);
		}
		}

		public function get_compare_for_subarea()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			$year_name=$this->input->post('year_name');

			$sql="SELECT xz.cadre AS cadre, yz.e1 - xz.e1 AS newe1,yz.e2 - xz.e2 AS newe2,yz.e3 - xz.e3 AS newe3,yz.e4 - xz.e4 AS newe4, yz.e5 - xz.e5 AS newe5, yz.e6 - xz.e6 AS newe6, yz.e7 - xz.e7 AS newe7, yz.e8 - xz.e8 AS newe8
				FROM (SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND   
					a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim  AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode  
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND 
				    a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
				    SELECT cd.cil_cadre as cadre, SUM(sos.E1) as e1, SUM(sos.E2) as e2, SUM(sos.E3) as e3, SUM(sos.E4) as e4, SUM(sos.E5) as e5, SUM(sos.E6) as e6, SUM(sos.E7) as e7, SUM(sos.E8) as e8 FROM
					subarea_office_standard sos 
					INNER JOIN cadre cd ON cd.sno=sos.cadre 
					INNER JOIN subarea a ON a.subarea_type=sos.subarea_type
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name GROUP BY sos.cadre UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines_mixed a
					INNER JOIN minesubtype_mixed b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode_mixed = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.tot_coal_UG > b.plower_lim_UG AND a.tot_coal_UG <= b.pupper_lim_UG AND a.tot_excavation > b.plower_lim_OC AND a.tot_excavation <= b.pupper_lim_OC GROUP BY sm.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre) AS xz
				INNER JOIN (SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			        (SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4,         SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					existing_manpower em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name  AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name  AND em.year_id=$year_name GROUP BY em.cadre
				) as y GROUP BY y.cadre ORDER BY y.cadre ASC)
				AS yz
				ON xz.cadre = yz.cadre";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}

		public function get_compare_for_subarea_office()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			$year_name=$this->input->post('year_name');

			$sql="SELECT xz.cadre AS cadre, yz.e1 - xz.e1 AS newe1,yz.e2 - xz.e2 AS newe2,yz.e3 - xz.e3 AS newe3,yz.e4 - xz.e4 AS newe4, yz.e5 - xz.e5 AS newe5, yz.e6 - xz.e6 AS newe6, yz.e7 - xz.e7 AS newe7, yz.e8 - xz.e8 AS newe8
				FROM (SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8, em.subarea_type as subarea_type FROM
					subarea_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subarea a ON a.subarea_type=em.subarea_type 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC) AS xz
				INNER JOIN (SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name  AND em.year_id=$year_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC)
				AS yz
				ON xz.cadre = yz.cadre";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}

		public function get_compare_for_area()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$year_name=$this->input->post('year_name');

			$sql="SELECT xz.cadre AS cadre, yz.e1 - xz.e1 AS newe1,yz.e2 - xz.e2 AS newe2,yz.e3 - xz.e3 AS newe3,yz.e4 - xz.e4 AS newe4, yz.e5 - xz.e5 AS newe5, yz.e6 - xz.e6 AS newe6, yz.e7 - xz.e7 AS newe7, yz.e8 - xz.e8 AS newe8
				FROM (SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND       a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim  AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name  AND a.year_id=$year_name AND a.mine_type = 2 AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode  
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND 
				    a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
                    SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN area a ON a.area_type=em.area_type 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subarea sa ON sa.subarea_type=em.subarea_type
					WHERE sa.sub_id=$sub_name AND sa.area_id=$area_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines_mixed a
					INNER JOIN minesubtype_mixed b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode_mixed = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND a.tot_coal_UG > b.plower_lim_UG AND a.tot_coal_UG <= b.pupper_lim_UG AND a.tot_excavation > b.plower_lim_OC AND a.tot_excavation <= b.pupper_lim_OC GROUP BY sm.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM RI_standard sm
			        INNER JOIN cadre cd ON cd.sno = sm.cadre
			        WHERE sm.area_id=$area_name GROUP BY sm.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre) AS xz
				INNER JOIN (SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
					(SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, 			SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					existing_manpower em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name  AND em.year_id=$year_name  GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name  AND em.year_id=$year_name GROUP BY em.cadre
				   ) as y GROUP BY y.cadre ORDER BY y.cadre ASC)
				AS yz
				ON xz.cadre = yz.cadre";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}

		public function get_compare_for_area_office()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$year_name=$this->input->post('year_name');

			$sql="SELECT xz.cadre AS cadre, yz.e1 - xz.e1 AS newe1,yz.e2 - xz.e2 AS newe2,yz.e3 - xz.e3 AS newe3,yz.e4 - xz.e4 AS newe4, yz.e5 - xz.e5 AS newe5, yz.e6 - xz.e6 AS newe6, yz.e7 - xz.e7 AS newe7, yz.e8 - xz.e8 AS newe8
				FROM (SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8, em.area_type as area_type FROM
					area_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN area a ON a.area_type=em.area_type 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC) AS xz
				INNER JOIN (SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
					area_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.year_id=$year_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC)
				AS yz
				ON xz.cadre = yz.cadre";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}

		public function get_compare_for_subsidiary()
		{
			$sub_name=$this->input->post('sub_name');
			$year_name=$this->input->post('year_name');

			$sql="SELECT xz.cadre AS cadre, yz.e1 - xz.e1 AS newe1,yz.e2 - xz.e2 AS newe2,yz.e3 - xz.e3 AS newe3,yz.e4 - xz.e4 AS newe4, yz.e5 - xz.e5 AS newe5, yz.e6 - xz.e6 AS newe6, yz.e7 - xz.e7 AS newe7, yz.e8 - xz.e8 AS newe8
				FROM (SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name  AND a.year_id=$year_name AND a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.sub_id=$sub_name  AND a.year_id=$year_name AND       a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim  AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name  AND a.year_id=$year_name AND a.mine_type = 2 AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode  
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND 
				    a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
				    SELECT cdr.cil_cadre as cadre, shs.E1 as e1, shs.E2 as e2, shs.E3 as e3, shs.E4 as e4, shs.E5 as e5, shs.E6 as e6, shs.E7 as e7, shs.E8 as e8 FROM
					subsidiary_hq_standard shs
					INNER JOIN cadre cdr ON cdr.sno=shs.cadre 
					INNER JOIN subsidiary a ON a.sub_id=shs.sub_id 
					WHERE a.sub_id=$sub_name GROUP BY shs.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subarea sa ON sa.subarea_type=em.subarea_type
					WHERE sa.sub_id=$sub_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN area sa ON sa.area_type=em.area_type
					WHERE sa.sub_id=$sub_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines_mixed a
					INNER JOIN minesubtype_mixed b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode_mixed = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND a.tot_coal_UG > b.plower_lim_UG AND a.tot_coal_UG <= b.pupper_lim_UG AND a.tot_excavation > b.plower_lim_OC AND a.tot_excavation <= b.pupper_lim_OC GROUP BY sm.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM RI_standard sm
			        INNER JOIN cadre cd ON cd.sno = sm.cadre
			        WHERE sm.area_id=$area_name GROUP BY sm.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre) AS xz
				INNER JOIN (SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM  (SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, 	SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					existing_manpower em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subsidiary_hq_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name  AND em.year_id=$year_name GROUP BY em.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre ASC)
				AS yz
				ON xz.cadre = yz.cadre";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}


		public function get_compare_for_subsidiary_hq()
		{
			$sub_name=$this->input->post('sub_name');
			$year_name=$this->input->post('year_name');

			$sql="SELECT xz.cadre AS cadre, yz.e1 - xz.e1 AS newe1,yz.e2 - xz.e2 AS newe2,yz.e3 - xz.e3 AS newe3,yz.e4 - xz.e4 AS newe4, yz.e5 - xz.e5 AS newe5, yz.e6 - xz.e6 AS newe6, yz.e7 - xz.e7 AS newe7, yz.e8 - xz.e8 AS newe8
				FROM (SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
					subsidiary_hq_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subsidiary a ON a.sub_id=em.sub_id 
					WHERE a.sub_id=$sub_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC) AS xz
				INNER JOIN (SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
					subsidiary_hq_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.year_id=$year_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC)
				AS yz
				ON xz.cadre = yz.cadre";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
		}
		public function get_existing_for_mine()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			$mine_name=$this->input->post('mine_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT cd.cil_cadre as cadre,em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as 
					e6, em.E7 as e7, em.E8 as e8 FROM
					existing_manpower em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name AND em.mine_id=$mine_name AND em.year_id=$year_name  GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}


		public function get_existing_for_subarea()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			        (SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4,         SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					existing_manpower em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name  AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name  AND em.year_id=$year_name GROUP BY em.cadre
				) as y GROUP BY y.cadre ORDER BY y.cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}

		public function get_existing_for_subarea_office()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.subarea_id=$subarea_name  AND em.year_id=$year_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}

		public function get_existing_for_area()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
					(SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, 			SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					existing_manpower em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name  AND em.year_id=$year_name  GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name  AND em.year_id=$year_name GROUP BY em.cadre
				   ) as y GROUP BY y.cadre ORDER BY y.cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}

		public function get_existing_for_area_office()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
					area_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.area_id=$area_name AND em.year_id=$year_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}
		public function get_existing_for_subsidiary()
		{
			$sub_name=$this->input->post('sub_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM  (SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, 	SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					existing_manpower em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre,SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subsidiary_hq_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name  AND em.year_id=$year_name GROUP BY em.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
			
		}

		public function get_existing_for_subsidiary_hq()
		{
			$sub_name=$this->input->post('sub_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
					subsidiary_hq_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.sub_id=$sub_name AND em.year_id=$year_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
		}

		public function get_existing_for_CIL()
		{
			//$sub_name=$this->input->post('sub_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM  (SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, 	SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					existing_manpower em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre,SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subsidiary_hq_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.year_id=$year_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
					em.year_id=$year_name GROUP BY em.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
		}


		public function get_existing_for_CIL_hq()
		{
			//$sub_name=$this->input->post('sub_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as    e6, em.E7 as e7, em.E8 as e8 FROM
					CIL_hq_existing em
					INNER JOIN cadre cd ON cd.sno=em.cadre WHERE
				    em.year_id=$year_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
		}


		public function get_standard_for_CIL()
		{
			$year_name = $this->input->post('year_name');


			$sql1 = "SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE  a.year_id=$year_name AND a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.year_id=$year_name AND       a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim  AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.year_id=$year_name AND a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.year_id=$year_name AND a.mine_type = 2 AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode  
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.year_id=$year_name AND 
				    a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
				    SELECT cdr.cil_cadre as cadre, SUM(shs.E1) as e1, SUM(shs.E2) as e2, SUM(shs.E3) as e3, SUM(shs.E4) as e4, SUM(shs.E5) as e5, SUM(shs.E6) as e6, SUM(shs.E7) as e7, SUM(shs.E8) as e8 FROM
					subsidiary_hq_standard shs
					INNER JOIN cadre cdr ON cdr.sno=shs.cadre 
					INNER JOIN subsidiary a ON a.sub_id=shs.sub_id 
				    GROUP BY shs.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subarea sa ON sa.subarea_type=em.subarea_type
				    GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN area sa ON sa.area_type=em.area_type
					GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines_mixed a
					INNER JOIN minesubtype_mixed b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode_mixed = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.year_id=$year_name AND a.tot_coal_UG > b.plower_lim_UG AND a.tot_coal_UG <= b.pupper_lim_UG AND a.tot_excavation > b.plower_lim_OC AND a.tot_excavation <= b.pupper_lim_OC GROUP BY sm.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM RI_standard sm
			        INNER JOIN cadre cd ON cd.sno=sm.cadre
			        GROUP BY sm.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre";


			$query=$this->db->query($sql1)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();

			// echo '<pre>';
			// print_r($query);die();
			// echo '<\pre>';
			return $query;
		}
		public function get_standard_for_CIL_hq()
		{
			//$sub_name=$this->input->post('sub_name');
			$year_name=$this->input->post('year_name');

			$sql=	"SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as    e6, em.E7 as e7, em.E8 as e8 FROM
					CIL_hq_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre
				    GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";
			$query=$this->db->query($sql)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
		}



		public function get_mine_for_subarea()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			$year_name=$this->input->post('year_name');


			$sql1= "SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND   
					a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim  AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode  
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND 
				    a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
				    SELECT cd.cil_cadre as cadre, SUM(sos.E1) as e1, SUM(sos.E2) as e2, SUM(sos.E3) as e3, SUM(sos.E4) as e4, SUM(sos.E5) as e5, SUM(sos.E6 ) as e6, SUM(sos.E7 ) as e7, SUM(sos.E8) as e8 FROM
					subarea_office_standard sos 
					INNER JOIN cadre cd ON cd.sno=sos.cadre 
					INNER JOIN subarea a ON a.subarea_type=sos.subarea_type 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name GROUP BY sos.cadre
					UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines_mixed a
					INNER JOIN minesubtype_mixed b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode_mixed = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.tot_coal_UG > b.plower_lim_UG AND a.tot_coal_UG <= b.pupper_lim_UG AND a.tot_excavation > b.plower_lim_OC AND a.tot_excavation <= b.pupper_lim_OC GROUP BY sm.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre";

			/*$sql1 =   "SELECT y.cadre AS cadre, SUM(y.e1) AS e1,SUM(y.e2) AS e2, SUM(y.e3) AS e3,SUM(y.e4) AS e4, SUM(y.e5) AS e5,SUM(y.e6) AS e6, SUM(y.e7) AS e7,SUM(y.e8) AS e8 FROM 
				    (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name  AND   
					a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim  AND a.production > smd.min_prod AND a.production <= smd.max_prod) AS y GROUP BY y.cadre ORDER BY y.cadre";

			$sql2 = "SELECT y.cadre AS cadre, SUM(y.e1) AS e1,SUM(y.e2) AS e2, SUM(y.e3) AS e3,SUM(y.e4) AS e4, SUM(y.e5) AS e5,SUM(y.e6) AS e6, SUM(y.e7) AS e7,SUM(y.e8) AS e8 FROM 
				  (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN  cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode  
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name AND a.year_id=$year_name AND 
				    a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND a.production > smd.min_prod AND a.production <= smd.max_prod) AS y GROUP BY y.cadre ORDER BY y.cadre";
			$query1=$this->db->query($sql1)->result_array();
			$query2=$this->db->query($sql2)->result_array();*/

			// echo '<pre>';
			// print_r($query2);die();
			//   echo '<\pre>';
			// print_r($query);die();
			// echo $this->db->last_query();
			// die();
			//return array($query1,$query2);
			$query=$this->db->query($sql1)->result_array();

			// echo '<pre>';
			//  print_r($query);die();
			//    echo '<\pre>';

			   return $query;

		}

		public function get_office_for_subarea()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$subarea_name=$this->input->post('subarea_name');
			//$year_name=$this->input->post('year_name');


		$sql1=	"SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8, em.subarea_type as subarea_type FROM
					subarea_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subarea a ON a.subarea_type=em.subarea_type 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.subarea_id=$subarea_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";


			$query=$this->db->query($sql1)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;


		}

		public function get_mine_for_area()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			$year_name=$this->input->post('year_name');
			

			/*$sql1= "SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.area_id=$area_name AND a.year_id=$year_name AND a.mine_type != 2
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode AND a.production > smd.min_prod AND a.production <= smd.max_prod 
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.mine_type != 2  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.area_id=$area_name AND a.year_id=$year_name AND a.mine_type = 2 AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.area_id=$area_name AND a.year_id=$year_name AND a.mine_type = 2 AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode AND a.production > smd.min_prod AND a.production <= smd.max_prod 
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.mine_type = 2) as y GROUP BY y.cadre ORDER BY y.cadre";*/

				    $sql1 = "SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND       a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim  AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name  AND a.year_id=$year_name AND a.mine_type = 2 AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode  
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND 
				    a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
                    SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN area a ON a.area_type=em.area_type 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subarea sa ON sa.subarea_type=em.subarea_type
					WHERE sa.sub_id=$sub_name AND sa.area_id=$area_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines_mixed a
					INNER JOIN minesubtype_mixed b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode_mixed = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name AND a.year_id=$year_name AND a.tot_coal_UG > b.plower_lim_UG AND a.tot_coal_UG <= b.pupper_lim_UG AND a.tot_excavation > b.plower_lim_OC AND a.tot_excavation <= b.pupper_lim_OC GROUP BY sm.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM RI_standard sm
			        INNER JOIN cadre cd ON cd.sno = sm.cadre
			        WHERE sm.area_id=$area_name GROUP BY sm.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre";


			$query=$this->db->query($sql1)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();

			//  echo '<pre>';
			// print_r($query);die();
			//  echo '<\pre>';



			return $query;


		}


		public function get_office_for_area()
		{
			$sub_name=$this->input->post('sub_name');
			$area_name=$this->input->post('area_name');
			//$year_name=$this->input->post('year_name');
			
			if($sub_name==9)
			{
				$sql1 = "SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM RI_standard sm
			        INNER JOIN cadre cd ON cd.sno = sm.cadre
			        WHERE sm.area_id=$area_name GROUP BY sm.cadre ORDER BY sm.cadre ASC";
			}
			else{
			$sql1=	"SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8, em.area_type as area_type FROM
					area_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN area a ON a.area_type=em.area_type 
					WHERE a.sub_id=$sub_name AND a.area_id=$area_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";
				}
			$query=$this->db->query($sql1)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;


		}

		public function get_mine_for_subsidiary()
		{
			$sub_name=$this->input->post('sub_name');
			$year_name=$this->input->post('year_name');
			

			/*$sql1= "SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND a.mine_type != 2
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode AND a.production > smd.min_prod AND a.production <= smd.max_prod 
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.mine_type != 2  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND a.mine_type = 2 AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND a.mine_type = 2 AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id AND a.production > b.plower_lim AND a.production <= b.pupper_lim 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode AND a.production > smd.min_prod AND a.production <= smd.max_prod 
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.mine_type = 2) as y GROUP BY y.cadre ORDER BY y.cadre";*/

				     $sql1 = "SELECT y.cadre AS cadre, SUM(y.e1) AS e1, SUM(y.e2) AS e2, SUM(y.e3) AS e3, SUM(y.e4) AS e4,
			        SUM(y.e5) AS e5, SUM(y.e6) AS e6, SUM(y.e7) AS e7, SUM(y.e8) AS e8 FROM 
			       (SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name  AND a.year_id=$year_name AND a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim
					GROUP BY sm.cadre  UNION ALL 
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre 
					WHERE a.sub_id=$sub_name  AND a.year_id=$year_name AND       a.mine_type != 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim  AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND cd.cil_cadre NOT IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines a
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower sm
					ON b.mcode = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name  AND a.year_id=$year_name AND a.mine_type = 2 AND a.tot_excavation_dept > b.plower_lim AND a.tot_excavation_dept <= 
					b.pupper_lim AND cd.cil_cadre IN 
					('Excavation','E&M','MM')
					GROUP BY sm.cadre  UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(smd.E1) AS e1, SUM(smd.E2) AS e2, SUM(smd.E3) AS e3, SUM(smd.E4) 
					AS e4, 
					SUM(smd.E5) AS e5, SUM(smd.E6) AS e6, SUM(smd.E7) AS e7, SUM(smd.E8) AS e8 FROM mines a 
					INNER JOIN minesubtype b
					ON a.mine_type = b.mine_id 
					INNER JOIN standard_manpower_dynamic smd
					ON b.mcode = smd.mcode  
					INNER JOIN cadre cd
					ON cd.sno = smd.cadre
				    WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND 
				    a.mine_type = 2 AND a.production > b.plower_lim AND a.production <= b.pupper_lim AND a.production > smd.min_prod AND a.production <= smd.max_prod GROUP BY smd.cadre UNION ALL
				    SELECT cdr.cil_cadre as cadre, shs.E1 as e1, shs.E2 as e2, shs.E3 as e3, shs.E4 as e4, shs.E5 as e5, shs.E6 as e6, shs.E7 as e7, shs.E8 as e8 FROM
					subsidiary_hq_standard shs
					INNER JOIN cadre cdr ON cdr.sno=shs.cadre 
					INNER JOIN subsidiary a ON a.sub_id=shs.sub_id 
					WHERE a.sub_id=$sub_name GROUP BY shs.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					subarea_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subarea sa ON sa.subarea_type=em.subarea_type
					WHERE sa.sub_id=$sub_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre as cadre, SUM(em.E1) as e1, SUM(em.E2) as e2, SUM(em.E3) as e3, SUM(em.E4) as e4, SUM(em.E5) as e5, SUM(em.E6) as e6, SUM(em.E7) as e7, SUM(em.E8) as e8 FROM
					area_office_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN area sa ON sa.area_type=em.area_type
					WHERE sa.sub_id=$sub_name GROUP BY em.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM mines_mixed a
					INNER JOIN minesubtype_mixed b
					ON a.mine_type = b.mine_id  
					INNER JOIN standard_manpower sm
					ON b.mcode_mixed = sm.mcode
					INNER JOIN cadre cd
					ON cd.sno = sm.cadre 
					WHERE a.sub_id=$sub_name AND a.year_id=$year_name AND a.tot_coal_UG > b.plower_lim_UG AND a.tot_coal_UG <= b.pupper_lim_UG AND a.tot_excavation > b.plower_lim_OC AND a.tot_excavation <= b.pupper_lim_OC GROUP BY sm.cadre UNION ALL
					SELECT cd.cil_cadre AS cadre, SUM(sm.E1) AS e1, SUM(sm.E2) AS e2, SUM(sm.E3) AS e3, SUM(sm.E4) AS e4, 
			        SUM(sm.E5) AS e5, SUM(sm.E6) AS e6, SUM(sm.E7) AS e7, SUM(sm.E8) AS e8 FROM RI_standard sm
			        INNER JOIN area a ON a.area_id=sm.area_id
			        INNER JOIN cadre cd ON cd.sno=sm.cadre
			        WHERE a.sub_id=$sub_name GROUP BY sm.cadre
				    ) as y GROUP BY y.cadre ORDER BY y.cadre";


			$query=$this->db->query($sql1)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();

			// echo '<pre>';
			// print_r($query);die();
			// echo '<\pre>';
			return $query;


		}


		public function get_hq_for_subsidiary()
		{

			$sub_name=$this->input->post('sub_name');
			//$area_name=$this->input->post('area_name');
			//$year_name=$this->input->post('year_name');
			

			$sql1=	"SELECT cd.cil_cadre as cadre, em.E1 as e1, em.E2 as e2, em.E3 as e3, em.E4 as e4, em.E5 as e5, em.E6 as e6, em.E7 as e7, em.E8 as e8 FROM
					subsidiary_hq_standard em
					INNER JOIN cadre cd ON cd.sno=em.cadre 
					INNER JOIN subsidiary a ON a.sub_id=em.sub_id 
					WHERE a.sub_id=$sub_name GROUP BY em.cadre ORDER BY cd.cil_cadre ASC";

			$query=$this->db->query($sql1)->result_array();
			//print_r($query);die();
			//echo $this->db->last_query();
			//die();
			return $query;
		}

		public function prev_standard_data($standard_id){
			$res=$this->db->where('sno', $standard_id)
			->get('std_mine_data')
			->result_array();
			//print_r($res[0]);
			//die();
			return $res[0];
		}

		public function update_data_standard($data){
			$this->db->set($data)
			->where('sno', $data['sno'])
			->update('std_mine_data', $data);
		}

		public function get_filter_values($mine_code,$mine_prod){
			$mine_type = $mine_code;
			 $production = $mine_prod;

			//exit;
			$cond = [
				'MS.mine_id'		=>	$mine_type,
				'MS.plower_lim <'	=>	$production,
				'MS.pupper_lim >='	=>	$production,
			];
		$select_string = 'CD.cil_cadre as cadre,  DS.grade, (select SUM(SM.no_of_emp)) as sum , SM.info';
			$cond1 = 'cadre, DS.grade';
			$results = $this->db->select($select_string)->join('std_mine_data SM','MS.mcode = SM.mcode')->join('department DP','DP.sno = SM.department')->join('cadre CD','CD.sno = SM.cadre')->join('designation DS','DS.sno = SM.grade')->where($cond)->group_by($cond1)->get('minesubtype MS')->result_array();
			 //echo $this->db->last_query();
			 //die();
			//print_r($results); exit;
			return $results;
		}

		public function get_std_values($mine_code,$mine_prod){
			$mine_type = $mine_code;
			 $production = $mine_prod;
			$cond = [
				'MS.mine_id'		=>	$mine_type,
				'MS.plower_lim <'	=>	$production,
				'MS.pupper_lim >='	=>	$production,
			];
			$select_string = 'SM.sno, SM.mcode as mine_id ,SM.department, SM.scopeofwork, CD.cil_cadre as cadre, DS.grade, SM.no_of_emp, SM.info, DP.department as dept_name';

			$results = $this->db->select($select_string)->join('std_mine_data SM','MS.mcode = SM.mcode')->join('department DP','DP.sno = SM.department')->join('cadre CD','CD.sno = SM.cadre')->join('designation DS','DS.sno = SM.grade')->where($cond)->get('minesubtype MS')->result_array();
			 //echo $this->db->last_query();
			// die();
			return $results;
		}

		public function redirectUser(){
			$userType = $this->session->userdata('userType');
			// var_dump($userType);
			// die();
			if($userType === "0"){
		      redirect("Mines");
			}
			redirect("Pages/match_data");
		}



		public function get_value_to_match($mine_type, $dept, $cad, $grd)
		{   

			$result =$this->db->select('no_of_emp')->join('cadre CD','CD.sno = SM.cadre')->join('designation DD','DD.sno = SM.grade')->where(['SM.mcode'=> $mine_type , 'SM.department'=>$dept ,'CD.cil_cadre'=> $cad, 'DD.grade'=>$grd])->get('std_mine_data SM')->result_array()[0]['no_of_emp'];
			//echo $this->db->last_query();
			return $result; 
		}

		public function get_department_from_code($dept)
		{
			$result =$this->db->select('department')->where('sno' , $dept)->get('department')->result_array()[0]['department'];
			#dump($result);
			#dump($this->db->last_query());
			return $result;

		}

		public function get_minetype_from_code($mine_type)
		{
			$result = $this->db->select('minecategory ,munit')->where('mine_id' , $mine_type)->get('minetype')->result_array();
			//dump($this->db->last_query());
			//dump($result);
			 return $result;
		}

		public function get_subsidiary($sub_name)
		{
			$result = $this->db->select('sub_name')->where('sub_id' , $sub_name)->get('subsidiary')->result_array();
			//dump($this->db->last_query());
			//dump($result);
			 return $result;
		}

		public function get_area($area_name)
		{
			$result = $this->db->select('area_name')->where('area_id' , $area_name)->get('area')->result_array();
			//dump($this->db->last_query());
			//dump($result);
			 return $result;
		}

		public function get_subarea($subarea_name)
		{
			$result = $this->db->select('subarea_name')->where('subarea_id' , $subarea_name)->get('subarea')->result_array();
			//dump($this->db->last_query());
			//dump($result);
			 return $result;
		}

		public function get_mine($mine_name)
		{
			$result = $this->db->select('mine_name')->where('mine_id' , $mine_name)->get('mines')->result_array();
			if(empty($result))
			{
				$result = $this->db->select('mine_name')->where('mine_id' , $mine_name)->get('mines_mixed')->result_array();
			}
			//dump($this->db->last_query());
			//dump($result);
			 return $result;
		}
		public function get_production($mine_name,$year_name)
		{
			$result = $this->db->select('production')->where(['mine_id' => $mine_name,'year_id'=>$year_name])->get('mines')->result_array();
			if(empty($result))
			{
				$result1 = $this->db->select('tot_coal_UG,tot_excavation')->where(['mine_id' => $mine_name,'year_id'=>$year_name])->get('mines_mixed')->result_array();
				//print_r($result1);exit;

				$result = array(array('production' => ($result1[0]['tot_coal_UG'])/1.5 + $result1[0]['tot_excavation']));
				//print_r($result);exit;
			}
			//dump($this->db->last_query());
			//dump($result);
			 return $result;
		}
		public function get_year($year_name)
		{
			$result = $this->db->select('year_name')->where('year_id' , $year_name)->get('year')->result_array();
			//dump($this->db->last_query());
			//dump($result);
			 return $result;
		}  

		public function get_minetype($mine_type)
		{
			$result = $this->db->select('minecategory,munit')->where('mine_id' , $mine_type)->get('minetype')->result_array();
			//dump($this->db->last_query());
			//dump($result);
			 return $result;
		} 

		public function get_department_for_excel()
		{
			$result = $this->db->select('department' )->order_by('department')->get('department')->result_array();
			return $result;
		}

		public function get_cadre_for_excel()
		{
			$result = $this->db->select('cil_cadre' )->order_by('cil_cadre')->get('cadre')->result_array();
			return $result;
		}

		public function get_grade_for_excel()
		{
			$result = $this->db->select('grade' )->order_by('grade')->get('designation')->result_array();
			return $result;
		}

		public function get_values_for_excel($mine_type,$production){
			$cond = [
				'MS.mine_id'		=>	$mine_type,
				'MS.plower_lim <'	=>	$production,
				'MS.pupper_lim >='	=>	$production,
			];
			$select_string = 'SM.mcode as mine_id ,SM.department, SM.scopeofwork, CD.cil_cadre as cadre, DS.grade, SM.no_of_emp, SM.info, DP.department as dept_name';

			$results = $this->db->select($select_string)->join('std_mine_data SM','MS.mcode = SM.mcode')->join('department DP','DP.sno = SM.department')->join('cadre CD','CD.sno = SM.cadre')->join('designation DS','DS.sno = SM.grade')->where($cond)->get('minesubtype MS')->result_array();
			 //echo $this->db->last_query();
			//die();
			return $results;
		}


		public function get_values_for_excel_filter($mine_type,$production){
			$cond = [
				'MS.mine_id'		=>	$mine_type,
				'MS.plower_lim <'	=>	$production,
				'MS.pupper_lim >='	=>	$production,
			];
			$select_string = 'CD.cil_cadre as cadre,  DS.grade, (select SUM(SM.no_of_emp)) as sum , SM.info';
			$cond1 = 'cadre, DS.grade';
			$results = $this->db->select($select_string)->join('std_mine_data SM','MS.mcode = SM.mcode')->join('department DP','DP.sno = SM.department')->join('cadre CD','CD.sno = SM.cadre')->join('designation DS','DS.sno = SM.grade')->where($cond)->group_by($cond1)->get('minesubtype MS')->result_array();
			// echo $this->db->last_query();
			//die();
			return $results;
		}

		public function insertcsv($data)
 		{
  			$this->db->insert_batch('standard_manpower', $data);
  			//echo $this->db->last_query(); die();
 		}


		public function insertcsv_dynamic($data)
 		{
  			$this->db->insert_batch('standard_manpower_dynamic', $data);
  			//echo $this->db->last_query(); die();
 		}


 		public function insert_CIL_hq($data)
 		{
 			$this->db->insert_batch('CIL_hq_standard', $data);
 		}


 		public function insert_subsidiary_hq($data)
 		{
 			$this->db->insert_batch('subsidiary_hq_standard', $data);
 		}


 		public function insert_area_office($data)
 		{
  			$this->db->insert_batch('area_office_standard', $data);
  			//echo $this->db->last_query(); die();
 		}


 		public function insert_RI($data)
 		{
  			$this->db->insert_batch('RI_standard', $data);
  			//echo $this->db->last_query(); die();
 		}



 		public function insert_subarea_office($data)
 		{
  			$this->db->insert_batch('subarea_office_standard', $data);
  			//echo $this->db->last_query(); die();
 		}



 		public function get_dept_std_import($dept)
 		{
 			$this->db->select('sno');
 			$this->db->from('department');
 			$this->db->where('department',$dept);
 			$res=$this->db->get();
 			return $res->result_array();
 		}
 		public function get_cadre_std_import($cadre)
 		{
 			$this->db->select('sno');
 			$this->db->from('cadre');
 			$this->db->where('cil_cadre',$cadre);
 			$res=$this->db->get();
 			return $res->result_array();
 		}
 		public function get_grade_std_import($grade,$discipline)
 		{
 			$cond = [
				'grade'		=>	$grade,
				'discipline'	=>	$discipline,
			];
 			$this->db->select('sno');
 			$this->db->from('designation');
 			$this->db->where($cond);
 			$res=$this->db->get();
 			return $res->result_array();
 		}


 		public function insert_mine_csv($data)
 		{
  			$this->db->insert_batch('mines', $data);
  			//echo $this->db->last_query(); die();
 		}

 			public function insert_mine_mixed_csv($data)
 		{
  			$this->db->insert_batch('mines_mixed', $data);
  			//echo $this->db->last_query(); die();
 		}

 		public function insert_area_csv($data)
 		{
  			$this->db->insert_batch('area', $data);
  			//echo $this->db->last_query(); die();
 		}

 		public function insert_subarea_csv($data)
 		{
  			$this->db->insert_batch('subarea', $data);
  			//echo $this->db->last_query(); die();
 		}



 		public function insert_CIL_hq_existing_manpower($data)
 		{
 				$this->db->insert_batch('CIL_hq_existing', $data);
 		}



 		public function insert_subsidiary_hq_existing_manpower($data)
 		{
 				$this->db->insert_batch('subsidiary_hq_existing', $data);
 		}


 		public function insert_area_office_existing_manpower($data)
 		{
 			$this->db->insert_batch('area_office_existing', $data);
 		}

 		public function insert_subarea_office_existing_manpower($data)
 		{
 			$this->db->insert_batch('subarea_office_existing', $data);
 		}

 		public function insert_existing_manpower($data)
 		{
  			$this->db->insert_batch('existing_manpower', $data);
  			//echo $this->db->last_query(); die();
 		}

 		public function get_subsidiary_import($sub_name)
 		{
 			$this->db->select('sub_id');
 			$this->db->from('subsidiary');
 			$this->db->where('sub_name',$sub_name);
 			$res=$this->db->get();
 			return $res->result_array();
 		}

 		public function get_area_import($area_name)
 		{
 			$this->db->select('area_id');
 			$this->db->from('area');
 			$this->db->where('area_name',$area_name);
 			$res=$this->db->get();
 			return $res->result_array();
 		}

 		public function get_subarea_import($subarea_name)
 		{
 			$this->db->select('subarea_id');
 			$this->db->from('subarea');
 			$this->db->where('subarea_name',$subarea_name);
 			$res=$this->db->get();
 			return $res->result_array();
 		}

 		public function get_minetype_import($minetyp)
 		{
 			$this->db->select('mine_id');
 			$this->db->from('minetype');
 			$this->db->where('minecategory',$minetyp);
 			$res=$this->db->get();
 			return $res->result_array();
 		}

 		public function get_year_import($year_name)
 		{
 			$this->db->select('year_id');
 			$this->db->from('year');
 			$this->db->where('year_name',$year_name);
 			$res=$this->db->get();
 			return $res->result_array();
 		}
 		public function fetch_mineid($mine_type)
 		{

 			//echo $mine_type;

 			$this->db->select('mine_id');
 			$this->db->from('minetype');
 			$this->db->where('minecategory',$mine_type);
 			$query = $this->db->get();

 			//echo $query;

 			//exit();

 			return $query->result_array();



 			//echo $this->db->last_query(); die();

 		}


 		public function fetch_year()
		{
			  $this->db->order_by("year_name", "ASC");
			  $query = $this->db->get("year");
			  return $query->result();
		}


		public function fetch_minetype()
		{
			  $this->db->order_by("mine_id", "ASC");
			  $query = $this->db->get("minetype");
			  return $query->result();
		}

 		public function fetch_subsidiary()
		{
			  $this->db->order_by("sub_name", "ASC");
			  $query = $this->db->get("subsidiary");
			  return $query->result();
		}

		public function fetch_area($sub_id)
		{
			  $this->db->where('sub_id', $sub_id);
			  $this->db->order_by('area_name', 'ASC');
			  $query = $this->db->get('area');
			  $output = '<option value="">Select Area</option>';
			  foreach($query->result() as $row)
			  {
			   $output .= '<option value="'.$row->area_id.'">'.$row->area_name.'</option>';
			  }
			  return $output;
		}

		public function fetch_subarea($area_id)
		{
			  $this->db->where('area_id', $area_id);
			  $this->db->order_by('subarea_name', 'ASC');
			  $query = $this->db->get('subarea');
			  $output = '<option value="">Select Subarea</option>';
			  foreach($query->result() as $row)
			  {
			   $output .= '<option value="'.$row->subarea_id.'">'.$row->subarea_name.'</option>';
			  }
			  return $output;
		}


		public function fetch_year_id_new($mine_id)
		{

			//$sql = "select `year_id` and `year_name` from `mines` where `mine_id`=".$mine_id;

			$sql = "SELECT `year`.`year_id` , `year`.`year_name` from `mines` INNER JOIN `year` ON `mines`.year_id = `year`.year_id where `mine_id`=".$mine_id;

			$query = $this->db->query($sql);


			$sql1 = "SELECT `year`.`year_id` , `year`.`year_name` from `mines_mixed` INNER JOIN `year` ON `mines_mixed`.year_id = `year`.year_id where `mine_id`=".$mine_id;

			$query1 = $this->db->query($sql1);

			//echo $this->

			// //$query = $query->result_array();

			// echo $query['0']['year_id'];
			//echo $this->db->last_query(); die();

			foreach($query->result() as $row)
			{
			 $output .= '<option value="'.$row->year_id.'">'.$row->year_name.'</option>';
			}
			foreach($query1->result() as $row)
			{
			 $output .= '<option value="'.$row->year_id.'">'.$row->year_name.'</option>';
			}
			return $output;


		}

		public function fetch_mines($subarea_id)
		{
			//   $this->db->where('subarea_id', $subarea_id);
			//   $this->db->order_by('mine_name', 'ASC');
			//   $query = $this->db->get('mines');

				$sql = "SELECT * , `year`.year_name as Year_name , concat(mine_name , ' (Year ' , `year`.year_name , ')') as Mine
				FROM `mines` inner join `year` on `mines`.year_id = `year`.year_id WHERE `subarea_id` = $subarea_id 
				ORDER BY `mine_name` ASC , Year_name ASC";

				$query = $this->db->query($sql);


				$sql1 = "SELECT * , `year`.year_name as Year_name , concat(mine_name , ' (Year ' , `year`.year_name , ')') as Mine
				FROM `mines_mixed` inner join `year` on `mines_mixed`.year_id = `year`.year_id WHERE `subarea_id` = $subarea_id 
				ORDER BY `mine_name` ASC , Year_name ASC";

				$query1 = $this->db->query($sql1);


			  //echo $this->db->last_query(); die(); 
			  $output = '<option value="">Select Mines</option>';
			  foreach($query->result() as $row)
			  {
			   $output .= '<option value="'.$row->mine_id.'">'.$row->Mine.'</option>';
			  }

			   foreach($query1->result() as $row)
			  {
			   $output .= '<option value="'.$row->mine_id.'">'.$row->Mine.'</option>';
			  }
			  return $output;
		}

		public function fetch_minetype_new($mine_id)
		{
			$this->db->join('minetype','minetype.mine_id=mines.mine_type');
			$this->db->where('mines.mine_id',$mine_id);
			$query = $this->db->get('mines');

			$this->db->join('minetype','minetype.mine_id=mines_mixed.mine_type');
			$this->db->where('mines_mixed.mine_id',$mine_id);
			$query1 = $this->db->get('mines_mixed');
			$output = '<option value="">Select Mine Type</option>';
			foreach($query->result() as $row)
			  {
			   $output .= '<option value="'.$row->mine_id.'">'.$row->minecategory.'('.$row->munit.')</option>';
			  }
			  foreach($query1->result() as $row)
			  {
			   $output .= '<option value="'.$row->mine_id.'">'.$row->minecategory.'('.$row->munit.')</option>';
			  }
			  return $output;
		}
		public function fetch_lower_lim($mine_id)
		{
			  $this->db->select('plower_lim');
			  $this->db->where('mine_id', $mine_id);
			  $this->db->order_by('plower_lim', 'ASC');
			  $query = $this->db->get('minesubtype');
			  //echo $this->db->last_query();die();
			  //print_r($query->result_array());
			  $output = '<option value="">Select Lower Limit</option>';
			  foreach($query->result() as $row)
			  {
			   $output .= '<option value="'.$row->plower_lim.'">'.$row->plower_lim.'</option>';
			  }
			  return $output;
		}

		public function fetch_upper_lim($LL)
		{
			  $this->db->distinct();
			  $this->db->select('pupper_lim');
			  $this->db->where('plower_lim', $LL);
			  $this->db->order_by('pupper_lim', 'ASC');
			  $query = $this->db->get('minesubtype');
			  $output = '<option value="">Select Upper Limit</option>';
			  foreach($query->result() as $row)
			  {
			   $output .= '<option value="'.$row->pupper_lim.'">'.$row->pupper_lim.'</option>';
			  }
			  return $output;
		}

		public function fetch_mcode($mine_type,$lower_lim,$upper_lim)
		{
			$sql="SELECT a.mcode from minesubtype a WHERE a.mine_id=$mine_type AND $lower_lim=a.plower_lim AND $upper_lim = a.pupper_lim";
			$query=$this->db->query($sql)->result_array();
			//echo $this->db->last_query();
			 //die();
			return $query;
		}


		public function all_year()
		{
			  $this->db->order_by("year_name", "ASC");
			  $query = $this->db->get("year");
			  return $query->result_array();
		}


		public function all_minetype()
		{
			  $this->db->order_by("mine_id", "ASC");
			  $query = $this->db->get("minetype");
			  return $query->result_array();
		}
		public function all_cadre()
		{
			  $this->db->order_by("cil_cadre", "ASC");
			  $query = $this->db->get("cadre");
			  return $query->result_array();
		}

		public function insert_std_dynamic_data($data, $table){
			$this->db->insert($table, $data);
		}
	};
	?>