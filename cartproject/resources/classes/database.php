<?php
/**
* Database configuration class
*
* @author: Prajyot
* 
* purpose : database class file
* opens connection
* functions fors database table CRUD and other operations
* 
*/

class Database
{
    private $_db_name = "";
    private $_db_user = "";
    private $_db_password = "";
    private $_db_host = "";
    
    /**
     * Constructor which sets database configuration
     * */
    function __construct($db_name, $db_user, $db_password, $db_host) {
        $this->_db_name = $db_name;
        $this->_db_user = $db_user;
        $this->_db_password = $db_password;
        $this->_db_host = $db_host;
    }
    
    /**
     * Function to connect to the database
    **/
    public function connect(){
        $con = mysqli_connect($this->_db_host, $this->_db_user, $this->_db_password, $this->_db_name);
        if (mysqli_connect_errno()) {
            header("Location: public_html/error/error.php");
        }else{
            return $con;
        }
    }
    
    /**
     * Function to select from table
     *  returns array
     * 
     * parameters: 
     * table_name - string name of the table
     * order - string - order by (ASC/DESC)
     * */
    public function select($table_name, $order){
        $sql = 'SELECT * FROM '.$table_name.' ORDER BY id '.$order.'';
        $result = mysqli_query($this->connect(), $sql);
        $data = array();
        while($row = mysqli_fetch_assoc($result)) {
          array_push($data, $row);
        }
        return $data;
    }
    
    /**
     * Function to custom select from table
     * returns array
     * 
     * parameters: 
     * table_name - string name of the table
     * data - array of select options 
     * eg: array('name', 'email')
     * 
     * order - string - order by (ASC/DESC)
    */
    public function cSelect($data, $table_name, $order){
        
        $values = "";
	
    	foreach($data as $item){
            
            if($values == ""){
                $values = $item;
            }else{
                $values = $values . "," . $item;
            }
        }
        
        $sql = 'SELECT '.$values.' FROM '.$table_name.' ORDER BY id '.$order.'';
        $result = mysqli_query($this->connect(), $sql);
        $t_data = array();
        while($row = mysqli_fetch_assoc($result)) {
          array_push($t_data, $row);
        }
        return $t_data;
    }
    
    
    /**
     * Function to custom select from table by id
     * returns array
     * 
     * parameters: 
     * table_name - string name of the table
     * id - integer id from the table(primary key)
     * data - array of select options 
     * eg: array('name', 'email')
     * 
    */
    public function cSelectById($table_name, $id, $data){
        
        $values = "";
	
    	foreach($data as $item){
            
            if($values == ""){
                $values = $item;
            }else{
                $values = $values . "," . $item;
            }
        }
        $sql = 'SELECT '.$values.' FROM '.$table_name.' WHERE id='.$id;
        $result = mysqli_query($this->connect(), $sql);
        $adata = array();
        while($row = mysqli_fetch_assoc($result)) {
          array_push($adata, $row);
        }
        return $adata;
    }
    
    /**
     * Function to select from table by id
     * returns array
     * 
     * parameters:
     * id - integer id in table
     * tabel_name - string name of the table
    */
    public function selectById($table_name, $id){
        $sql = 'SELECT * FROM '.$table_name.' WHERE id='.$id;
        $result = mysqli_query($this->connect(), $sql);
        $data = array();
        while($row = mysqli_fetch_assoc($result)) {
          array_push($data, $row);
        }
        return $data;
    }
    
    /**
     * Function to select one entry from table
     * returns array
     * 
     * parameters :
     * $select_data - array or select statements * if selecting all
     * eg. array('id', 'name')
     * 
     * $where_data - associative array for where condition
     * eg. array('category_id' => 19)
     * 
     * $table_name = string - table name
     * 
     * $order - order ASC/DESC
     * 
     * $limit - limiting number of records
    */
    public function customSelectLimit($select_data, $where_data, $table_name, $order, $limit){
        
        $values = "";
        $where = "";
        $is = "";
        $sql = "";
    
        if($select_data == "*"){
            $values = "*";
        }else{
        	foreach($select_data as $item){
                
                if($values == ""){
                    $values = $item;
                }else{
                    $values = $values . "," . $item;
                }
            }   
        }

        if($where_data == null){
            
            $sql = 'SELECT '.$values.' FROM '.$table_name.' ORDER BY id '.$order.' LIMIT '.$limit.'';
        }else{       
            foreach($where_data as $key => $where){
                $where = $key;
            }
            
            $is = $where_data[$where];
            $sql = 'SELECT '.$values.' FROM '.$table_name.' WHERE '.$where.'='.$is.' ORDER BY id '.$order.' LIMIT '.$limit.'';
        }
          
        $result = mysqli_query($this->connect(), $sql);
        $data = array();
        while($row = mysqli_fetch_assoc($result)) {
          array_push($data, $row);
        }
        return $data;
    }
    
