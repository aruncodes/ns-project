<html>
<head><title>Add New User</title></head>

<body>
<?php
session_start();
if(!$_SESSION['admin'])
{
   echo "Unauthorized operation.";
   exit(0);
}
?>

<form action="news_server.php" method="POST">
<input name="uname" />
<input type="password" name="pass" />
<input type="hidden" name="addUserFormPosted" value="done" />
<input type="submit" value="Add User" />
</form>
</body>

</html>
