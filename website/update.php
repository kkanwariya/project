<html>
<body>
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
  $sql = "INSERT INTO `issue`(`dateissue`, `expiration`, `bookname`, `bookid`, `cid`) VALUES ('$dat','$exp','$bname','$_POST[bid]','$_POST[cid]')";
  $result = $conn->query($sql);
}
elseif($_POST['id']  == "insertbook")
{
  $sql = "INSERT INTO `book`(`bname`, `bisbn`, `bauthor`, `bedition`, `nbooks`) VALUES ('$_POST[bname]', $_POST[bisbn], '$_POST[bauthor]', $_POST[bedition], $_POST[nbooks])";
  $result = $conn->query($sql);
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
  $sql = "SELECT `issueid`, `dateissue`, `expiration`, `bookname`, `bookid`, `cid` FROM `issue` WHERE `bookid`=$_POST[bid] and cid = $_POST[cid]";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  echo "Issued Till  ";
  echo $row["expiration"];
  $dateissue = $row["dateissue"];
  $sql= "SELECT CURDATE() as da, DATE_ADD(CURDATE(),INTERVAL $issuedays DAY) as expdate";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  $datereturn=$row['da'];
  // echo $dateissue;
  $sql= "INSERT INTO `bookreturn`(`bid`, `cid`, `dateissue`, `datereturn`) VALUES ($_POST[bid], $_POST[cid], '$dateissue', '$datereturn')";
  $result = $conn->query($sql);
}
elseif($_POST['id'] == "logout")
{
	session_destroy(); 
	header('Location: index.php');
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
	  echo $sql;
	  $result = $conn->query($sql);
	  $result = $conn->query($sql);
	  if ($result->num_rows > 0){ ?>

	  	?>
		<table>
		<tr>
	    	<th>Book Name</th>
	    	<th>Book Author</th> 
	    	<th>Book ISBN</th>
	    	<th>Book Edition</th>
	    	<th>No of Books</th>
	  	</tr>
	  	<?php
	  	while($row = $result->fetch_assoc()) {
	        echo "<tr> <td>".$row[bname]."</td> <td>".$row[bisbn]."</td> <td>".$row[bauthor]."</td> <td>".$row[bedition]."</td> <td>".$row[nbooks]."</td>".$row[grade].'</td></tr>';
	    }
  	?>
	</table>


<?php
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