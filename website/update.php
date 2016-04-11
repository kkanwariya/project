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
echo '';
if (isset($_SESSION['username']) && !empty($_SESSION['username']))
{
  	echo ' <div class="navbar-header" style="float:right">
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
    if ($_POST['id'] == "issue")
	{
	  $sql= "SELECT CURDATE() as da, DATE_ADD(CURDATE(),INTERVAL $issuedays DAY) as expdate";
	  $result = $conn->query($sql);
	  $row = mysqli_fetch_assoc($result);
	  $dat=$row['da'];
	  $exp=$row['expdate'];
		//check for the number of books issued
	  $sql= "SELECT bname,nissued,nbooks from `book` where `bid`=$_POST[bid]";
	  $result = $conn->query($sql);
	  $row = mysqli_fetch_assoc($result);
	  if ($row['nissued'] >= $row['nbooks'])
	  {
	  		echo "<h4> Sorry the all the copies of the book has been issued";
	  }
	  else
	  {
	  	  $bname=$row['bname'];
		  $sql = "INSERT INTO `issue`(`dateissue`, `expiration`, `bname`, `bid`, `cid`) VALUES ('$dat','$exp','$bname','$_POST[bid]','$_POST[cid]')";
		  $result = $conn->query($sql);
		  if($result)
		  {
		  	$nissue= $row['nissued']+1;
		  	$sql = "UPDATE `book` SET `nissued`='$nissue' WHERE `bid`=$_POST[bid]";
		  	$result = $conn->query($sql);
			echo "<h4> Book Successfully Issued</h4> ";
		  }
		  else
		  {
			echo "<h4> Can't be Issued due to some nontraceable error</h4> ";
		  }
	  }
		  
	}
	elseif($_POST['id']  == "insert")
	{
	  $sql = "INSERT INTO `book`(`bname`, `bisbn`, `bauthor`, `bedition`, `nbooks`) VALUES ('$_POST[bname]', '$_POST[bisbn]', '$_POST[bauthor]', '$_POST[bedition]', '$_POST[nbooks]')";
	  $result = $conn->query($sql);
	  echo "<h4>Book Successfully Inserted</h4>";
	}
	elseif ($_POST['id'] == "return")
	{
	  $sql = "SELECT * FROM `issue` WHERE `issueid`=$_POST[issueid]";
	  $result = $conn->query($sql);
	  $row = mysqli_fetch_assoc($result);
	  echo "<h4>Issued Till  ";
	  echo $row["expiration"]. '<br/></h4>';
	  $dateissue = $row["dateissue"];
	  $dateexp = $row["expiration"];
	  $bid=$row["bid"];
	  $cid=$row["cid"];
	  $sql= "SELECT CURDATE() as da, DATE_ADD(CURDATE(),INTERVAL $issuedays DAY) as expdate";
	  $result = $conn->query($sql);
	  $row = mysqli_fetch_assoc($result);
	  $datereturn=$row['da'];
	  $sql= "SELECT DATEDIFF('$datereturn','$dateexp') as diff";
	  $result = $conn->query($sql);
	  $row = mysqli_fetch_assoc($result);
	  if($row['diff']  > 0)
	  {
	  	 echo "<h4>Fine Imposed : ". ($row['diff'] *10);
	  	 $sql = "SELECT `fine` FROM `customer` WHERE cid = $cid";
	  	 $result = $conn->query($sql);
	  	 $row = mysqli_fetch_assoc($result);
	  	 $fine = $row['diff'] *10 + $row['fine'];
	  	 $sql = "UPDATE `customer` SET `fine`=$fine WHERE cid = $cid";
	  	 $result = $conn->query($sql);
	  	 //update fine
	  }
	  // echo $dateissue;
	  $sql= "INSERT INTO `bookreturn`(`bid`, `cid`, `datereturn`, `dateissue`) VALUES ('$bid', '$cid', '$datereturn', '$dateissue')";
	  // echo $sql;
	  $result = $conn->query($sql);
	  if($result)
	  {
		echo "Book Successfully Returned";
		$sql= "DELETE FROM `issue` WHERE `bid`=$bid and cid = $cid";
		$result = $conn->query($sql);
		$sql= "SELECT nissued from `book` where `bid`=$bid";
		$result = $conn->query($sql);
	  	$row = mysqli_fetch_assoc($result);
	  	$nissue=$row['nissued']-1;
	  	$sql = "UPDATE `book` SET `nissued`='$nissue' WHERE `bid`=$bid";
		$result = $conn->query($sql);
	  }
	  else
	  {
		echo "Couldn't Return";
	  }  
	}
	elseif($_POST['id'] == "showlist")
	{
		$where='';
		if (!empty($_POST['bid']))
	      {		
		      $where = ' bid = '. '\''.$_POST['bid'].'\'' ;
	      }
	    if(!empty($_POST['cid']))
	    {
	    	$where .= ' cid = '. '\''.$_POST['cid'].'\'' ;
	    }
	    if($where =='')
	    {
	    	$where=1;
	    }
		$sql="SELECT * FROM `issue` WHERE ".$where;
		$result = $conn->query($sql);
		 if (mysqli_num_rows($result) > 0)
		{
			if(!empty($_POST['cid']))
	    	{
				echo "</br></br><h3>Book issued by  customer with id ".$_POST['cid']." </h3></br></br>";
			}
			echo '<table style="width:80%"><tr><th>Cid</th><th>Customer username</th><th>Bookname</th><th>Book Id</th><th>Date of Issue</th><th>Date of Expiration</th></tr>';
			while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
			{
				$sql = "SELECT * FROM `customer` WHERE cid = ".$row['cid'];
	  	 		$result1 = $conn->query($sql);
	  	 		$row1 = mysqli_fetch_assoc($result1);
				echo '<tr>';
				echo '<td>'.$row['cid'].'</td>'.'<td>'.$row1['username'].'</td>'.'<td>'.$row['bname'].'</td>'.'<td>'.$row['bid'].'</td>'.'<td>'.$row['dateissue'].'</td>'.'<td>'.$row['expiration'].'</td>';
		        echo'<td><form action="update.php" method="post">
				    <input  type="hidden" name="id" maxlength="30" size="30" value="return">
		        	<input type="hidden" name="issueid" value='.$row['issueid'].'>
					<input type="submit" value="Return">
				</form></td></tr>';
			}
			echo "</table>";
		}
		else
		{
			echo "<h3> No books found !! </h3>";
		}
	}

	elseif($_POST['id'] == "Search")
	{
	      if (!empty($_POST['bname']))
	      {
		      $where = "bname like '%".$_POST['bname']."%'";
	      }
	      else
	      {
		      $where = ' 1 ' ;
	      }
	      if (!empty($_POST['bauthor']))
	      {
		      $where .= " and bauthor like '%".$_POST['bauthor']."%'";
	      }
	      if (!empty($_POST['bisbn']))
	      {
		       $where .= " and bisbn like '%".$_POST['bisbn']."%'";
	      }
		  $sql = "SELECT * FROM `book` WHERE ".$where;
		  // echo $sql;
		  $result = $conn->query($sql);
		  if ($result->num_rows > 0)
		  { 
		  		echo '<h3>Books : </h3>';
				echo '<table width="110%" style="margin-left:20px">
				<tr>
					<th>Book ID</th>
			    	<th>Name</th>
			    	<th>ISBN</th>
			    	<th>Author</th> 
			    	<th>Edition</th>
			    	<th>Total Books</th>
			    	<th>Available </th>
			    	<th>Show History</th>
			  	</tr>';
			  	while($row = $result->fetch_assoc())
			  	{
			        echo "<tr> <td>".$row['bid']."</td><td>".$row['bname']."</td> <td>".$row['bisbn']."</td> <td>".$row['bauthor']."</td> <td>".$row['bedition']."</td> <td>".$row['nbooks']."</td><td>".($row['nbooks'] - $row['nissued'])  ."</td>";
			        echo'<td><form action="update.php" method="post">
					    <input  type="hidden" name="id" maxlength="30" size="30" value="history">
			        	<input type="hidden" name="bid" value='.$row['bid'].'>
						<input type="submit" value="History">
					</form></td></tr>';
			    }
			    echo'</table>';
				}
				// echo "echo";
			else
			{
				echo "<h4>Sorry !!! No Books Available </h4>";
			}
	}
	elseif($_POST['id'] == "history")
	{
			$where='';
			if (!empty($_POST['bid']))
		      {		
			      $where = ' bid = '. '\''.$_POST['bid'].'\'' ;
		      }
		    if(!empty($_POST['cid']))
		    {
		    	$where .= ' cid = '. '\''.$_POST['cid'].'\'' ;
		    }
		    if($where =='')
		    {
		    	$where=1;
		    }

		  $sql = "SELECT * FROM `bookreturn` WHERE ".$where;
		  // echo $sql;
		  $result = $conn->query($sql);
		  if ($result->num_rows > 0)
		  { 
		  		echo '<h3>History : </h3>';
				echo '<table width="80%" style="margin-left:20px">
				<tr>
			    	<th>Customer ID</th>
			    	<th>Customer username</th>
			    	<th> Book Id </th>
			    	<th>Book Name</th>
			    	<th>Issue Date</th> 
			    	<th>Return Date</th>
			  	</tr>';
			  	while($row = $result->fetch_assoc())
			  	{
			  		$sql = "SELECT * FROM `customer` WHERE cid = ".$row['cid'];
		  	 		$result1 = $conn->query($sql);
		  	 		$row1 = mysqli_fetch_assoc($result1);
		  	 		$sql = "SELECT * FROM `book` WHERE bid = ".$row['bid'];
	  	 			$result2 = $conn->query($sql);
	  	 			$row2 = mysqli_fetch_assoc($result2);
			        echo "<tr> <td>".$row['cid']."</td><td>".$row1['username']."</td><td>".$row['bid']."</td> <td>".$row2['bname']."</td><td>".$row['dateissue']."</td> <td>".$row['datereturn']."</td></tr>";
			    }
			    echo'</table>';
		}
		else
		{
			echo "No one has issued the related thing yet";
		}
	}
	elseif($_POST['id'] == "customer")
	{
			$where='';
		    if(!empty($_POST['cid']))
		    {
		    	$where .= ' cid = '. '\''.$_POST['cid'].'\'' ;
		    }
		    if($where =='')
		    {
		    	$where=1;
		    }

		  $sql = "SELECT * FROM `customer` WHERE ".$where;
		  // echo $sql;
		  $result = $conn->query($sql);
		  if ($result->num_rows > 0)
		  { 
		  		echo '<h3>History : </h3>';
				echo '<table width="80%" style="margin-left:20px">
				<tr>
			    	<th>Customer ID</th>
			    	<th>Customer Name </th>
			    	<th>Customer Email</th>
			    	<th>Customer Address </th>
			    	<th>Customer Usernmae </th>
			    	<th>Fine</th>
			  	</tr>';
			  	while($row = $result->fetch_assoc())
			  	{
			        echo "<tr> <td>".$row['cid']."</td><td>".$row['cname']."</td> <td>".$row['cemail']."</td> <td>".$row['caddress']."</td><td>".$row['username']."</td><td>".$row['fine']."</td></tr>";
			    }
			    echo'</table>';
		}
		else
		{
			echo "No customers so far";
		}
	}


}

if($_POST['id']  == "login")
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
elseif($_POST['id'] == "logout")
	{
		session_destroy(); 
		header('Location: index.php');
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
	else
	{
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

echo "</br><h4><a href='index.php'>Go to homepage</a></h4>";
$conn->close();
?>
 <!--================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="./css/bootstrap.min.js"></script>
    <script src="./css/offcanvas.js"></script>

</body>
</html>