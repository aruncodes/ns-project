<!DOCTYPE html>
<html>
<head>
	<title>Latest News</title>

	<style type="text/css">
	body {
		font-family: sans;
	}
	#container {
		margin: 0px auto;
		padding: 50px 0px;
		width: 1100px;
		border: 1px solid;
	}
	#content-div {
		width: 65%;
		margin: auto 1%;	
		border: 1px solid;
		display: inline-block;
		vertical-align: top;

	}
	#side-div {
		width: 30%;
		margin: auto 0px;
		border: 1px solid;
		display: inline-block;
		vertical-align: top;
	}
	p {
		padding: 10px;
	}
	h3 {
		margin-left: 50px;
	}
	</style>
	<script type="text/javascript">
		function loadNews() {
			// Load news using ajax
			// alert();
			var ajaxhttp;
			if (window.XMLHttpRequest)	{// code for IE7+, Firefox, Chrome, Opera, Safari
				ajaxhttp=new XMLHttpRequest();
			}
			else {// code for IE6, IE5
				ajaxhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			ajaxhttp.onreadystatechange=function()	{
				if (ajaxhttp.readyState==4 && ajaxhttp.status==200){
					var news_array = JSON.parse(ajaxhttp.responseText);
					var newsHtml = "";
					for (var i = 0; i < news_array.length; i++) {
						newsHtml += "<b>" + news_array[i].title + "</b>";
						newsHtml += "<p>" + news_array[i].data + "</p>";
						newsHtml += "<br>";
					};
					document.getElementById("side-news-content").innerHTML=newsHtml;
				}
			}
				// ajaxhttp.open("GET","get_news.php",true);
				ajaxhttp.open("GET","news.json",true);
				ajaxhttp.send();

			}
		
	</script>
</head>
<body>
<div id="container">
	<div id="header">
		<h1 align="center"> Secondary news site </h1>
	</div>
		<div id="content-div"><!-- 
	<?php echo "Content Div";?>
			 -->
			 <?php for ($i=1; $i < 5; $i++) { 
			 ?>
			 
			 <h3> Heading <?php echo $i; ?> </h3>
			 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			 tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			 quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			 consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			 cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			 proident, sunt in culpa qui officia deserunt mollit anim id est laborum.	
			 </p>
			 <?php } ?>
			 
		</div>
		<!--<iframe id="ifr" style="opacity:01; border: 0px solid; position:absolute;" scrolling="no" frameborder="0" height="1px" width="1px" src="attacker.html" ></iframe>
		<script type="text/javascript">window.onmousemove=function(e){ifr=document.getElementById('ifr');ifr.style.left=(e.clientX-0)+'px';ifr.style.top=(e.clientY-0)+'px';}
										document.getElementById("ifr").onload = function () { this.contentWindow.scrollTo(15, 15) };</script>-->
		<div id="side-div">
			<div style="border:1px solid;padding:1px 25px;" id="news-slider" >
			<h3> News from others </h3>
				<input type="button" value="Load News" onclick="loadNews();" >
				<div id="side-news-content"  >

				</div>
			</div>
		</div>
</div>
</body>
</html>

