<?php
class Comment extends BaseSql{

    protected $id = -1;
    protected $content;
    protected $created_at;
    protected $picture_id; //Rajouter User / Alubm ?
    protected $user_id;
    protected $is_archived;

    //TODO voir user
    // • Récupérer les comments liés à un user (détenteur)

    public function __construct($id='DEFAULT',$content=null,$created_at='DEFAULT',$picture_id=null,$user_id=null,$is_archived='0'){
        parent::__construct();
        $this->setContent($content);
        $this->setPictureId($picture_id);
        $this->setUserId($user_id);
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
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of Content
     *
     * @param mixed content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = trim($content);

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

    /**
     * Get the value of Picture Id
     *
     * @return mixed
     */
    public function getPictureId()
    {
        return $this->picture_id;
    }

    /**
     * Set the value of Picture Id
     *
     * @param mixed picture_id
     *
     * @return self
     */
    public function setPictureId($picture_id)
    {
        $this->picture_id = $picture_id;

        return $this;
    }


    /**
     * Get the value of User Id
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of User Id
     *
     * @param mixed user_id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of Is Archived
     *
     * @return mixed
     */
    public function getIsArchived()
    {
        return $this->is_archived;
    }

    /**
     * Set the value of Is Archived
     *
     * @param mixed is_archived
     *
     * @return self
     */
    public function setIsArchived($is_archived)
    {
        $this->is_archived = $is_archived;

        return $this;
    }

}
