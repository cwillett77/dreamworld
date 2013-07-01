<?php
require_once("/var/www/db/MysqlAdapter.php");
class User extends MysqlAdapter {
	
	private $_id;
	protected $_firstname;
	protected $_lastname;
	protected $_email;
	protected $_date;
	
	public function __construct($config, $values = array()) {
		
		parent::__construct($config);
		
		if(!empty($values)) {
			foreach($values as $k=>$v) {
				
				$func_name = "set".ucwords($k);
				$this->$func_name($v);
			}
		}
	}	
	
    public function getId()
    {
        return $this->_id;
    }

    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
        return $this;
    }

    public function getFirstname()
    {
        return $this->_firstname;
    }
    
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
        return $this;
    }

    public function getLastname()
    {
        return $this->_lastname;
    }
	
	public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }
    
    public function getDate()
    {
        return date("Y-m-d H:i:s");
    }
    
    public function insertData() {
	    
	    $firstname = $this->getFirstname();
	    $lastname = $this->getLastname();
	    $email = $this->getEmail();
	    $date = $this->getDate();
	    
	    $data = array($firstname, $lastname, $email, $date);
	    $this->insert("users",$data);
	    
    }

}