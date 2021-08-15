<?php

// database wrapper can be used anywhere
// using pdo php database object 
require_once dirname(__DIR__ ).'/core/init.php';
require_once dirname(__DIR__ ).'/classes/Config.php';
class DB 
{
    private static $_instance = null;               //the underscore is the notation for private members
    private $_pdo,
            $_query,                                   //last query that is executed
            $_error=false,                             //for error 
            $_results,                                 //results from the querry
            $_count=0;                                 //count for the results
    

    private function __construct()                              //connection to database always
    {                            
        try{                                                       //try and catch for errors 

            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));    //using PDO ;connection to db
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->query("SET NAMES utf8");
            
            
        }catch(PDOException $e){                                       //pdo exception gives the error in $e through getMessage function 
            die($e->getMessage());
        }
    }

    public static function getInstance()                                  //instantiating the class first 
        {
            if(!isset(self::$_instance))
            {
                self::$_instance = new DB();
            }
            return self::$_instance;
        }

        
    public function query($sql,$params = array())                      //querry running function 
    {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){                 //prepare the query and return true if success
            // print_r($this->_query);
            $x=1;
            if(count($params)){                                           //if parameters are present
                foreach($params as $param){
                    $this->_query->bindValue($x,$param);                      //binding the params
                    $x++;
                }
            }
            // print_r($this->_query);
            if($this->_query->execute()){                                               //executing the query successfully
            
                if(explode(" ",$sql)[0] == 'SELECT'){
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);       //FETCHING AND STORING RESULTS AS AN OBJECT
                    $this->_count = $this->_query->rowCount();                          //method of pdo to count the no. of rows
                }                                                                
                
                
            }
            else{
                $this->_error = true;
            }
        }
        return $this;                                                   //returns the object itself ni to error aata h bc
    }


    public function action($action,$table,$where=array()){
        if(count($where)===3){
            $operators = array('=','>','<','>=','<=');
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            if (in_array($operator,$operators)){
                $sql = "$action FROM `$table` WHERE $field $operator ?";
                if(!$this->query($sql,array($value))->error()){
                    return $this;
                }
            }
        }
        return false;
    }

    public function get($table,$where){                                //get data from the database
        return $this->action('SELECT *',$table,$where);

    }

    public function delete($table,$where){                          //delete function 
        return $this->action('DELETE',$table,$where);
        
    }

    public function insert($table,$fields){             //function to insert data into database
        $keys = array_keys($fields);
        $values = '';
        $x = 1;
        foreach($fields as $field){
            $values .= '?';
            if (count($fields)>$x){
                $values .= ', ';
            }
            $x++;
        }
        $sql = "INSERT INTO $table(`".implode('`, `',$keys)."`) VALUES ($values)";
        //echo $sql;
        if(!$this->query($sql,$fields)->error()){
            // echo " inserted ";
            return true;
        }
        //echo "not inserted";
        return false;
    }


    public function update($table,$username,$fields)                //function to update a record 
    {
        $set ='';
        $x = 1;
        foreach($fields as $key=>$value)
        {
            $set .= $key.'=?';
            if(count($fields)>$x){
                $set .= ', ';
            }
            $x++;
        }
    
        $sql = "UPDATE $table SET $set WHERE username = '$username' ";
       // echo $sql;
       
        if(!$this->query($sql,$fields)->error()){
           //echo "updated";
            return true;
        }
        else {
       // echo "not updated ";
            return false;
        }
    }


    



    public function count(){                                //counts the no. of rows fetched
        return $this->_count;
    }

    public function results(){                           //return results from the querry run
        return $this->_results;
    }

 
    public function first(){                                //return the first results of the result array
        return ($this->results())[0];
    }


    public function error()                         //if error
    {
        return $this->_error;
    }

  

   

    public function getQues($table,$get)                              //array like [1,2,3,4]                             
    {
      
        $sql = "SELECT * FROM $table WHERE exercise = ? AND type = ? AND `difficulty` = ?";

        return $this->query($sql,$get)->results();
    }

    public function getQuesImage($table,$get)                              //array like [1,2,3,4]                             
    {
      
        $sql = "SELECT * FROM $table WHERE exercise = ? AND type = ?";

        return $this->query($sql,$get)->results();
    }




   

    





 }


