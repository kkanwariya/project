<?php
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
session_start();
if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
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
         <li><a href="./index.php" style="font-size: 30px">Home</a></li>
         <li><a href="./insert.php" style="font-size: 30px">Insert Book</a></li>
            <li><a href="./search.php" style="font-size: 30px">Search</a></li>';
            if ($_SESSION['admin']){
            	echo '<li><a href="./issue.php" style="font-size: 30px">Issue</a></li>
            <li><a href="./return.php" style="font-size: 30px">Return</a></li>';
            } 
	        echo  '</ul>
	        </div><!-- /.nav-collapse -->
	      </div><!-- /.container -->
	    </div><!-- /.navbar -->
		<!-- check if the session is set. if it is display the home page of the user -->';
        // <a class="navbar-brand" href="./index.php" style="font-size:30px;">'.$_SESSION['username'].'</a>
        //display homepage;
 }





echo '<html lang="en">
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
  <body style="padding:50px 50px 0px 50px">';
if ($_POST['id'] == "issue")
{
  $sql= "SELECT CURDATE() as da, DATE_ADD(CURDATE(),INTERVAL $issuedays DAY) as expdate";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  $dat=$row['da'];
  $exp=$row['expdate'];
  $sql= "SELECT bname from `book` where `bid`=$_POST[bid]";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  $bname=$row['bname'];
  $sql = "INSERT INTO `issue`(`dateissue`, `expiration`, `bname`, `bid`, `cid`) VALUES ('$dat','$exp','$bname','$_POST[bid]','$_POST[cid]')";
  $result = $conn->query($sql);
  if($result)
  {
	echo "Book Successfully Issued";
  }
  else
  {
	echo "Can't be Issued";
  }
}
elseif($_POST['id']  == "insert")
{
  $sql = "INSERT INTO `book`(`bname`, `bisbn`, `bauthor`, `bedition`, `nbooks`) VALUES ('$_POST[bname]', '$_POST[bisbn]', '$_POST[bauthor]', '$_POST[bedition]', '$_POST[nbooks]')";
  $result = $conn->query($sql);
  echo "Book Successfully Inserted";
  // echo $_POST[bname].$_POST[bisbn].$_POST[bauthor].$_POST[bedition].$_POST[nbooks];
}
elseif($_POST['id']  == "login")
{
	$pass=md5($_POST['password']);
	$sql="SELECT cid,admin FROM customer WHERE username='$_POST[username]' and password = '$pass'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0)
	{
		//start the session.
		$row = mysqli_fetch_assoc($result);
		$_SESSION["username"]=$_POST['username'];
		$_SESSION["cid"]= $row['cid'];
		$_SESSION["admin"]= $row['admin'];
		// echo 'hi' + $_SESSION['username'];
		header('Location: index.php');
	}
	else
	{
		echo "Incorrect username/password";
	}
}
elseif ($_POST['id'] == "signup")
{
  $pass=md5($_POST['password']);
  //check for uniqueness of username
  $sql = "SELECT * from customer Where username='$_POST[username]'";
  $result = $conn->query($sql);
  if (mysqli_num_rows($result) > 0)
	{
		echo "Sorry the username is already taken";
	}
	else{
	$sql = "INSERT INTO `customer`(`cname`, `cemail`, `caddress`,`username`, `password`) VALUES ( '$_POST[cname]', '$_POST[cemail]', '$_POST[caddress]', '$_POST[username]','$pass')";
	  $conn->query($sql);
	  //can remove the cid from display
	  $sql= "SELECT `cid` from `customer` WHERE cname ='$_POST[cname]' and cemail = '$_POST[cemail]' and caddress='$_POST[caddress]'";
	  $result = $conn->query($sql);
	  $row = mysqli_fetch_assoc($result);
	  echo "Your Customer ID is:";
	  echo $row['cid'];
	  $_SESSION["username"]=$_POST['username'];
	  $_SESSION["cid"]= $row['cid'];
	  $_SESSION["admin"]= 0;
	  // echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	  //i.e. till this point
	  header('Location: index.php');
	}
}

