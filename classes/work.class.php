<?php

class Work extends Database {

    // properties
    public $id;
    public $employer;
    public $workTitle;
    public $description;
    public $workStart_date;
    public $workEnd_date;

    // get all posts
    public function getAll() {
        $q = 'SELECT * FROM susanneni_portfolio.work';
        // $q = 'SELECT * FROM suni_portfolio.work';
        
        $stmt = $this->connect()->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get single post from db
    public function getOne($id) {
        $q = 'SELECT * FROM susanneni_portfolio.work WHERE id =' . $id;
        // $q = 'SELECT * FROM suni_portfolio.work WHERE id =' . $id;

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
        // $q = 'INSERT INTO suni_portfolio.work
        $q = 'INSERT INTO susanneni_portfolio.work
            SET
                employer = :employer,
                workTitle = :workTitle,
                description = :description,
                workStart_date = :workStart_date,
                workEnd_date = :workEnd_date';

        $stmt = $this->connect()->prepare($q);

        //strip data of tags
        $this->employer = htmlspecialchars(strip_tags($this->employer));
        $this->workTitle = htmlspecialchars(strip_tags($this->workTitle));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->workStart_date = htmlspecialchars(strip_tags($this->workStart_date));
        $this->workEnd_date = htmlspecialchars(strip_tags($this->workEnd_date));

        //bind data
        $stmt->bindParam(':employer', $this->employer);
        $stmt->bindParam(':workTitle', $this->workTitle);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':workStart_date', $this->workStart_date);
        $stmt->bindParam(':workEnd_date', $this->workEnd_date);

        if($stmt->execute()) {
            return true;
        } else {
            printif('Error: %s.\n', $stmt->error);
            return false;
        }
    }

    // update post in database
    public function updatePost($id) {
        //$q = 'UPDATE suni_portfolio.work
        $q = 'UPDATE susanneni_portfolio.work
        SET
            employer = :employer,
            workTitle = :workTitle,
            description = :description,
            workStart_date = :workStart_date,
            workEnd_date = :workEnd_date
        WHERE
            id = :id';

        $stmt = $this->connect()->prepare($q);

        //strip data of tags
        $this->employer = htmlspecialchars(strip_tags($this->employer));
        $this->workTitle = htmlspecialchars(strip_tags($this->workTitle));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->workStart_date = htmlspecialchars(strip_tags($this->workStart_date));
        $this->workEnd_date = htmlspecialchars(strip_tags($this->workEnd_date));

        //bind data
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':employer', $this->employer);
        $stmt->bindParam(':workTitle', $this->workTitle);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':workStart_date', $this->workStart_date);
        $stmt->bindParam(':workEnd_date', $this->workEnd_date);

        if($stmt->execute()) {
            return true;
        } else {
            printif('Error: %s.\n', $stmt->error);
            return false;
        }
    }

    // delete post from db
    public function deletePost($id) {
        $stmt = $this->connect()->prepare('DELETE FROM susanneni_portfolio.work WHERE id= ' . $id);
        // $stmt = $this->connect()->prepare('DELETE FROM suni_portfolio.work WHERE id= ' . $id);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}