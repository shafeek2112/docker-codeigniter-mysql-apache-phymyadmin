<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function get_migration_data_from_uat($dbgroup="",$status=""){
	if($dbgroup == "")
	{
		echo "Please pass dbgroup for migration";exit;
	}
	$ci =& get_instance();
	
	$migration_data = array("migration_id" => 0,"migration_file_url" => "","migration_file_name"=>"");
	
	if($status == "Deleted"){
		$migration_data = array();
		
		$sql = "SELECT id FROM `migration` WHERE `status` = 'Deleted' AND deleted_processed = 'No' AND  NOW() > DATE_ADD(deleted_date, INTERVAL 10 MINUTE) ORDER BY deleted_date ASC ";
		
		$query = $ci->db->query($sql);
		$arrRes = $query->result_array();
		
		if($query->num_rows() > 0){
			$icnt = 0;
			foreach($arrRes AS $row) {
				$migration_id = $row["id"];
				$migration_data[$icnt]["migration_id"] = $migration_id;
				$icnt++;
			}
		}
	}
	else{
		$sql = "SELECT id FROM `migration` WHERE `status` = 'InProgress' AND NOW() > DATE_ADD(created_date, INTERVAL 10 MINUTE) ORDER BY created_date ASC LIMIT 1 ";
		
		$query = $ci->db->query($sql);
		$arrRes = $query->result_array();
		
		if($query->num_rows() > 0){
			foreach($arrRes AS $row) {
				$migration_id = $row["id"];
				$migration_data["migration_id"] = $migration_id;
				$migration_data["migration_file_url"] = base_url()."db/migration/$migration_id"."_$dbgroup.sql.zip";
				$migration_data["migration_file_name"] = "$migration_id"."_$dbgroup.sql";
			}
		}
	}
	
	return json_encode($migration_data);
}

function update_migration_status_in_uat($migration_id,$status=""){
	$ci =& get_instance();
	
	if($migration_id > 0)
	{
		if($status == "Deleted"){
			$sql = "UPDATE `migration` SET deleted_processed = 'Yes' WHERE `migration_id` = $migration_id ";
			$query = $ci->db->query($sql);
		}
		else if($status == "Completed"){
			$sql = "UPDATE `migration` SET status = 'Completed',updated_by = '0',updated_date=NOW() WHERE `migration_id` = $migration_id ";
			$query = $ci->db->query($sql);
		}
	}
}

function start_migration_uat(){
	$ci =& get_instance();
	
	$migration_id = 0;
	
	$sql = "SELECT id FROM `migration` WHERE `status` = 'InProgress' AND NOW() > DATE_ADD(created_date, INTERVAL 10 MINUTE) ORDER BY created_date ASC LIMIT 1 ";
	$query = $ci->db->query($sql);
	$arrRes = $query->result_array();
	
	if($query->num_rows() > 0){
		foreach($arrRes AS $row) {
			$migration_id = $row["id"];
		}
	}
	else{
		echo "No New Migration Found";exit;
	}
	
	$arrTables = get_all_tables();
	
	foreach($arrTables AS $table) {
		add_migration_id_in_table_if_not_exist($table,$migration_id);
	}
	
	create_sql_dump_zip_file($migration_id,$dbgroup="default");
	
	$migration_data = file_get_contents(base_url()."cron/get_migration_data_from_uat/default");
	$migration_data = json_decode($migration_data);
	
	restore_migration_database($migration_data,$dbgroup="migration");
	
	foreach($arrTables AS $table) {
		rename_all_migration_tables($table);
	}
	
	create_sql_dump_zip_file($migration_id,$dbgroup="migration");
}

function rename_all_migration_tables($table){
    $ci =& get_instance();
	
	$db = $ci->load->database("migration", TRUE);
	$table_new = $table."_migration";
	
	if($table != "")
	{
		$sql = "DROP TABLE IF EXISTS `$table_new`";
		$query = $db->query($sql);
		
		$sql = "RENAME TABLE `$table` TO `$table_new`";
		$query = $db->query($sql);	
	}
}

