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

    public function availableRides(){
        $rides = $this->db->query('SELECT * FROM rides WHERE deadline >= :deadline', array(
            'deadline' => date('Y-m-d')
        ));
        return $rides;
    }

    public function store(){
        $driver = $_POST['driver'];
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $deadline = $_POST['deadline'];
        $created_by = 1;
        $capacity = $_POST['capacity'];

        $saved = $this->db->query('INSERT INTO rides
            (driver, origin, destination, deadline, capacity) 
            VALUES(:driver, :origin, :destination, :deadline, :capacity)', array(
                'driver' => $driver,
                'origin' => $origin,
                'destination' => $destination,
                'deadline' => $deadline,
                'capacity' => $capacity
            ));

        if($created_by){
            $_SESSION['success'] = 'Ride has been saved succesfully!';
        } else {
            $_SESSION['error'] = 'Failed to create ride!';
        }
    }
}