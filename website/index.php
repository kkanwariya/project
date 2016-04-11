<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Shubham Jain">

    <title>Book Management</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/offcanvas.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style="padding:50px 50px 0px 50px;margin:30px">
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
      <?php 
      session_start();	
      if (isset($_SESSION['username']) && !empty($_SESSION['username']))
      {
      	echo ' <div class="navbar-header" style="float:right">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <form name="htmlform" method="post" action="update.php">
			<input  type="hidden" name="id" value="logout">
			<input type="submit" style="border:0px;background-color: transparent;color:#999999;font-size:30px" value="Logout">
			</form>
	        </div>
	        <div class="collapse navbar-collapse">
         <ul class="nav navbar-nav" >
        <li><a href="./index.php" style="font-size: 20px">Home</a></li>
            <li><a href="./search.php" style="font-size: 20px">Search</a></li>
            <li><a href="./history.php" style="font-size: 20px">History</a></li>';
            if ($_SESSION['admin']){
              echo '
              <li><a href="./insert.php" style="font-size: 20px">Insert Book</a></li>
              <li><a href="./issue.php" style="font-size: 20px">Issue</a></li>
            <li><a href="./return.php" style="font-size: 20px">Return</a></li>
            <li><a href="./customer.php" style="font-size: 20px">Customer</a></li>';
            } 
	        echo  '</ul>
	        </div><!-- /.nav-collapse -->
	      </div><!-- /.container -->
	    </div><!-- /.navbar -->
		<!-- check if the session is set. if it is display the home page of the user -->';
        // <a class="navbar-brand" href="./index.php" style="font-size:30px;">'.$_SESSION['username'].'</a>
        //display homepage;
		echo '<h2> Welcome '.$_SESSION["username"].'</h2>';
		echo '<h3>Your Customer Id is '.$_SESSION["cid"]."</h3>";
		//
		$servername = "localhost";
		$username = "root";
		$password = "shubh";
		$dbname = "project";
		$issuedays = 15;
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		else{
			$sql="SELECT `dateissue`, `expiration`, `bname`, `bid` FROM `issue` WHERE cid='$_SESSION[cid]'";
			$result = $conn->query($sql);
			 if (mysqli_num_rows($result) > 0)
			{
				echo "</br></br><h3>Book that you have issued</h3></br>";
				echo '<table style="width:80%"><tr><th>Bookname</th><th>Book Id</th><th>Date of Issue</th><th>Date of Expiration</th></tr>';
				while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
					echo '<tr>';
					echo '<td>'.$row['bname'].'</td>'.'<td>'.$row['bid'].'</td>'.'<td>'.$row['dateissue'].'</td>'.'<td>'.$row['expiration'].'</td>';
					echo '</tr>';
				}
				echo "</table>";
			}
			else
			{
				echo "<h3>You have no books issued so far</h3>";
			}
			$sql="SELECT `fine` FROM `customer` WHERE cid='$_SESSION[cid]'";
			$result = $conn->query($sql);
			$row = mysqli_fetch_assoc($result);
			echo "</br><h4>Fine:".$row['fine']."</h4>";

		}
    	}
	else
	{
		echo '
        <div class="collapse navbar-collapse">
         <ul class="nav navbar-nav" >
	          </ul>
	        </div><!-- /.nav-collapse -->
	      </div><!-- /.container -->
	    </div><!-- /.navbar -->';

		echo '<div style="float:left;margin: 10px;padding:80px;border-right: solid black;">
	 <h2>Login</h2>
	 <form name="htmlform" method="post" action="update.php">
	  <table width="450px">
	  <td valign="top">
	   <input  type="hidden" name="id" maxlength="30" size="30" value="login" style="margin-bottom: 20px;">
	  </td>
	  <tr>
	   <td valign="top">
	    <label>Username</label>
	   </td>
	   <td valign="top">
	    <input  type="text" name="username" maxlength="50" size="30" style="margin-bottom: 20px;">
	   </td>
	  <tr>
	   <td valign="top">
	    <label>Password</label>
	   </td>
	   <td valign="top">
	    <input  type="password" name="password" maxlength="50" size="30" style="margin-bottom: 20px;">
	   </td>
	  </tr>
	  <tr>
	   <td colspan="2" style="text-align:center">
	    <input type="submit" value="Submit">
	   </td>
	  </tr>
	  </table>
	  </form>
	 </div>
	  <div style="float:right;margin: 10px;padding:20px;">
	<h2>Add Member</h2>
	  <form name="htmlform" method="post" action="update.php">
	  <table width="450px">
	  </tr>
	  <td valign="top">
	   <input  type="hidden" name="id" maxlength="30" size="30" value="signup" style="margin-bottom: 20px;">
	  </td>
	  <tr>
	   <td valign="top">
	    <label>Username</label>
	   </td>
	   <td valign="top">
	    <input  type="text" name="username" maxlength="50" size="30" style="margin-bottom: 20px;">
	   </td>
	  </tr>
	  <tr>
	   <td valign="top">
	    <label>Name</label>
	   </td>
	   <td valign="top">
	    <input  type="text" name="cname" maxlength="50" size="30" style="margin-bottom: 20px;">
	   </td>
	  </tr>

	 <tr>
	   <td valign="top">
	    <label>Email</label>
	   </td>
	   <td valign="top">
	    <input  type="text"  name="cemail" maxlength="50" size="30" style="margin-bottom: 20px;">
	   </td>
	  </tr>
	  <tr>
	   <td valign="top">
	    <label>Address</label>
	   </td>
	   <td valign="top">
	    <input  type="text" name="caddress" maxlength="50" size="30" style="margin-bottom: 20px;">
	   </td>
	  </tr>
	  <tr>
	   <td valign="top">
	    <label>Password</label>
	   </td>
	   <td valign="top">
	    <input  type="password" name="password" maxlength="50" size="30">
	   </td>
	  </tr>
	  <tr>
	   <td colspan="2" style="text-align:center">
	    <input type="submit" value="Submit">
	   </td>
	  </tr>
	  </table>
	  </form>
	  </div>';
	}
	 ?>
    <!--================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="./css/bootstrap.min.js"></script>
    <script src="./css/offcanvas.js"></script>

  </body>
</html>