function create_sql_dump_zip_file($migration_id,$dbgroup="") 
{
	$ci =& get_instance();
	
	$file_path = "db/migration/$migration_id"."_$dbgroup.sql";
	$file_path_zip = "$file_path.zip";
	
	if($dbgroup == "")
	{
		echo "Please pass database group";exit;
	}
	$db = $ci->load->database($dbgroup, TRUE);
		
	$host = $db->hostname;
	$username = $db->username;
	$password = $db->password;
	$db = $db->database;
	
	//$command = "mysqldump --user='{$username}' --password='{$password}' --where='migration_id=$migration_id' --host={$host} --quick --insert-ignore --extended-insert --skip-add-drop-table --no-create-info --skip-add-locks --skip-comments --skip-set-charset --skip-disable-keys --skip-tz-utc {$db} > $file_path";
	
	$command = "mysqldump --user='{$username}' --password='{$password}' --where='migration_id=$migration_id' --host={$host} --quick --insert-ignore --extended-insert --skip-add-locks --skip-comments --skip-set-charset --skip-disable-keys --skip-tz-utc {$db} > $file_path";
	
	#Execute the command to create backup sql file
	$output = array();
	exec($command,$output,$retval);
	echo $command." === Return Val 0(ZERO) Means Success: ".$retval;
	
	
	$ci->load->library('zip');
	$ci->zip->read_file($file_path); 
	$ci->zip->archive($file_path_zip); // Creates a zip file
	$ci->zip->clear_data();
	
	#Now delete the .sql file without any warning
	@unlink($file_path);
	#Return the path to the zip backup file
	echo "\r\n<br> Migration Zip File Created For Migration ID: $migration_id ==> $file_path_zip  <br>\r\n";
}

// Function to restore from a file
function restore_migration_database($migration_data,$dbgroup="",$download_uat_file=0) {
	$ci =& get_instance();
	echo "<pre>";print_r($migration_data);
	
	if(empty($migration_data) && !isset($migration_data->migration_id)){
		echo "UAT migration file get content failed";exit;
	}
	$migration_id = $migration_data->migration_id;
	$migration_file_name = $migration_data->migration_file_name;
	$url = $migration_data->migration_file_url;
	
	$file_path = "db/migration_production/$migration_file_name";
	
	if($download_uat_file == 0){
		$file_path = "db/migration/$migration_file_name";
	}
		
	$file_path_zip = "$file_path.zip";
	
	if($download_uat_file == 1){
		$output = array();
		
		$command = "wget $url -O $file_path_zip";
		
		exec($command,$output,$retval);
		echo $command." === Return Val 0(ZERO) Means Success: ".$retval;
	}
	
	if($dbgroup != "")
	{
		$db = $ci->load->database($dbgroup, TRUE);
		
		$host = $db->hostname;
		$username = $db->username;
		$password = $db->password;
		$db = $db->database;
		
		if($migration_id == "" || $migration_id <= 0){
			echo "No Migration Data Found on UAT";exit;
		}
		//================== extract zip file =================
		$ci->unzip->extract($file_path_zip);
		
		$command = "mysql --user='{$username}' --password='{$password}' --database={$db} < $file_path";
			
		#Execute the command to create backup sql file
		$output = array();
		exec($command,$output,$retval);
		echo $command." === Return Val 0(ZERO) Means Success: ".$retval;
		
		#Now delete the .sql file without any warning
		@unlink($file_path);
		#Return the path to the zip backup file
		echo "\r\n<br> Migration File Imported For Migration ID: $migration_id ==> $file_path  <br>\r\n";
	}
}

function get_all_tables($update_pk=1,$dbgroup="default",$createExtraColumns=1){
    $ci =& get_instance();
	
	$db = $ci->load->database($dbgroup, TRUE);
	
	$TableField = "Tables_in_".$db->database;
	
	$arrTables = array();
	
	$sql = "SHOW tables";
	$query = $db->query($sql);
	$arrRes = $query->result_array();
	
	foreach($arrRes AS $row) {
		if($row[$TableField] != "")
			$arrTables[] = $row[$TableField];
		
			if($createExtraColumns == 1){
				add_column_in_table_if_not_exist($row[$TableField],$update_pk);	
			}
	}
	return $arrTables;
}

