<?php

class Project extends Database {

    // properties
    public $id;
    public $pTitle;
    public $pDescription;
    public $pUrl;
    public $pImg;

    // get all posts
    public function getAll() {
        // $q = 'SELECT * FROM susanneni_portfolio.projects';
        $q = 'SELECT * FROM suni_portfolio.projects';
        
        $stmt = $this->connect()->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get single post from db
    public function getOne($id) {
        // $q = 'SELECT * FROM susanneni_portfolio.projects WHERE id =' . $id;
        $q = 'SELECT * FROM suni_portfolio.projects WHERE id =' . $id;

        $stmt = $this->connect()->prepare($q);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result) {
            $result = array();
        }
        return $result;
    }
    
    // add post to database
    public function addPost() {
        // $q = 'INSERT INTO susanneni_portfolio.projects
        $q = 'INSERT INTO suni_portfolio.projects
            SET
                pTitle = :pTitle,
                pDescription = :pDescription,
                pUrl = :pUrl,
                pImg = :pImg';

        $stmt = $this->connect()->prepare($q);

        //strip data of tags
        $this->pTitle = htmlspecialchars(strip_tags($this->pTitle));
        $this->pDescription = htmlspecialchars(strip_tags($this->pDescription));
        $this->pUrl = htmlspecialchars(strip_tags($this->pUrl));
        $this->pImg = htmlspecialchars(strip_tags($this->pImg));

        //bind data
        $stmt->bindParam(':pTitle', $this->pTitle);
        $stmt->bindParam(':pDescription', $this->pDescription);
        $stmt->bindParam(':pUrl', $this->pUrl);
        $stmt->bindParam(':pImg', $this->pImg);

        if($stmt->execute()) {
            return true;
        } else {
            printif('Error: %s.\n', $stmt->error);
            return false;
        }
    }

    // update post in database
    public function updatePost($id) {
        // $q = 'UPDATE susanneni_portfolio.projects
        $q = 'UPDATE suni_portfolio.projects
        SET
            pTitle = :pTitle,
            pDescription = :pDescription,
            pUrl = :pUrl,
            pImg = :pImg
        WHERE
            id = :id';

        $stmt = $this->connect()->prepare($q);

        //strip data of tags
        $this->pTitle = htmlspecialchars(strip_tags($this->pTitle));
        $this->pDescription = htmlspecialchars(strip_tags($this->pDescription));
        $this->pUrl = htmlspecialchars(strip_tags($this->pUrl));
        $this->pImg = htmlspecialchars(strip_tags($this->pImg));

        //bind data
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':pTitle', $this->pTitle);
        $stmt->bindParam(':pDescription', $this->pDescription);
        $stmt->bindParam(':pUrl', $this->pUrl);
        $stmt->bindParam(':pImg', $this->pImg);

        if($stmt->execute()) {
            return true;
        } else {
            printif('Error: %s.\n', $stmt->error);
            return false;
        }
    }

    // delete post from db
    public function deletePost($id) {
        // $stmt = $this->connect()->prepare('DELETE FROM susanneni_portfolio.projects WHERE id= ' . $id);
        $stmt = $this->connect()->prepare('DELETE FROM suni_portfolio.projects WHERE id= ' . $id);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}