<?php
class User extends BaseSql{

    protected $id = -1;
    protected $email;
    protected $firstname;
    protected $lastname;
    protected $username;
    protected $password;
    protected $avatar;
    protected $permission;
    protected $is_deleted;
    protected $created_at;
    protected $updated_at;


    /*TODO
    • Check longueur password
    • Check email
    • Check longueur name, etc
    • Check if user not allready exist (email and username)
    */
    public function __construct($id='DEFAULT',$email=null,$firstname=null,$lastname=null,$username=null,$password=null,$avatar=null,$permission= 0,$is_deleted=0,$created_at='DEFAULT',$updated_at='DEFAULT'){
        parent::__construct();
        $this->setEmail($email);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setUsername($username);
        $this->setAvatar($avatar);
        $this->setPassword($password);
        $this->setPermission($permission);
    }

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param mixed email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = trim($email);

        return $this;
    }

    /**
     * Get the value of Firstname
     *
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of Firstname
     *
     * @param mixed firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = trim($firstname);

        return $this;
    }

    /**
     * Get the value of Lastname
     *
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of Lastname
     *
     * @param mixed lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = trim($lastname);

        return $this;
    }

    /**
     * Get the value of Username
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of Username
     *
     * @param mixed username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = trim($username);

        return $this;
    }

    /**
     * Get the value of Password
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of Password
     *
     * @param mixed password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Get the value of Avatar
     *
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of Avatar
     *
     * @param mixed avatar
     *
     * @return self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of Permission
     *
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the value of Permission
     *
     * @param mixed permission
     *
     * @return self
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get the value of Is Deleted
     *
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Set the value of Is Deleted
     *
     * @param mixed is_deleted
     *
     * @return self
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    /**
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of Created At
     *
     * @param mixed created_at
     *
     * @return self
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of Updated At
     *
     * @param mixed updated_at
     *
     * @return self
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
