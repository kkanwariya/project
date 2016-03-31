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
    <body style="padding:50px 50px 0px 50px">
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
      <?php 
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
            <li><a href="./issue.php" style="font-size: 30px">Issue</a></li>
            <li><a href="./return.php" style="font-size: 30px">Return</a></li>
            <li><a href="./insert.php" style="font-size: 30px">Insert Book</a></li>
            <li><a href="./return.php" style="font-size: 30px">Return</a></li>
            <li><a href="./search.php" style="font-size: 30px">Search</a></li>

            </ul>
          </div><!-- /.nav-collapse -->
        </div><!-- /.container -->
      </div><!-- /.navbar -->
    <!-- check if the session is set. if it is display the home page of the user -->';
        // <a class="navbar-brand" href="./index.php" style="font-size:30px;">'.$_SESSION['username'].'</a>
        //display content;
   echo '<h2>Issue a Book</h2>
  <form name="htmlform" method="post" action="update.php">
  <table width="450px">
  </tr>
  <td valign="top">
   <input  type="hidden" name="id" maxlength="30" size="30" value="issue">
  </td>
  <tr>
   <td valign="top">
    <label>Book Id</label>
   </td>
   <td valign="top">
    <input  type="text" name="bid" maxlength="50" size="30">
   </td>
  </tr>
  <tr>
   <td valign="top">
    <label>Customer id</label>
   </td>
   <td valign="top">
    <input type="text" name="cid" maxlength="50" size="30">
   </td>
  </tr>

  </tr>
  <tr>
   <td colspan="2" style="text-align:center">
    <input type="submit" value="Submit">
   </td>
  </tr>
  </table>
  </form>';
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
    echo '<a href="./index.php" style="font-size:30px;">Please login or Signup</a>';
  }
   ?>
    
	  
    <!--================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="./css/bootstrap.min.js"></script>
    <script src="./css/offcanvas.js"></script>

	
  </body>
</html>