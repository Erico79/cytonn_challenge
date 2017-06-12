<?php
//require 'Database.php';
/**
 * Created by PhpStorm.
 * User: developer1
 * Date: 6/12/17
 * Time: 11:51 AM
 */
class Rides
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function all(){
        $rides = $this->db->query('SELECT * FROM rides');
        return $rides;
    }

    public function store(){

    }
}