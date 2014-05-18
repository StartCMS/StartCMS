<?php

/*
 * Object table for a news database
 */

class newsUI extends core {
    /*
     * Getting a list of news
     */

    function get_news() {
        $index = 'id';
        $query = "SELECT * FROM `news` ORDER BY `date` DESC";
        $result = $this->db->query($query);
        if (is_object($result))
            while ($row = $result->fetch_assoc())
                if ($index !== false)
                    $rows[$row[$index]] = $row;
                else
                    $rows[] = $row;

        if (isset($rows))
            return $rows;

        return array();
    }

    /*
     * Getting news by id
     */

    function get($id) {
        $query = "SELECT * FROM `news` WHERE `id` = '" . $this->db->real_escape_string($id) . "'";
        return $this->db->query($query)->fetch_assoc();
    }

    /*
     * Adding new news
     */

    function add_news($name, $text) {
        $query = "INSERT INTO `news` (`name`,`text`) VALUES ('" . $this->db->real_escape_string($name) . "','" . $this->db->real_escape_string($text) . "')";
        return $this->db->query($query);
    }

    /*
     * change news
     */

    function edit_news($id, $name, $text) {
        $query = "UPDATE `news` SET `name` = '" . $this->db->real_escape_string($name) . "', `text` = '" . $this->db->real_escape_string($text) . "' WHERE `id` = '" . $this->db->real_escape_string($id) . "'";
        return $this->db->query($query);
    }

    /*
     * Deleting news
     */

    function delete_news($id) {
        $query = "DELETE FROM `news` WHERE `id` = '" . $this->db->real_escape_string($id) . "'";
        return $this->db->query($query);
    }

}