function add_column_in_table_if_not_exist($table,$update_pk=1){
    $ci =& get_instance();
	
	//ADD primary_key column with "migration_" prefix if not exist
	$sql_pri_column = "SHOW COLUMNS FROM `$table` WHERE `Key` = 'PRI'";
	$query_pri_column = $ci->db->query($sql_pri_column);
	$arrRes = $query_pri_column->result_array();
	
	$primary_key = "";
	$primary_key_with_pk_prefix = "";
	
	foreach($arrRes AS $row) {
		if($row["Field"] != "")
			$primary_key = $row["Field"];
			$primary_key_with_pk_prefix = "migration_pk_".$row["Field"];
	}
	
	if($primary_key != "")
	{
		$sql_check_pk_exist = "SHOW COLUMNS FROM `$table` WHERE `Field` = '$primary_key_with_pk_prefix'";
		$query_check_pk_exist = $ci->db->query($sql_check_pk_exist);
		
		if($query_check_pk_exist->num_rows() == 0){
			$sql_add_pk = "ALTER TABLE `$table` ADD $primary_key_with_pk_prefix  BIGINT(64) NOT NULL";
			$query_add_pk = $ci->db->query($sql_add_pk);
		}
		
		if($update_pk == 1)
		{
			$sql_update_data = "UPDATE `$table` SET $primary_key_with_pk_prefix = {$primary_key} WHERE $primary_key_with_pk_prefix <= 0 ";
			$query_update_data = $ci->db->query($sql_update_data);	
		}	
	}
	
	//ADD migration_id column if not exist
	$sql = "SHOW COLUMNS FROM `$table` WHERE `Field` = 'migration_id'";
	$query = $ci->db->query($sql);
	
	if($query->num_rows() == 0){
		$sql = "ALTER TABLE `$table` ADD `migration_id` INT NOT NULL";
		$query = $ci->db->query($sql);
	}
}

function add_migration_id_in_table_if_not_exist($table,$migration_id){
    $ci =& get_instance();
	
	$sql = "UPDATE `$table` SET migration_id = {$migration_id} WHERE migration_id = 0";
	$query = $ci->db->query($sql);
}


/////////////////////////////////////////////////////
///START SYNC DATA WITH PRODUCTION SERVER///////////
///////////////////////////////////////////////////
function start_migration_production($uat_url){
	$ci =& get_instance();
	
	//DELETE MIGRATED DATA FROM PRODUCTION
	$url = $uat_url."cron/get_migration_data_from_uat/default/Deleted";
	$migration_data = file_get_contents($url);
	$migration_data = json_decode($migration_data);

	if(empty($migration_data)){
		$arrTablesDB = get_all_tables($update_pk=0,$dbgroup="default",$createExtraColumns=1);
		$data_deleted = 0;
		
		foreach($migration_data AS $migrationObj)
		{
			if(isset($migrationObj->migration_id))
			{
				$migration_id = $migrationObj->migration_id;
			
				if($migration_id > 0)
				{
					foreach($arrTablesDB AS $table) 
					{		
						if($table != "")
						{
							$sql_delete = "DELETE FROM `$table` WHERE migration_id = $migration_id AND migration_id > 0 ";
							$query = $ci->db->query($sql_delete);
							
							$data_deleted = 1;
						}
					}
					
					if($data_deleted = 1)
					{
						$url_status = $uat_url."cron/update_migration_status_in_uat/$migration_id/Deleted";
						$result_status = file_get_contents($url_status);	
					}
				}	
			}
		}
	}
	
	//START MIGRATION
	$url = $uat_url."cron/get_migration_data_from_uat/migration";
	
	$migration_data = file_get_contents($url);
	$migration_data = json_decode($migration_data);
	
	if(empty($migration_data) && !isset($migration_data->migration_id)){
		echo "start_migration_production => UAT migration file get content failed";exit;
	}
	
	restore_migration_database($migration_data,$dbgroup="migration",$download_uat_file=1);
	
	process_data_after_migration($migration_data);
}

