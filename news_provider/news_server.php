<?php
   if (session_id() == "")
   session_start();
?>

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
   //-------------------------------------------------LOGIN-------------------------------------------------
   if($_POST['loginFormPosted'])
   {
	  $con=getConnection();

	  $result = mysqli_query($con, "SELECT * FROM users where uname='".$_POST['uname']."' AND pass='".$_POST['pass']."'");

	  if(mysqli_num_rows($result) == 0)
	  {
		 echo "Invalid username/password";
		 $_SESSION['login']=false;
	  }
	  else
	  {
		 //echo "Login successful";
		 $row=mysqli_fetch_array($result);
		 if($row['uname'] == "admin")
		 {
			$_SESSION['admin']=true;
		 }
		 $_SESSION['login']=true;
	  }
	  mysqli_close($con);
   }

   //-------------------------------------------------LOGOUT-------------------------------------------------
   if($_POST['logoutFormPosted'])
   {
	  unset($_SESSION['login']);
	  session_destroy();
   }

   //-------------------------------------------------ADD NEWS-------------------------------------------------
   if($_POST['addNewsFormPosted'])
   {
	  $con=getConnection();
	  mysqli_query($con, "INSERT INTO news (time,title,data) VALUES('".time()."','".$_POST['newsTitle']."','".$_POST['newsData']."')");
	  echo "News Item Inserted.";
	  mysqli_close($con);
   }



   //-------------------------------------------------ADD NEW USER----------------------------------------------
   if($_POST['addUserFormPosted'])
   {
	  $con=getConnection();
	  $result=mysqli_query($con, "SELECT * FROM users WHERE uname='".$_POST['uname']."'");
	  if(mysqli_num_rows($result) != 0)
	  {
		 echo "Username already exists.";
		 exit;
	  }
	  mysqli_query($con, "INSERT INTO users values('".$_POST['uname']."', '".$_POST['pass']."')");
	  echo "User ".$_POST['uname']." added.";
	  mysqli_close($con);
   }
?>



<html>
   <head>
	  <title>News Server</title>
   </head>
   <body>
	  <?php
		 //--------------------------------LOGIN, LOGOUT and Add new User Link ---------------------------------------
		 if(!$_SESSION['login'])
		 {
		 ?>
		 <div name="loginFormDiv" id="loginFormDiv">
			<form name="loginForm" action="news_server.php" method="POST">
			   <table>
				  <tr>
					 <td>Name</td><td>:</td>
					 <td><input type="text" name="uname" /></td>
				  </tr>
				  <tr>
					 <td>Password</td><td>:</td>
					 <td><input type="password" name="pass" /></td>
				  </tr>
				  <tr>
					 <td><input type="submit" value="Login" /></td>
				  </tr>
			   </table>
			   <input type="hidden" name="loginFormPosted" value="done" />
			</form>
		 </div>
		 <?php
		 }
		 else
		 {
		 ?>
		 <div name="logoutFormDiv" id="logoutFormDiv">
			<form name="logoutForm" action="news_server.php" method="POST">
			   <input type="hidden" name="logoutFormPosted" value="done" />
			   <input type="submit" value="Logout" />
			</form>
		 </div>

		 <?php
			if($_SESSION['admin'])
			{
			?>
			<a href="addNewUser.php">Add a new User</a>
			<?php
			}

		 ?>


		 <!-- ----------------------------------------- Add News Item -------------------------------- -->
		 <div name="addNewsFormDiv" id="addNewsFormDiv">
			<form name="addNewsForm" action="news_server.php" method="POST">
			   <fieldset>
				  <legend>Add news item</legend>
				  <table>
					 <tr>
						<td>Title</td>
						<td><input type="text" name="newsTitle" /> </td>
					 </tr>
					 <tr>
						<td>News</td>
						<td><textarea name="newsData"></textarea> </td>
					 </tr>
					 <tr>
						<td> <input type="submit" value="Add News" /> </td>
					 </tr>
				  </table>
				  <input type="hidden" name="addNewsFormPosted" value="done" />
			   </fieldset>
			</form>
		 </div>
		 <?php
		 }
	  ?>


	  <!-- ------------------------------------ News Roller ---------------------------------------- -->
	  <div name="showNewsDiv" id="showNewsDiv">
		 <?php
			//code to display news
			$con=getConnection();
			$result=mysqli_query($con, "(SELECT * FROM news ORDER BY id DESC LIMIT 50) ORDER BY id ASC");
			while($row = mysqli_fetch_array($result))
			{
			   echo "<p class='timestamp'>".$row['time'].": </p>\n";
			   echo $row['title']."<br />\n";
			   echo $row['data'];
			   echo "\n<br /><br />";
			}
			mysqli_close($con);
		 ?>
	  </div>

   </body>
</html>
