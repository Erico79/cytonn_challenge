<?php
    require('classes/Database.php');
    require('classes/Rides.php');

    $ride = new Rides();
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
            <div class="col-md-8 col-lg-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading"><i class="fa fa-list"></i> Available Rides</div>
                    <div class="panel-body">

                        <table id="available_rides" class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Origin</td>
                                    <td>Destination</td>
                                    <td>Space Available</td>
                                    <td>Driver</td>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                                $rides = $ride->all();
                                if(count($rides)){
                                    foreach ($rides as $ride){
                            ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
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