elseif ($_POST['id'] == "return")
{
  $sql = "SELECT `issueid`, `dateissue`, `expiration`, `bname`, `bid`, `cid` FROM `issue` WHERE `bid`=$_POST[bid] and cid = $_POST[cid]";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  echo "Issued Till  ";
  echo $row["expiration"]. '<br/>';
  $dateissue = $row["dateissue"];
  $sql= "SELECT CURDATE() as da, DATE_ADD(CURDATE(),INTERVAL $issuedays DAY) as expdate";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  $datereturn=$row['da'];
  // echo $dateissue;
  $sql= "INSERT INTO `bookreturn`(`bid`, `cid`, `datereturn`, `dateissue`) VALUES ($_POST[bid], $_POST[cid], '$datereturn', '$dateissue')";
  // echo $sql;
  $result = $conn->query($sql);
  if($result)
  {
	echo "Book Successfully Returned";
	$sql= "DELETE FROM `issue` WHERE `bid`=$_POST[bid] and cid = $_POST[cid]";
	$result = $conn->query($sql);
  }
  else
  {
	echo "Couldn't Return";
  }  
}
elseif($_POST['id'] == "logout")
{
	session_destroy(); 
	header('Location: index.php');
}

elseif($_POST['id'] == "showlist")
{
	$sql="SELECT `dateissue`, `expiration`, `bname`, `bid` FROM `issue` WHERE cid='$_SESSION[cid]'";
	$result = $conn->query($sql);
	 if (mysqli_num_rows($result) > 0)
	{
		echo "</br></br><h3>Book issued by".$_POST['cid']." </h3></br></br>";
		echo '<table style="width:80%"><tr><th>Bookname</th><th>Book Id</th><th>Date of Issue</th><th>Date of Expiration</th></tr>';
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			echo '<tr>';
			echo '<td>'.$row['bname'].'</td>'.'<td>'.$row['bid'].'</td>'.'<td>'.$row['dateissue'].'</td>'.'<td>'.$row['expiration'].'</td>';
	        echo'<td><form action="update.php" method="post">
			    <input  type="hidden" name="id" maxlength="30" size="30" value="return">
	        	<input type="hidden" name="cid" value='.$_POST['cid'].'>
	        	<input type="hidden" name="bid" value='.$row['bid'].'>
				<input type="submit" value="Return">
			</form></td></tr>';
		}
	}
}

elseif($_POST['id'] == "Search")
{
      if (!empty($_POST['bname']))
      {
	      $where = ' bname = '. '\''.$_POST['bname'].'\'' ;
      }
      else
      {
	      $where = ' 1 ' ;
      }
      if (!empty($_POST['bauthor']))
      {
	      $where .= ' and bauthor = '. '\''.$_POST['bauthor'].'\'' ;
      }
      if (!empty($_POST['bisbn']))
      {
	      $where .= ' and bisbn = '. '\''.$_POST['bisbn'].'\'' ;
      }
	  $sql = "SELECT `bid`, `bname`, `bisbn`, `bauthor`, `bedition`, `nbooks` FROM `book` WHERE ".$where;
	  // echo $sql;
	  $result = $conn->query($sql);
	  if ($result->num_rows > 0){ 

		echo '<table style="width:80%;margin-left:20px">
		<tr>
	    	<th>Book Name</th>
	    	<th>Book Author</th> 
	    	<th>Book ISBN</th>
	    	<th>Book Edition</th>
	    	<th>No of Books</th>
	  	</tr>';
	  	while($row = $result->fetch_assoc()) {
	        echo "<tr> <td>".$row['bname']."</td> <td>".$row['bisbn']."</td> <td>".$row['bauthor']."</td> <td>".$row['bedition']."</td> <td>".$row['nbooks']."</td></tr>";
	    }
	    echo'</table>';
		}
		// echo "echo";
		else
		{
			echo "Sorry !!! No Books Available ";
		}
	}

echo "</br><a href='index.php'>Go Back</a>";
$conn->close();
?>

</body>
</html>