    /**
     * Function to custom select from table
     * returns array
     * 
     * parameters :
     * $select_data - array or select statements * if selecting all
     * eg. array('id', 'name')
     * 
     * $where_data - associative array for where condition
     * eg. array('category_id' => 19)
     * 
     * $table_name = string - table name
    */
    public function customSelect($select_data, $where_data, $table_name){
        
        $values = "";
        $where = "";
        $is = "";
	
        if($select_data == "*"){
            $values = "*";
        }else{
        	foreach($select_data as $item){
                
                if($values == ""){
                    $values = $item;
                }else{
                    $values = $values . "," . $item;
                }
            }   
        }
                
        foreach($where_data as $key => $where){
            $where = $key;
        }
        
        $is = $where_data[$where];
        
        $sql = 'SELECT '.$values.' FROM '.$table_name.' WHERE '.$where.'='.$is.'';
                
        $result = mysqli_query($this->connect(), $sql);
        $data = array();
        while($row = mysqli_fetch_assoc($result)) {
          array_push($data, $row);
        }
        return $data;
    }
    
    /**
     * Function to insert into table
     * returns boolean
     * 
     * parameters:
     * data - associative array with table column names
     * eg: array('coumn_name' => 'data', 'first_name' => 'prajyot')
     * 
     * table - string - name of the table
    */
    public function insert($data, $table){
        
       $columns = "";
       $values = "";

        foreach($data as $key => $item){
        
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $key;
            $values .= ($values == "") ? "" : ", ";
            if (is_string($item)) 
             {
                 $values .= "'".$item."'";
             } else {
                 $values .= $item;
             }
       
         }
        $sql = 'INSERT INTO '.$table.' ('.$columns.') values ('.$values.')';
        $result = mysqli_query($this->connect(), $sql);
        return $result;
    }
    
    /**
     * Function to update from table
     * parameters:
     * 
     * data - associative array with table column names
     * eg: array('coumn_name' => 'data', 'first_name' => 'prajyot')
     * 
     * id - integer id in the table (primary key)
     * 
     * table_name - string - name of the table
     * 
     * */
     public function update($data, $id, $table_name){
        $update_string = "";
        
        foreach($data as $key => $item){
        
            if(($update_string == "")){
                $update_string = $key.'="'.$item.'"';
            }else{
                $update_string = $update_string . "," . $key.'="'.$item.'"';
            }
        }
        
        $sql = 'UPDATE '.$table_name.' SET '.$update_string.' WHERE id = '.$id.'';
        $result = mysqli_query($this->connect(), $sql);
        return $result;
     }
     
     /**
     * Function to delete from table
     * 
     * parameters: 
     * id - integer - id in table (primary key)
     * table_name - tsring - name of the table
     * */
     
     public function delete($id, $table_name){
        $sql = 'DELETE FROM '.$table_name.' WHERE id = '.$id.'';
        mysqli_query($this->connect(), $sql);
     }
    
    /**
     * Function to auth user
     * returns result array 1
     * 
     * parameters:
     * email - string email
     * password - string password
     * table - string - name of the table
     * 
     * */
     public function auth($email, $password, $table){
        $sql = 'SELECT id FROM '.$table.' WHERE email="'.$email.'" AND password="'.$password.'" LIMIT 1';
        $result = mysqli_query($this->connect(), $sql);
        return mysqli_fetch_assoc($result);
     }
     
    /**
    * Function to get user id by email
    * returns user_id(int)
    * 
    * parameters : 
    * email - string email
    * table - string table name
    * 
    * */
    public function getUserIdByEmail($email, $table){
        $sql = 'SELECT id from '.$table.' where email="'.$email.'" LIMIT 1';
        $result = mysqli_query($this->connect(), $sql);
        return mysqli_fetch_assoc($result);
    }
    
    /**
    * Function to search
    * returns array
    * 
    * parameters : 
    * table - string table name
    * where - where clause in table filed
    * value - value you are searching for
    * */
    public function search($table, $where, $value){
    	
        $sql = 'SELECT * from '.$table.' where '.$where.' LIKE "%'.$value.'%"';
        $result = mysqli_query($this->connect(), $sql);
        $data = array();
        while($row = mysqli_fetch_assoc($result)) {
          array_push($data, $row);
        }
        return $data;
    }
    
    /**
     * Function for custom SQL
     * 
     * parameters:
     * sql = sql query string
     * 
     */
    public function customSQL($sql){
    	
    	$result = mysqli_query($this->connect(), $sql);
    	$data = array();
    	while($row = mysqli_fetch_assoc($result)) {
    		array_push($data, $row);
    	}
    	return $data;
    }
        
}