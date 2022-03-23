<?php
class Media
{
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

    // Recup tous les médias en fonction de l'id du post
    public static function getAllMediasByPostId($idPost)
    {
        $req = MonPdo::getInstance()->prepare("SELECT * FROM Media WHERE idPost = :idPost;");
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Media'); // methode de fetch
        $req->bindParam(":idPost", $idPost);
        $req->execute(); // executer la requette

        $result = $req->fetchAll();
        return $result;
    }

    // Ajoute un média dans la base de données
    public static function AddMedia(Media $media)
    {
        $typeMedia = $media->getTypeMedia();
        $nomMedia = $media->getNomMedia();
        $creationDate = date("Y-m-d H:i:s");
        $modificationDate = date("Y-m-d H:i:s");
        $idPost = $media->getIdPost();
        $req = MonPdo::getInstance()->prepare('INSERT INTO Media(typeMedia, nomMedia, creationDate, modificationDate, idPost) VALUES(:typeMedia, :nomMedia, :creationDate, :modificationDate, :idPost)');
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Media'); //methode de fetch
        $req->bindParam(':typeMedia', $typeMedia);
        $req->bindParam(':nomMedia', $nomMedia);
        $req->bindParam(':creationDate', $creationDate);
        $req->bindParam(':modificationDate', $modificationDate);
        $req->bindParam(':idPost', $idPost);
        $req->execute(); // executer la requette
    }
    // supprime un media de la base de données en fonction de son id
    public static function DeleteMedia($idMedia)
    {
        $req = MonPdo::getInstance()->prepare("DELETE FROM Media WHERE idMedia = :idMedia");
        $req->bindParam(":idMedia", $idMedia);
        $req->execute();
    }
    // convertir les octect en Mo
    public static function ConvertOToMO($octets)
    {
        // 1mo = 1 048 576 octets
        return $octets / 1000000;
    }
    //Genere un nom random pour les images
    public static function GenerateRandomName()
    {
        $alphabet = range('a', 'z');
        $newName = "";
        for ($i = 0; $i < 26; $i++) {
            $newName .= $alphabet[rand(0, 25)];
        }
        return $newName;
    }
}
