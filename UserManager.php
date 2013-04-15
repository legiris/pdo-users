<?php
/**
 * Trida pro spravu uzivatelu
 */
class UserManager extends AbstractModel
{
    /**
     * data vsech uzivatelu
     * @var array
     */
    protected $users = null;

   
    /**
     * Nacte a vrati seznam vsech uzivatelu
     * @return array
     */
    public function fetchAll()
    {
        if ($this->users == null) {
            $users = array();
            $sth = self::$database->prepare('
            	SELECT
                    id,
                    firstname,
                    lastname
                FROM
                    users
                ORDER BY
                    lastname ASC,
                    firstname ASC	       		
            ');
            $sth->execute();
            
            $this->users = $sth->fetchAll(PDO::FETCH_CLASS, 'user');           
        }
        return $this->users; 
    }

    /**
     * Vrati pocet vsech uzivatelu
     * @return int
     */
    public function count()
    {
        if ($this->users == null) {
            $this->fetchAll();
        }

        return count($this->users);
    }

    /**
     * Vrati objekt uzivatele
     * @param int $id
     * @return User
     */
    public function find($id)
    {
        return new User($id);
    }

    /**
     * Vytvori noveho uzivatele
     * @param array $data
     */
    public function createUser($data)
    {
        $user = new User();
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->save();
    }

    /**
     * Upravi uzivatele
     * @param int $id
     * @param array $data
     */
    public function updateUser($id, $data)
    {
        $user = $this->find($id);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->save();
    }

    /**
     * Smaze uzivatele
     * @param int $id
     */
    public function removeUser($id)
    {
        $user = $this->find($id);
        $user->delete();
    }
}