<?php 
    require_once('dbConnect.php');

    function execBoundSQL ($db, $sql, $params,$errmsg) {
	    $errmsg = '';
    	$stmt = pg_query_params($db, $sql, $params);
    	if ($stmt == false){
	    	$errmsg = 'There was a problem running the query.';
    	}
    	
    }
    function getUniqueId($table, $id=""){
    	$db = connect2DB();
    	if (!isset($id) && isset($table)){
    	   $sql = "SELECT ( 
    	   	       SELECT eval(column_default)
    	   	       FROM   information_schema.columns 
    	   	       WHERE  table_name='$table' and column_default ilike 'nextval%'
    	   	   ) as seq";
    	   $query = pg_query($sql);
    	   $result = pg_fetch_row($query, 0);
    	   return $result[0];
    	
    	} else {
    		return $id;
    	}
    }
    	
    class JSONTableBridge {
    	private $connection;
    	private $tableName;
    	private $primaryKey;
    	private $SQL_LOG;
    	private $pkVal;
    	private $errors;
    	
    	private $mapping;

//    	public function READ($idArray);
    	
    	public function __construct($table, $pk, $maps=array(),$conn){
    		$this->connection = $conn;
    		$this->tableName =  $table;
    		$this->primaryKey = $pk;
    		$this->mapping = $maps;
    		$this->errors = array(); 
    		$this->pkVal = array();
    	}
		
    	private function sanitize($val){
            try{
        		if (gettype($val)=="boolean"){
        			$val = ($val) ? 1 : 0; 
        		} elseif (gettype($val)=="object") {
            	    $data = get_object_vars($val);
                    $val =  trim(strip_tags($data[0]));
        		} else{
        			$val = trim(strip_tags($val));
        		}
        		return $val;
            } catch (Exception $e)  {  
                  throw new Exception( 'Failed to sanitize '.var_dump($val), $e);  
            }  
    	}
    	
    	public function UPDATE($json=""){
    		if ($json != ""){
    			$jsonObj = json_decode($json);
    		    if (!is_array($jsonObj)){
    				$jsonObj = array($jsonObj);
    			}
    			$returnIds = array();
    			for ($j=0;$j<count($jsonObj);$j++){
    				
    				$jsonObj[$j] = $this->doMappings($jsonObj[$j]);
    				$fieldCount = count($jsonObj[$j]) - 1;
    				$prependSQL  = "UPDATE " . $this->tableName . " SET ";
    				$params = array();
    				$colVals = array();
    				$updateParams = "";
    				$i=0;
	    			foreach ($jsonObj[$j] as $column => $value){
	    					if ($column !== $this->primaryKey){
		    					$i++;
			    				$colVals[] = "\"".$column."\" = $".($i);
			    				array_push($params , $value);
	    					}
	    			}//eof foreach
	    		
	    			array_push($params ,$this->pkVal[$j]); // push primary key value onto param array
	    			array_push($returnIds,$this->pkVal[$j]); 
	    			$updateParams = implode(' , ',$colVals);
	    			$endClause = " WHERE \"$this->primaryKey\" = $".($i+1).";"; 
					$SQL = $prependSQL . $updateParams . $endClause;
					$this->SQL_LOG[] =  array(date('h:i:s') => array($SQL,json_encode($params)));
					$query = execBoundSQL($this->connection, $SQL,$params,$errorMsg);
					if (strlen($errorMsg) > 0){
						$this->errors[] = array(date('h:i:s') => $errorMsg);
					}
    			}
    			return $returnIds;
    		} else{
    			$this->errors[] = array(date('h:i:s') => "No JSON Supplied to UPDATE");
    		}
    	}
    	public function getErrors (){
    		return var_dump($this->errors);	
    	}
    	
    	public function hasErrors (){
    		return count($this->errors);	
    	}
    	    	
    	public function getErrorCount(){
    		return count($this->errors);
    	}
    	
    	public function getSQL (){
    		echo var_dump($this->SQL_LOG);	
    	}
    	
    	public function returnSQL_LOG (){
    		return $this->SQL_LOG;	
    	}
    	    	
      	public function CREATE($json="",$pkey = "",$returnData=false){
    		if ($json != ""){
    			
    			$jsonObj = json_decode($json);

    			if (!is_array($jsonObj)){
    				$jsonObj = array($jsonObj);
    			}
    			$returnIds = array();
    			for ($j=0;$j<count($jsonObj);$j++){
    				$params = array();

	    			$jsonObj[$j] = $this->doMappings($jsonObj[$j]);
	    			
    				 if ($this->tableName !== "" && !is_null($jsonObj[$j][$this->primaryKey])){
	    				$pkVal =getUniqueId($this->tableName);
	    				$jsonObj[$j][$this->primaryKey] = $pkVal; 
	    				$returnIds[] = $pkVal;
	    			}
	    			$fieldCount = count($jsonObj[$j]); // don't subtract one because we are not passing in a primary key
	    			$prependSQL  = "INSERT INTO " . $this->tableName;
	    			$columnsList = array();
	    			$valuesList = array();
	    			$i=0;
	    			
	    			foreach ($jsonObj[$j] as $column => $value){
	    				$i++;
	    				$columnsList[] = "\"".$column."\"";
	    				$valuesList[] = "$".($i);
	    				array_push($params , $value);
	    			}//eof foreach
	    			
	    			$columnsList = "(".implode(',',$columnsList).") ";
	    			$valuesList = "VALUES(".implode(',',$valuesList).");";
					$SQL = $prependSQL . $columnsList . $valuesList;
					$this->SQL_LOG[] =  array(date('h:i:s') => array($SQL,json_encode($params)));
					$query = execBoundSQL($this->connection,$SQL,$params,$errorMsg) ;
	    			if (strlen($errorMsg) > 0){
							$this->errors[] = array(date('h:i:s') => $errorMsg);
					}
    			}
    			return $returnIds;
    		} 	else{
    			$this->errors[] = array(date('h:i:s')=> "No JSON Supplied to CREATE");
    		}
    	}
    	
    	public function DELETE($json="",$where=array()){

    		if ($json !== ""){
    			$jsonObj = json_decode($json);
    			if (!is_array($jsonObj)){
    				$jsonObj = array($jsonObj);
    			}
    			
    			$endClause = "";
    			$params = array();
    			$idsArray = array();
    			$fieldCount = count($jsonObj);
    			for($i=0;$i<count($jsonObj);$i++){
    				array_push($params,$this->sanitize($jsonObj[$i]));
    				$idsArray[] = "$".($i+1);
    			}

    			if (count($where) > 0){
    				$j=0;
    				$whereCount = count($where);
    				$clauses = array();
    				foreach($where as $key => $value){
    					$j++;
	    				switch ($this->sanitize($value)){
				    		case "{datetime}":
				    			$tmp[$key] = date("Y-m-d H:i:s");
				    		break;
				    		case "{false}":
				    			$value = false;
				    		break; 
				    		case "{true}":
				    			$value = true;
				    		break; 
				    		default: 
				    			 if (preg_match('/^\[/',$value) && preg_match('/\]$/',$value)){
				    				$value = trim($this->sanitize($value),"[] \t\n\x0b\0\r");
				    			 }
				    			 else{
				    			 	$value = $this->sanitize($value);
				    			 }
			    		}
    					array_push($clauses,"\"".$this->sanitize($key)."\" = $".($j+$fieldCount));
    					array_push($params,$value);
    				}
    				$endClause = " AND ".implode(' AND ',$clauses);
    			}
    			$ids = "(".implode(',',$idsArray).")";
    	    	$SQL = "DELETE FROM $this->tableName WHERE $this->primaryKey in $ids" . "$endClause;";
    	    	$this->SQL_LOG[] =  array(date('h:i:s') => array($SQL,json_encode($params)));
    	    	$query = execBoundSQL($this->connection,$SQL,$params,$errorMsg);
    			if (strlen($errorMsg) > 0){
					$this->errors[] = array(date("h:i:s") => $errorMsg);
				}
    		} 	else{
    			$this->errors[] = array(time() => "No ID's Supplied to DELETE in Array");
    		}
    	}
    	
    	public function CONDITIONAL ($json,$seq, $conditions=array(),$where=array()){
    		/* This function takes an array of conditions [arg2] and evaluates the json provided [arg0]
    		 * and runs the operations specified in the conditions array.  The conditions array should be 
    		 * formatted in the following format:
    		 * array("delete" => array("column_name" => => array("value"=>false,"operator"=>"!="); // finds where column_name's value != false
    		 */
    	    	if ($json != ""){
	    			
	    			$jsonObj = json_decode($json);
    	    		if (!is_array($jsonObj)){
	    				$jsonObj = array($jsonObj);
	    			}
	    			
					$conditionCount = count($conditions);
					$sqlConditions = array();
	    			
	    			for ($j=0;$j<count($jsonObj);$j++){
	    				$jsonObj[$j] = $this->doMappings($jsonObj[$j]);
	    				foreach ($conditions as $key => $value){ // condition names
		    				foreach ($value as $column => $colCondition){ // column names and values
		    					if (gettype($colCondition) !== 'array'){
			    					if ($jsonObj[$j][$column] === $colCondition){
			    						if (strtolower($key) !== "delete"){ // delete takes an array of id's 
			    							$sqlConditions[strtolower($key)][] = $jsonObj[$j];
			    						}
			    						else{
			    							$sqlConditions[strtolower($key)][] = $jsonObj[$j][$this->primaryKey];
			    						}
			    					}
		    					}
			    				elseif (gettype($colCondition) === 'array'){
			    					if ($colCondition["operator"] === '!=') {			
			    						if ($colCondition["value"] !== $jsonObj[$j][$column]){
				    						if (strtolower($key) !== "delete"){ // delete takes an array of id's 
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j];
					    					}
					    					else{
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j][$this->primaryKey];
					    					}
			    						}
			    					}
			    					elseif ($colCondition["operator"] === '>=') {			
			    						if ($colCondition["value"] >= $jsonObj[$j][$column]){
				    						if (strtolower($key) !== "delete"){ // delete takes an array of id's 
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j];
					    					}
					    					else{
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j][$this->primaryKey];
					    					}
			    						}
			    					}
			    				   elseif ($colCondition["operator"] === '<=') {			
			    						if ($colCondition["value"] <= $jsonObj[$j][$column]){
				    						if (strtolower($key) !== "delete"){ // delete takes an array of id's 
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j];
					    					}
					    					else{
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j][$this->primaryKey];
					    					}
			    						}
			    					}
			    					elseif ($colCondition["operator"] === '==') {			
			    						if ($colCondition["value"] == $jsonObj[$j][$column]){
				    						if (strtolower($key) !== "delete"){ // delete takes an array of id's 
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j];
					    					}
					    					else{
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j][$this->primaryKey];
					    					}
			    						}
			    					}
			    					elseif ($colCondition["operator"] === '<') {			
			    						if ($colCondition["value"] < $jsonObj[$j][$column]){
				    						if (strtolower($key) !== "delete"){ // delete takes an array of id's 
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j];
					    					}
					    					else{
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j][$this->primaryKey];
					    					}
			    						}
			    					}	
			    				elseif ($colCondition["operator"] === '>') {			
			    						if ($colCondition["value"] > $jsonObj[$j][$column]){
				    						if (strtolower($key) !== "delete"){ // delete takes an array of id's 
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j];
					    					}
					    					else{
					    						$sqlConditions[strtolower($key)][] = $jsonObj[$j][$this->primaryKey];
					    					}
			    						}
			    					}	
			    				}
		    				}
		    			}
	    			}
	    			if (count($sqlConditions) > 0){
	    				foreach ($sqlConditions as $operation => $data){
	    					$jsonData = json_encode($data);
		    				switch ($operation){
								CASE "create":
									$this->CREATE($jsonData,$seq);
									break;
		    					CASE "update":
		    						$this->UPDATE($jsonData,$seq);
		    						break;
		    					CASE "delete":
		    						$this->DELETE($jsonData,$where);
		    						break;
		    				}
	    				}
    	    		}
    	    } 	else{
    			$this->errors[] = array(time() => "No JSON Supplied to CONDITIONAL");
    		}
    		
    	}
    	
    	private function doMappings($obj=array()){
    		
			$tmp = array();
			if (count($this->mapping) > 0){
		    	foreach($obj as $key => $value ){
		    		$test = array_key_exists($key,$this->mapping);
		    		
		    		$value = $this->sanitize($value);
		    		
		    		if($test){ //if row property exists in mapping
		    			$oldKey = $key;
		    			$key = $this->mapping[$key]; //updates row property's key with mapped keyname
		    			$key = $this->sanitize($key,1);
		    			switch ($this->mapping[$oldKey]){
				    		case "{datetime}":
				    			$tmp[$key] = date("Y-m-d H:i:s");
				    		break;
				    		case "{false}":
				    			break; // don't include this in the sql
				    		default: 
				    			
				    			if (preg_match('/^\[/',$value) && preg_match('/\]$/',$value)){
				    				
					    			$value = trim($value,"[] \t\n\x0b\0\r");
				    				if ($key !== $this->primaryKey){
					    				$key = $this->sanitize($key);
					    				$tmp[$key] = $value;
					    			}else{
			    						$this->pkVal[] = $value;
			    					}
				    			}else{
				    				$tmp[$key] = $value;
				    			}
			    		}
		    		}else{
		    			if ($key !== $this->primaryKey){
		    				$key = $this->sanitize($key);
		    				$tmp[$key] = $value;
		    			}else{
		    				$this->pkVal[] = $value;
		    			}
		    		}
		    	}
		    	foreach($this->mapping as $key => $value ){
			    	if ((!array_key_exists($key,$tmp)) && (!array_key_exists($value,$tmp))){
			    		switch ($this->mapping[$key]){
				    		case "{datetime}":
				    			$tmp[$key] = date("Y-m-d H:i:s");
				    		break;
				    		case "{false}": // don't include this in the sql
				    		break;
				    		default:
				    			if (preg_match('/^\[/',$value) && preg_match('/\]$/',$value)){
					    			$value = trim($value,"[] \t\n\x0b\0\r");
				    				if ($key !== $this->primaryKey){
					    				$key = $this->sanitize($key);
					    				$tmp[$key] = $value;
					    			}else{
			    						$this->pkVal[] = $value;
			    					}
				    			}

			    		}
			    	}
			    }	
			}else{
				foreach($obj as $key => $value ){
					if ($key !== $this->primaryKey){
			    				$key = $this->sanitize($key);
			    				$tmp[$key] = $value;
			    			}else{
			    				$this->pkVal[] = $value;
			    			}
					}
				
			}
	    	return $tmp;
    	} 
    }
?>