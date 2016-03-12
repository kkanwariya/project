<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "kame1234!";
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
  $result = $conn->query($sql);
}
elseif($_POST['id']  == "insert")
{
  $sql = "INSERT INTO `book`(`bname`, `bisbn`, `bauthor`, `bedition`, `nbooks`) VALUES ('$_POST[bname]', $_POST[bisbn], '$_POST[bauthor]', $_POST[bedition], $_POST[nbooks])";
  $result = $conn->query($sql);
}
elseif ($_POST['id'] == "customer")
{
  $sql = "INSERT INTO `customer`(`cid`, `cname`, `cemail`, `caddress`) VALUES ('$_POST[cid]', '$_POST[cname]', '$_POST[cemail]', '$_POST[caddress]')";
  $result = $conn->query($sql);

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

echo "</br><a href='index.php'>Go Back</a>";
$conn->close();
?>

</body>
</html>
