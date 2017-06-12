<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Shareride Inc.</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" data-toggle="modal" data-target="#give_ride">Give a Ride</a></li>
                <li><a href="index.php">Available Rides</a></li>
                <li><a href="#" class="login-btn">Sign In</a></li>
                <li><a href="#" class="reg-btn">Register</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!--Create Ride Modal-->
<div id="give_ride" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Give a Ride!</h4>
            </div>
            <div class="modal-body">

                <form role="form" method="POST" action="" class="form-horizontal">

                    <div class="form-group">
                        <label for="origin" class="col-md-4 control-label">Origin</label>
                        <div class="col-md-6">
                            <input id="origin" type="text" name="origin" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="destination" class="col-md-4 control-label">Destination</label>
                        <div class="col-md-6">
                            <input id="destination" type="text" name="destination" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="capacity" class="col-md-4 control-label">Capacity of Vehicle</label>
                        <div class="col-md-6">
                            <input id="capacity" type="number" min="1" name="capacity" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deadline" class="col-md-4 control-label">Booking Deadline</label>
                        <div class="col-md-6">
                            <input id="deadline" type="date" name="deadline" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="driver" class="col-md-4 control-label">Driver</label>
                        <div class="col-md-6">
                            <select name="driver" id="driver" class="form-control" required>
                            <option value="">--Select Driver--</option>
                            <?php
                                $drivers = $mf->get('driver');
                                if(count($drivers)) {
                                    foreach ($drivers as $driver) {
                            ?>
                            <option value="<?=$driver['id']; ?>"><?=$driver['name']; ?></option>
                            <?php }} ?>
                        </select>
                        </div>
                    </div>

                    <input type="hidden" name="action" value="create_ride"/>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </div>
</div>