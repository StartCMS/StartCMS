<?php

/*
 * Object table for a news database
 */

class newsUI extends core
{
    /*
     * Getting a list of news
     */

    function get_news()
    {
        $query = "SELECT * FROM `news` ORDER BY `date` DESC";
        $result = $this->db->query($query);

        return $result->fetchAll();
    }

    /*
     * Getting news by id
     */

    function get($id)
    {
        $query = "SELECT * FROM `news` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
        $sth->bindValue(':id', $id);
        $sth->execute();

        return $sth->fetch();
    }

    /*
     * Adding new news
     */

    function add_news($name, $text)
    {
        $query = "INSERT INTO `news` (`name`,`text`) VALUES (:name,:text)";
        $sth = $this->db->prepare($query);
        $sth->execute(array(
            'name' => $name,
            'text' => $text
        ));
        return $this->db->lastInsertId();
    }

    /*
     * change news
     */

    function edit_news($id, $name, $text)
    {
        $query = "UPDATE `news` SET `name` = :name, `text` = :text WHERE `id` = :id";
        $sth = $this->db->prepare($query);
        $sth->execute(array(
            'name' => $name,
            'text' => $text,
            'id' => $id
        ));
        return $sth->rowCount();
    }

    /*
     * Deleting news
     */

    function delete_news($id)
    {
        $query = "DELETE FROM `news` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->rowCount();
    }

}
