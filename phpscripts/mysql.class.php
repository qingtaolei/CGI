<?php
class c_mysql{
           protected $conn;
	   protected $dbconfig;
           function __construct(){
	           global $config;
		   $this->dbconfig = $config['db'];
                   for($i = 0;$i < 10;$i++){
                   $conn = @mysql_pconnect($this->dbconfig['hostname'],$this->dbconfig['username'],$this->dbconfig['password']);
		 if($conn)
                 if(mysql_select_db($this->dbconfig['datebase'])){
	         $this->conn = $conn;
	         mysql_query("SET character_set_connection=".$this->dbconfig['charset'].", character_set_results=".$this->dbconfig['charset'].", character_set_client=utf8;");
				 break;
		   }
		  if($i == 9)
		   exit("数据库连接失败。");
		   }
	}

         function getvariantsnumber($cancer,$type,$gene) {
            global $config;
         		 $sql="SELECT count(*) count_t FROM( SELECT * FROM ".$cancer."_SNV_Discription where Hugo_Symbol='".$gene."' and Variant_Classification='".$type."') a";
             $result = $this->select($sql);
             if(!$result){
             echo mysql_error();
               return false;
             }
             $number=$result[0]['count_t'];
         		 return $number;
          }

			   function sql($sql){
				           return mysql_query($sql,$this->conn);
			   }

			   function insert($sql = ""){
				  // echo $sql.'<br />';
			               if(empty($sql) or !$this->conn)
						     return false;
			               $result = mysql_query($sql,$this->conn);
						   if(!$result){
							 echo mysql_error();
						     return false;
						   }
						   $insert_id = mysql_insert_id($this->conn);
						   if($insert_id)
						     return $insert_id;
						   return true ;
			   }

			   function select($sql = ""){
				   //获得并且答应$sql中的每一条记录
				    // echo $sql."<br />";
			               if(empty($sql) or !$this->conn)
						     return false;
						   $result = mysql_query($sql);
						   if(!$result)
						     return false;
						   $count = 0;
						   $date = array();
						   while($row = mysql_fetch_array($result))
						     $date[$count++] = $row;
						   mysql_free_result($result);
						   return $date;
			   }


			   function update($sql){
				   //echo $sql;
			               if(empty($sql) or !$this->conn)
						     return false;
						   return mysql_query($sql);

			   }

			   function delete($sql){
			               if(empty($sql) or !$this->conn)
						     return false;
						   return mysql_query($sql);
			   }

			   function insert_date($table,$date){
						   $table = $this->dbconfig['pre'].$table;
			               $keys = array();
			               foreach($date as $key => $value)
						     $keys[] = "`".$key."`='".$value."'";
						   $keys = implode(", ",$keys);
						   $sql = "INSERT INTO ".$table." SET ".$keys;
						   return $this->insert($sql);
			   }

			   function select_date($table,$keys = "",$fields = "",$limit = "",$ord = "",$sort = "DESC"){
				   //从数据库中筛选数据
			               $where = "";
						   $table = $this->dbconfig['pre'].$table;
			               if(is_array($keys))
						     if(!empty($keys)){
							   $array = array();
							   foreach($keys as $key => $value)
							     $array[] = "`".$key."` = '".$value."'";
							   $where = implode(" and ",$array);
							   $where = " WHERE ".$where;
							 }
						   if($fields == "")
						     $fields = "*";
						   $sql = "SELECT ".$fields." FROM ".$table.$where;
						   if($ord != "")
						     $sql .= " ORDER BY ".$ord." ".$sort;
						   if($limit != "")
						     $sql .= " LIMIT ".$limit;
						   $result = $this->select($sql);
						   if(empty($result))
						     return false;
						   return $result;
			   }

			   function field_stat($table,$f = "",$k = ""){
							$sql_stat ="";
							$table = $this->$config['db']['pre'].$table;
							$sql_stat .="SELECT  COUNT(*) AS count_num FROM ".$table." WHERE ".$f."='".$k."'";
							echo $sql_stat;
							//$sql_db = $this->select($sql_stat);
							//echo $sql_db[0]['count_num'];
				}

			   function select_one($table,$keys = "",$fields = "",$ord = "",$sort = "DESC"){
				   //从数据库检索中获得第一条数据
				           $result = $this->select_date($table,$keys,$fields,1,$ord,$sort) or die(mysql_error());
						   if(empty($result))
						     return false;
						   return $result[0];
						}


			   function update_date($table,$keys = "",$date,$limit = ""){
						   $where = "";
						   $table = $this->dbconfig['pre'].$table;
			               if(is_array($keys))
						     if(!empty($keys)){
							   $array = array();
							   foreach($keys as $key => $value)
							     $array[] = $key." = '".$value."'";
							   $where = implode(" AND ",$array);
							   $where = " WHERE ".$where;
							 }
						   $dates = array();
						   foreach($date as $key => $value)
						     $dates[] = $key." = '".$value."'";
						   $dates = implode(",",$dates);
						   $sql = "UPDATE ".$table." SET ".$dates.$where;
						   if($limit != "")
						     $sql .= " LIMIT ".$limit;
						   return $this->update($sql);
			   }

			   function delete_date($table,$date,$limit = ""){
			               $keys = array();
						   $table = $this->dbconfig['pre'].$table;
			               foreach($date as $key => $value)
						     $keys[] = $key."='".$value."'";
						   $keys = implode(" AND ",$keys);
						   $sql = "DELETE FROM ".$table." WHERE ".$keys;
						   if($limit != "")
						     $sql .= " LIMIT ".$limit;
						   return $this->delete($sql);
			   }

			   function transaction_start(){
		          mysql_query("SET  AUTOCOMMIT=0");
		          mysql_query("BEGIN");
	           }

	           function rollback(){
	             mysql_query("ROOLBACK");
	           }

	           function commit(){
		         mysql_query("COMMIT");
	           }

}
?>
