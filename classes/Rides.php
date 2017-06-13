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

    public function find($id){
        $this->db->bind('id', $id);
        $ride = $this->db->query('SELECT * FROM rides WHERE id = :id');
        return $ride[0];
    }

    public function store(){
        $driver = $_POST['driver'];
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $deadline = $_POST['deadline'];
        $created_by = 1;
        $capacity = $_POST['capacity'];

        $saved = $this->db->query('INSERT INTO rides
            (driver, origin, destination, deadline, capacity, space_available) 
            VALUES(:driver, :origin, :destination, :deadline, :capacity, :space)', array(
                'driver' => $driver,
                'origin' => $origin,
                'destination' => $destination,
                'deadline' => $deadline,
                'capacity' => $capacity,
                'space' => $capacity
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

            // validate booking
            if($this->checkIfRideWasBooked($booked_by, $ride_id)){
                $_SESSION['warning'] = 'You have already booked this ride!';
                return false;
            }

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
                        // send confirmation
                        $this->sendBookingConfirmation($ride_id);

                        $_SESSION['success'] = 'Booking has been made!';
                    }
                }
            } else {
                $_SESSION['error'] = 'Sorry! There are no spaces available for this ride';
            }
        }
    }

    public function sendBookingConfirmation($ride_id){
        $ride = $this->find($ride_id);

        $user = $this->user->getAuthUser();
        $message = "Dear customer, \n";
        $message .= "You have booked for the following ride:\n";
        $message .= "Origin: " . $ride['origin'] . "\n";
        $message .= "Destination: " . $ride['destination'] . "\n";
        $message .= "Booking Deadline: " . $ride['deadline'] . "\n";
        $message .= "Thank you!";

        // send confirmation email
        return mail($user['email'], 'Booking Confirmation', $message);
    }

    public function checkForSpace($ride_id) {
        $ride = $this->db->query('SELECT * FROM rides WHERE id = :ride_id', array('ride_id' => $ride_id), PDO::FETCH_OBJ);

        return $ride[0]->space_available;
    }

    public function checkIfRideWasBooked($user_id, $ride_id) {
        $this->db->bind('ride_id', $ride_id);
        $this->db->bind('user_id', $user_id);
        $booked = $this->db->query('SELECT * FROM bookings WHERE ride_id = :ride_id AND booked_by = :user_id');

        if(count($booked))
            return true;
        return false;
    }
}