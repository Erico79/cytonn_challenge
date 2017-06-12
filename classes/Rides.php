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
    private $user;

    public function __construct()
    {
        $this->db = new DB();
        $this->user = new User();
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
                'capacity' => $capacity,
                'space_available' => $capacity
            ));

        if($created_by){
            $_SESSION['success'] = 'Ride has been saved succesfully!';
        } else {
            $_SESSION['error'] = 'Failed to create ride!';
        }
    }

    public function getRide()
    {
        if ($this->user->isLoggedIn()) {
            $ride_id = $_POST['ride_id'];
            $booked_by = $_SESSION['user_id'];
            $space_available = $this->checkForSpace($ride_id);

            // check for available space
            if($space_available) {
                // create booking
                $saved = $this->db->query('INSERT INTO bookings(ride_id, booked_by) 
                    VALUES(:ride_id, :booked_by)', array(
                        'ride_id' => $ride_id,
                        'booked_by' => $booked_by
                ));

                if($saved){
                    $space_available -= 1;

                    // update the spaces available
                    $updated = $this->db->query('UPDATE rides SET space_available = :spaces 
                        WHERE id = :ride_id', array('spaces' => $space_available, 'ride_id' => $ride_id));

                    if($updated) {
                        $_SESSION['success'] = 'Booking has been made!';
                    }
                }
            } else {
                $_SESSION['error'] = 'Sorry! There are no spaces available for this ride';
            }
        }
    }

    public function checkForSpace($ride_id) {
        $ride = $this->db->query('SELECT * FROM rides WHERE id = :ride_id', array('ride_id' => $ride_id), PDO::FETCH_OBJ);

        return $ride[0]->space_available;
    }

    public function checkRideWasBooked($user_id, $ride_id) {

    }
}