<?php
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
	      $where .= ' bauthor = '. '\''.$_POST['bauthor'].'\'' ;
      }
      else
      {
	      $where .= ' and 1 ' ;
      }
      if (!empty($_POST['bisbn']))
      {
	      $where .= ' bisbn = '. '\''.$_POST['bisbn'].'\'' ;
      }
      else
      {
	      $where .= ' and 1 ' ;
      }
	  $sql = "SELECT `bid`, `bname`, `bisbn`, `bauthor`, `bedition`, `nbooks` FROM `book` WHERE ".$where;

	$result = $conn->query($sql);
?>