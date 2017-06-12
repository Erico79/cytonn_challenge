<?php

/**
 * Created by PhpStorm.
 * User: developer1
 * Date: 6/12/17
 * Time: 1:33 PM
 */
class Masterfile
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function get($role){
        $records = $this->db->query('SELECT * FROM masterfiles WHERE role = :role', array(
            'role' => $role
        ));

        $drivers = [];
        if(count($records)){
            foreach ($records as $record) {
                $drivers[] = [
                    'id' => $record['id'],
                    'name' => $record['surname'] . ' '. $record['firstname'] . ' ' . $record['middlename']
                ];
            }
        }
        return $drivers;
    }

    public function getDriver($id){
        $this->db->bind("role", "driver");
        $this->db->bind("id", $id);

        $driver = $this->db->single("SELECT CONCAT(surname,' ',firstname,' ',middlename) as driver_name, id 
          FROM masterfiles WHERE role = :role AND id = :id");

        return $driver;
    }

    public function store(){
        $surname = $_POST['surname'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];

        $saved = $this->db->query('INSERT INTO masterfiles(surname, firstname, middlename, role) 
          VALUES(:surname, :firstname, :middlename, :role)', array(
            'surname' => $surname,
            'firstname' => $fname,
            'middlename' => $lname,
            'role' => 'participant'
        ));

        if($saved){
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
}