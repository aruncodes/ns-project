<?php
   function getConnection()
   {
	  $con=mysqli_connect('127.0.0.1','root','root','ns-ajax');
	  if(mysqli_connect_errno())
	  {
		 echo "Failed to connect: ".mysqli_connect_error();
		 exit();
	  }
	  return $con;
   }
   $con=getConnection();
   $query = mysqli_query($con,"SELECT * FROM news");
   $rows = array();
   while($row = mysqli_fetch_assoc($query)) {
	  $rows[] = $row;
   }
   print json_encode($rows);
   mysqli_close($con);
?>

