<?php
class Media{
    private $idMedia;
    private $typeMedia;
    private $nomMedia;
    private $creationDate;
    private $modificationDate;
    private $idPost;

    /**
     * Get the value of idMedia
     */ 
    public function getIdMedia()
    {
        return $this->idMedia;
    }

    /**
     * Set the value of idMedia
     *
     * @return  self
     */ 
    public function setIdMedia($idMedia)
    {
        $this->idMedia = $idMedia;

        return $this;
    }

    /**
     * Get the value of typeMedia
     */ 
    public function getTypeMedia()
    {
        return $this->typeMedia;
    }

    /**
     * Set the value of typeMedia
     *
     * @return  self
     */ 
    public function setTypeMedia($typeMedia)
    {
        $this->typeMedia = $typeMedia;

        return $this;
    }

    /**
     * Get the value of nomMedia
     */ 
    public function getNomMedia()
    {
        return $this->nomMedia;
    }

    /**
     * Set the value of nomMedia
     *
     * @return  self
     */ 
    public function setNomMedia($nomMedia)
    {
        $this->nomMedia = $nomMedia;

        return $this;
    }

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get the value of modificationDate
     */ 
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Set the value of modificationDate
     *
     * @return  self
     */ 
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * Get the value of idPost
     */ 
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * Set the value of idPost
     *
     * @return  self
     */ 
    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;

        return $this;
    }
}
?>