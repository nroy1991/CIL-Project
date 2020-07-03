<?php
	class Model_allmines extends CI_Model{
		function __construct(){
			parent::__construct();	//call the model contructor
		}

		//returns the list of all the cadres
		public function all_allmines(){

            $select_string='mines.mine_id,subsidiary.sub_name,area.area_name,subarea.subarea_name,mines.mine_name,minetype.minecategory,year.year_name,mines.SR,mines.coal_dept,mines.coal_out,mines.tot_coal,mines.OBR_dept,mines.OBR_out,mines.tot_OBR,mines.tot_excavation_dept,mines.tot_excavation_out,mines.tot_excavation,mines.production';
            $allmines=$this->db->select($select_string)->join('subsidiary','subsidiary.sub_id = mines.sub_id')->join('area','area.area_id = mines.area_id')->join('subarea','subarea.subarea_id = mines.subarea_id')->join('minetype','minetype.mine_id=mines.mine_type')->join('year','year.year_id=mines.year_id')->order_by('subsidiary.sub_name','ASC')->order_by('area.area_name','ASC')->order_by('subarea.subarea_name','ASC')->order_by('mines.mine_name','ASC')->order_by('mines.year_id','ASC')->get('mines')->result_array();
            return $allmines;
        }


        public function all_allmines_mixed(){

            $select_string='mines_mixed.mine_id,subsidiary.sub_name,area.area_name,subarea.subarea_name,mines_mixed.mine_name,minetype.minecategory,year.year_name,mines_mixed.SR,mines_mixed.coal_dept_UG,mines_mixed.coal_out_UG,mines_mixed.tot_coal_UG,mines_mixed.coal_dept_OC,mines_mixed.coal_out_OC,mines_mixed.tot_coal_OC,mines_mixed.OBR_dept,mines_mixed.OBR_out, mines_mixed.tot_OBR,mines_mixed.tot_excavation_dept,mines_mixed.tot_excavation_out,mines_mixed.tot_excavation,mines_mixed.tot_coal_UG_OC';
            $allmines=$this->db->select($select_string)->join('subsidiary','subsidiary.sub_id = mines_mixed.sub_id')->join('area','area.area_id = mines_mixed.area_id')->join('subarea','subarea.subarea_id = mines_mixed.subarea_id')->join('minetype','minetype.mine_id=mines_mixed.mine_type')->join('year','year.year_id=mines_mixed.year_id')->order_by('subsidiary.sub_id','ASC')->order_by('area.area_name','ASC')->order_by('subarea.subarea_name','ASC')->order_by('mines_mixed.mine_name','ASC')->order_by('mines_mixed.year_id','ASC')->get('mines_mixed')->result_array();
            return $allmines;
        }



		public function mine_name($mine_id){
			return $this->db->where('mine_id', $mine_id)
							->get('mines')
							->result_array()[0];
		}

		public function insert_data($data, $table){
			$this->db->insert($table, $data);
		}

		public function update_subsidiary($sub_id, $sub_name){
			$this->db->where('sub_id', $sub_id)
					 ->update('subsidiary', array('sub_name'=> $sub_name));
		}


		 public function delete_allmine($mine_id){
		 	$this->db->where('mine_id', $mine_id)
		 			 ->delete('mines');
		 }
	};
?>