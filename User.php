<?php
/**
 * Trida pro spravu 1 uzivatele
 */
class User extends AbstractModel
{
    /**
     * @var int
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    
    function __construct($id = null)
    {
        if ($id != null) {
            $this->find($id);
        }
    }

    /**
     * Nacteni uzivatele z databaze
     * @param int $id
     */
    public function find($id)
    {	
    	$sth = self::$database->prepare('
        	SELECT
                id, firstname, lastname
            FROM
                users
            WHERE
                id = :id	
        ');
        
    	$sth->execute(array(
    		':id' => $id	
    			));
    	
    	// array
    	$user = $sth->fetch(PDO::FETCH_ASSOC);

        $this->id = (int) $user['id'];
        $this->setFirstname($user['firstname']);
        $this->setLastname($user['lastname']);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return string:
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Ulozi data o uzivateli do DB
     */
    public function save()
    {
        if ($this->id != null) {
			$sth = self::$database->prepare('
				UPDATE
					users
				SET
					firstname = :firstname,
					lastname = :lastname
				WHERE
					id = :id			
			');
        	
			$sth->execute(array(
					':firstname' => $this->getFirstname(),
					':lastname'	 => $this->getLastname(),
					':id'		 => $this->getID()		
			));       	
        } else {
            $sth = self::$database->prepare('
            	INSERT INTO
            		users (firstname, lastname)
            	VALUES
            		(:firstname, :lastname)	          		
           	');
        	
        	$sth->execute(array(
        			':firstname' => $this->getFirstname(),
        			':lastname'	 => $this->getLastname()	
        	));        	
        }
    }

    /**
     * Smaze uzivatele z DB
     */
    public function delete()
    {
        if ($this->id != null) {
            $sth = self::$database->prepare('
            	DELETE FROM
            		users
            	WHERE
            		id = :id		
            ');
        	
            $sth->execute(array(
            		':id' => $this->getId()	
            ));
        }
    }

    /**
     * Nastavi data u uzivatele
     * @param array $data
     */
    public function setData($data)
    {
        $this->id = (int) $data['id'];
        $this->setFirstname($data['firstname']);
        $this->setLastname($data['lastname']);
    }
}