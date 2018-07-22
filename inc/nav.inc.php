  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <nav class="navbar navbar-default ggg">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://www.tccollege.org">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li><a href="Request-leave.php">Request Leave</a></li>
        <li><a href="leave-status.php">Leave Status</a></li>
         <li><a href="Report.php">Report</a></li>
        
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $login_session;?><span class="caret"></span></a>
          <ul class="dropdown-menu">
          <?php   //include('funtion.php');


                  $username=$_SESSION['username'];
            $ur = MYSQLI_QUERY($connection,"SELECT designation FROM sign_in WHERE username='$username' ") OR DIE("PROBLEM TO GETTING designation");
$ur1 = MYSQLI_FETCH_ASSOC($ur);
$des = $ur1['designation'];

                ?>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Change Password</a></li>
            <?php if($des=="hod") {        ?>
            <li><a href="adduser.php">Add User</a></li>
            <li><a href="bdbackup.php">Backup Database</a></li>
            <?php } ?>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
