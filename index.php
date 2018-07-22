<?php
        session_start();
        require_once('connect.php');

        print_r($_SESSION);
        if(isset($_SESSION['username']) & !empty($_SESSION['username']))
        {
        
          header('location:login.php');
        }
        if(isset($_POST) & !empty($_POST))
        {
            $username=$_POST['username'];

            $password=$_POST['password'];

            $sql="SELECT * FROM sign_in where username='$username 'AND password='$password' ";
              //var_dump($connection);
            $ress=mysqli_query($connection,$sql) or die ("faild to execute queryy");
             //var_dump($ress);
            $count=mysqli_num_rows($ress);
             if($count==1)
             {
                $_SESSION['username']=$username;
                  header('location:login.php');
             }
             else
              $fmsg="PLEASE CHECK USER NAME AND PASSSWORD";
        }
  ?>
            <?php include("./inc/header.inc.php"); ?>
                <body style="background-image: url('home.jpg'); background-size:100% 100%;
              background-repeat: no-repeat;  background-size:none;
              ">    
              <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
              <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div>/<?php } ?>

            <form class="form-signin" method="POST">
                <h2 class="form-signin-heading">Login</h2>
                <div class="input-group">
        	     <span class="input-group-addon" id="basic-addon1">@</span>
        	     <input type="text" name="username" class="form-control" placeholder="Username" required>
        	     </div>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="password" id="inputPassword" class="form-control vg" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                <a class="btn btn-lg btn-primary btn-block" href="forgot-password.php">Forgot Password</a>
            </form>

      </body>
  </html>
