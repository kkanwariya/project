<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Shubham Jain">

    <title>Search | Book Management</title>

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
        //display content;
      }?>
      <h3> Search for a book </h3></br>
    <form name="htmlform" method="post" action="update.php">
    <h5  style="margin: 30px;"> Leaving everything empty will display the whole record </h5>
    <table width="450px">
    <td valign="top">
     <input  type="hidden" name="id" maxlength="30" size="30" value="Search">
    </td>
    <tr>
     <td valign="top">
      <label>Book Name</label>
     </td>
     <td valign="top">
      <input  type="text" name="bname" maxlength="50" size="30" style="margin-bottom: 20px;">
     </td>
    </tr>

    <tr>
     <td valign="top">
      <label>Book Author</label>
     </td>
     <td valign="top">
      <input  type="text" name="bauthor" maxlength="50" size="30" style="margin-bottom: 20px;">
     </td>
    </tr>

   <tr>
     <td valign="top">
      <label>Book ISBN</label>
     </td>
     <td valign="top">
      <input  type="text"  name="bisbn" maxlength="50" size="30" style="margin-bottom: 20px;">
     </td>
    </tr>

    <tr>
     <td colspan="2" style="text-align:center">
      <input type="submit" value="Submit">
     </td>
    </tr>

    </table>
    </form>

    <!--================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="./css/bootstrap.min.js"></script>
    <script src="./css/offcanvas.js"></script>

  </body>
</html>
