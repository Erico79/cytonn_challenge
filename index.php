<?php
    session_start();
    require('classes/Database.php');
    require('classes/Masterfile.php');
    require('classes/Rides.php');
    require('classes/User.php');

    $ride = new Rides();
    $mf = new Masterfile();
    $user = new User();

    if(isset($_POST['action'])){
        switch ($_POST['action']) {
            case 'create_ride':
                $ride->store();
                break;

            case 'register':
                $user->store();
                break;

            case 'user_login':
                $user->userLogin($_POST['email'], $_POST['password']);
                break;

            case 'logout':
                $user->logout();
                break;

            case 'get_a_ride':
//                $rider->getRide($_POST[]);
                break;
        }
    }
?>
<html>
    <head>
        <title>Home | Shareride Inc.</title>

        <!--bootstrap css-->
        <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

        <!--custom css-->
        <link href="assets/css/app.css" rel="stylesheet"/>

        <!--datatables css-->
        <link href="assets/datatables/dataTables.bootstrap.min.css" rel="stylesheet"/>

        <!--font awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="container-fluid">
            <?php include 'includes/nav.php'; ?>
        </div>

        <div class="row">
            <div class="col-md-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading"><i class="fa fa-car"></i> Available Rides</div>
                    <div class="panel-body">

                        <?php include 'includes/flash.php'; ?>

                        <table id="available_rides" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Origin</td>
                                    <td>Destination</td>
                                    <td>Space Available</td>
                                    <td>Driver</td>
                                    <td></td>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                                $rides = $ride->availableRides();
                                if(count($rides)){
                                    foreach ($rides as $ride){
                            ?>
                                <tr>
                                    <td><?=$ride['origin']; ?></td>
                                    <td><?=$ride['destination']; ?></td>
                                    <td><?=$ride['space_available']; ?></td>
                                    <td><?=$mf->getDriver($ride['driver']); ?></td>
                                    <td><button class="btn btn-xs" data-toggle="modal" data-target="#get_ride">Get a Ride</button></td>
                                </tr>
                            <?php }} ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!--jquery lib-->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <!--bootstrap js-->
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <!--datatables js-->
        <script src="assets/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/dataTables.bootstrap.min.js"></script>

        <!--custom js-->
        <script src="assets/js/index.js"></script>
    </body>
</html>