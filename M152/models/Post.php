<?php
class Post
{
    private $idPost;
    private $commentaire;
    private $creationDate;
    private $modificationDate;
    private $compteurPost;

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

    /**
     * Get the value of commentaire
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set the value of commentaire
     *
     * @return  self
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

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
     * Get the value of modification
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Set the value of modification
     *
     * @return  self
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * Get the value of compteurPost
     */ 
    public function getCompteurPost()
    {
        return $this->compteurPost;
    }

    /**
     * Set the value of compteurPost
     *
     * @return  self
     */ 
    public function setCompteurPost($compteurPost)
    {
        $this->compteurPost = $compteurPost;

        return $this;
    }

    // recup tout les post
    public static function getAllPosts()
    {
        $req = MonPdo::getInstance()->prepare("SELECT * FROM Post");
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post'); // methode de fetch
        $req->execute(); // executer la requette

        $result = $req->fetchAll();
        return $result;
    }

    // ajoute un post dans la base de données
    public static function AddPost(Post $post)
    {
        $commentaire = $post->getCommentaire();
        $creationDate = $post->getCreationDate();
        $modificationDate = $post->getModificationDate();

        $req = MonPdo::getInstance()->prepare('INSERT INTO Post(commentaire, creationDate, modificationDate) VALUES(:Commentaire, :CreationDate, :ModificationDate);');
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');
        $req->bindParam(':Commentaire', $commentaire);
        $req->bindParam(':CreationDate', $creationDate);
        $req->bindParam(':ModificationDate', $modificationDate);
        $req->execute(); // executer la requette

        return MonPdo::getInstance()->lastInsertId();
    }
    // le nombre de post
    public static function CountAllPosts()
    {
        $req = MonPdo::getInstance()->prepare("SELECT COUNT(idPost) as 'compteurPost' FROM Post;");
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');
        $req->execute(); // executer la requette
        $res = $req->fetch();
        return $res->getCompteurPost();
    }


    // Supprime un post en fonction de l'id du post
    public static function DeletePost($idPost)
    {
        $req = MonPdo::getInstance()->prepare("DELETE FROM Post WHERE idPost = :idPost");
        $req->bindParam(":idPost", $idPost);
        $req->execute();
    }

}
