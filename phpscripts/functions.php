<?php

/*function getvariantsnumber($type,$gene) {
	   global $db,$config;
		 $result=$this->db->select("SELECT count(Variant_Classification) count_t  FROM ".$config['db']['pre']."ESCC_SNV_Discription where Hugo_Symbol='".$gene."' and where Variant_Classification='".$type."'");
		 $number=$result['count_t'];
		 return $number;
 }
*/
function  get_num($table,$keys = "")
{
		  global $db,$config;
		  $table = $config['db']['pre'].$table;
		  $sql = "SELECT COUNT(*) AS count_num FROM ".$table;
		  if(!empty($keys))
		  {
			$array = array();
			foreach($keys as $key => $value)
			  $array[] = $key." = '".$value."'";
			$where = implode(" and ",$array);
			$sql .= " WHERE ".$where;
			//return $sql;
		  }
		  $result = $db->select($sql);
		  $result = $result ? $result[0]['count_num'] : 0;
		  return $sql;
		/* if(!$result)
			return 0;
		  return $result[0]['count_num'];*/
}

function  get_sum($table,$field,$keys = "",$method = 'a')
{
		  global $db,$config;
		  $table = $config['db']['pre'].$table;
		  $sql = "SELECT sum(`".$field."`) AS count_num FROM ".$table;
		  if(!empty($keys)){
		    if($method == 'a'){
			  $array = array();
			  foreach($keys as $key => $value)
			    $array[] = $key." = '".$value."'";
			  $where = implode(" and ",$array);
			  $sql .= " WHERE ".$where;
		    }
			else{
			  $sql .= " WHERE ".implode(' and ',$keys);
			}
		  }
		  $result = $db->select($sql);
		  if(!$result)
			return 0;
		  return $result[0]['count_num'];
}
?>