function process_data_after_migration($migration_data){
	$ci =& get_instance();
	
	$migration_id = $migration_data->migration_id;
	$data_migration_completed = 0;
	
	if($migration_id > 0)
	{
		$arrTables = get_all_tables($update_pk=0,$dbgroup="default",$createExtraColumns=1);
		$arrTablesMigrationDB = get_all_tables($update_pk=0,$dbgroup="migration",$createExtraColumns=0);
		
		$db_default = $ci->load->database("default", TRUE);
		$db_migration = $ci->load->database("migration", TRUE);
		
		$db_default_database = $db_default->database;
		$db_migration_database = $db_migration->database;
		
		foreach($arrTables AS $table) {
			
			$table_migration = $table."_migration";
			
			if($table != "" && in_array($table_migration,$arrTablesMigrationDB))
			{
				$sql_columns = "SHOW COLUMNS FROM `$table` ";
				$query_columns = $db_default->query($sql_columns);
				$arrRes = $query_columns->result_array();
				
				$arrColumns = array();
				$pk_key = "";
				
				foreach($arrRes AS $row) {
					if($row["Field"] != ""){
						$FieldName = "`".$row["Field"]."`";
						
						if($row["Key"] == "PRI"){
							$arrColumns[$FieldName] = 'NULL';
							$pk_key = $row["Field"];
						}else{
							$arrColumns[$FieldName] = $db_migration_database.".".$table_migration.".".$FieldName;
						}
					}
				}
				
				$sql_columns = implode(",", array_keys($arrColumns));
				$sql_columns_values = implode(",", array_values($arrColumns));
				
				if($pk_key != "")
				{
					$query = "INSERT INTO $db_default_database.`$table` 
							(
								$sql_columns	
							) 
							SELECT 
								$sql_columns_values
							FROM $db_migration_database.$table_migration
							LEFT JOIN $db_default_database.`$table` ON($db_migration_database.$table_migration.migration_pk_$pk_key = $db_default_database.`$table`.migration_pk_$pk_key)
							WHERE 
							$db_default_database.`$table`.migration_pk_$pk_key IS NULL
							AND $db_migration_database.`$table_migration`.migration_id = $migration_id
							ON DUPLICATE KEY UPDATE  $db_default_database.`$table`.migration_id = $db_migration_database.`$table_migration`.migration_id
							";
					$db_default->query($query);
					echo $query."  ==> \r\n\r\n<br><br>";
				
					$sql_data_sync = "SELECT * FROM $db_default_database.migration_data_sync WHERE $db_default_database.migration_data_sync.foreign_table = '$table' ";
					$query_data_sync = $db_default->query($sql_data_sync);
					$arrRes = $query_data_sync->result_array();
					
					foreach($arrRes AS $row) {
						$foreign_table = $row["foreign_table"];
						$foreign_table_key = $row["foreign_table_key"];
						$primary_table = $row["primary_table"];
						$primary_table_key = $row["primary_table_key"];
						
						$sql_data_sync = "
											UPDATE 
												$db_default_database.$foreign_table AS f_table
												JOIN $db_default_database.$primary_table AS p_table
												ON(f_table.$foreign_table_key = p_table.migration_pk_$primary_table_key)
											SET
												f_table.$foreign_table_key = p_table.$primary_table_key
											WHERE f_table.migration_pk_$pk_key > 0 AND f_table.migration_id = $migration_id
											";
						$query_data_sync = $db_default->query($sql_data_sync);
						echo $sql_data_sync."  ==> \r\n\r\n<br><br>";
					}
				}
			}
			
			$data_migration_completed = 1;
		}
		
		if($data_migration_completed = 1)
		{
			$url_status = $uat_url."cron/update_migration_status_in_uat/$migration_id/Completed";
			$result_status = file_get_contents($url_status);	
		}
	}
	
}