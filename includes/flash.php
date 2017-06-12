<?php if(isset($_SESSION['success'])){ ?>
<div class="alert alert-success">
    <button class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> <?=$_SESSION['success']; ?>
</div>
<?php unset($_SESSION['success']); } ?>

<?php if(isset($_SESSION['error'])){ ?>
<div class="alert alert-success">
    <button class="close" data-dismiss="alert">&times;</button>
    <strong>Error!</strong> <?=$_SESSION['success']; ?>
</div>
<?php unset($_SESSION['error']); } ?>