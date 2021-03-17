<?php

class Education extends Database {

    //properties
    public $id;
    public $university;
    public $eduName;
    public $eDescription;
    public $start_date;
    public $end_date;

    // get all posts
    public function getAll() {
        $q = 'SELECT * FROM susanneni_portfolio.education ORDER BY start_date DESC';
        // $q = 'SELECT * FROM suni_portfolio.education ORDER BY start_date DESC';

        $stmt = $this->connect()->prepare($q);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    // get single post from db
    public function getOne($id) {
        $q = 'SELECT * FROM susanneni_portfolio.education WHERE id =' . $id;
        // $q = 'SELECT * FROM suni_portfolio.education WHERE id =' . $id;

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
        // $q = 'INSERT INTO suni_portfolio.education
        $q = 'INSERT INTO susanneni_portfolio.education
            SET
                university = :university,
                eduName = :eduName,
                eDescription = :eDescription,
                start_date = :start_date,
                end_date = :end_date';

        $stmt = $this->connect()->prepare($q);

        //strip data of tags
        $this->university = htmlspecialchars(strip_tags($this->university));
        $this->eduName = htmlspecialchars(strip_tags($this->eduName));
        $this->eDescription = htmlspecialchars(strip_tags($this->eDescription));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));

        // bind data
        $stmt->bindParam(':university', $this->university);
        $stmt->bindParam(':eduName', $this->eduName);
        $stmt->bindParam(':eDescription', $this->eDescription);
        $stmt->bindParam('start_date', $this->start_date);
        $stmt->bindParam('end_date', $this->end_date);

        if($stmt->execute()) {
            return true;
        } else {
            printif('Error: %s.\n', $stmt->error);
            return false;
        }
    }

    // update post in database
    public function updatePost($id) {
        // $q = 'UPDATE suni_portfolio.education
        $q = 'UPDATE susanneni_portfolio.education
         SET
            university = :university,
            eduName = :eduName,
            eDescription = :eDescription,
            start_date = :start_date,
            end_date = :end_date
        WHERE
            id = :id';

        $stmt = $this->connect()->prepare($q);

        //strip data of tags
        $this->university = htmlspecialchars(strip_tags($this->university));
        $this->eduName = htmlspecialchars(strip_tags($this->eduName));
        $this->eDescription = htmlspecialchars(strip_tags($this->eDescription));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));

        //bind data
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':university', $this->university);
        $stmt->bindParam(':eduName', $this->eduName);
        $stmt->bindParam(':eDescription', $this->eDescription);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);

        if($stmt->execute()) {
            return true;
        } else {
            printif('Error: %s.\n', $stmt->error);
            return false;
        }
    }

    // delete post from db
    public function deletePost($id) {
        $stmt = $this->connect()->prepare('DELETE FROM susanneni_portfolio.education WHERE id= ' . $id);
        // $stmt = $this->connect()->prepare('DELETE FROM suni_portfolio.education WHERE id= ' . $id);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}