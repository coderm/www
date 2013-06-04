<?php
class SiteTool extends AppModel
{
    public $name = 'SiteTool';
    public $useTable = false;
    
    
    
    function getNextDeskaData()
    {
        $results = $this->query('select * from vw_deskarental_adverts where deskarental_advert_id not in(select deskarental_advert_id from vw_deskarental_adverts where advert_id > 0) LIMIT 1');
        return $results;
    }
    
    function getNextVillaTurizmData()
    {
        $results = $this->query('select * from vt_adverts where vt_id not in(select vt_id from vt_adverts where advert_id > 0) LIMIT 1');
        return $results;
    }
    

    
    function getDetailClassIdByTextId($textId)
    {
        $results = $this->query('SELECT detail_class_id FROM lu_details_class WHERE message_text_id="'.$textId.'"');
        if(isset($results[0]['lu_details_class']['detail_class_id']))
            return $results[0]['lu_details_class']['detail_class_id'];
        else 
            return false;
    }
    
    function backup_database_tables($tables)
    {
	if($tables == '*')
	{
		$tables = array();
		$results = $this->query('SHOW TABLES');
		foreach($results as $row)
		{
			$tables[] = $row['TABLE_NAMES']['Tables_in_homelet'];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}

	//cycle through each table and format the data
        $return = '';
	foreach($tables as $table)
	{ 
            if  ( substr($table, 0, 2) == 'tx' or substr($table, 0, 2) == 'dt')
            {
		$results = $this->query('SELECT * FROM '.$table);
		$num_fields = count($results);

		$return.= 'DROP TABLE '.$table.';';
		$row2 = $this->query('SHOW CREATE TABLE '.$table);
                
                if(isset($row2[0][0]['Create Table']))
                    $row2 = $row2[0][0]['Create Table'];
                else if(isset($row2[0][0]['Create View']))
                    $row2 = $row2[0][0]['Create View'];
                
		$return.= "\n\n".$row2.";\n\n";
                
                
                foreach($results as $row)
                {
                    foreach(array_keys($row) as $key)
                    {
                        $a = array();
                        $return.= 'INSERT INTO '.$table.' VALUES(';
                        foreach(array_keys($row[$key]) as $key2)
                        {
                            $value = $row[$key][$key2];
                            $value = addslashes($value);
                            $value = str_replace("\n","\\n",$value); 
                            $a[] = $value;
                        }
                        $i = 0;
                        $total = count($a);
                        foreach($a as $value)
                        {
                            if (isset($value)) { $return.= '"'.$value.'"' ; } else { $return.= '""'; }
                            if ($i<($total-1)) { $return.= ','; }
                            $i++;
                        }
                        $return.= ");\n";
                    }
                }
		$return.="\n\n\n";
            }
	}
	//save the file
	//$return = mb_convert_encoding($return, 'UTF-8', 'Windows-1252');
	$handle = fopen('../../db_backups/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
    }        
}
?>
