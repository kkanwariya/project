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
}
else if($_POST['id']  == 2)
{
  $result=$conn->query("SELECT MAX(`Cid`) as max FROM Customer");
  $row = mysqli_fetch_array($result);
  $highest = $row['max']+1;
  $sql = "INSERT INTO Customer(`Cname`, `City`, `Cid`)
  VALUES ('$_POST[cname]','$_POST[ccity]',$highest)";
}
//$sql = "INSERT INTO Branch (`Bname`, `Bcity`, `Assets`)
//VALUES ('$_POST[bname]', '$_POST[bcity]' ,'$_POST[assets]')";
if ($conn->query($sql) === TRUE) {
	echo "hi";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
echo "</br><a href='index.php'>Go Back</a>";
$conn->close();
?>

</body>
</html>
