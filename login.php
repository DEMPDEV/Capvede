<?php
session_start();
$_SESSION['ID'];
if ($_SESSION['ID'])
	header("Location: index.php");
function LogIn()
{
    $con = mysqli_connect("","","","");
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $IP = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $IP = $_SERVER['REMOTE_ADDR'];
    }
	if((isset($_GET["u"]) AND !empty($_POST['Password'])) OR !empty($_POST['Email']) AND !empty($_POST['Password']))
	{
		if (isset($_GET["u"]))
		{
			$user = (string)$_GET["u"];
			$query1 = "SELECT * FROM `Users` WHERE ID='".mysqli_real_escape_string($con,$user)."'";
		} else {
			$query = "SELECT * FROM `Users` WHERE Email='".mysqli_real_escape_string($con,$_POST['Email'])."'";
        }
		if ($query)
			$result = mysqli_query($con,$query);
		else
			$result1 = mysqli_query($con,$query1);
		if ($result)
			$row = mysqli_fetch_array($result);
		else
			$row1 = mysqli_fetch_array($result1);
		if($row['Email'] OR $row1['ID']){
			if(($row['Password'] == md5(md5($_POST['Email']).$_POST['Password'])) OR ($row1['Password'] == md5(md5($row1['Email']).$_POST['Password'])))
			{
				$year = time() + 31536000;
				if ($row){
					$_SESSION['ID'] = $row['ID'];
					$_SESSION['isAdmin']=$row['isAdmin'];
					$_SESSION['Name']=$row['Name'];
					$_SESSION['Email']=$row['Email'];
					$_SESSION['IP']=$row['IP'];
				} else {
					$_SESSION['ID'] = $row1['ID'];
					$_SESSION['isAdmin']=$row1['isAdmin'];
					$_SESSION['Name']=$row1['Name'];
					$_SESSION['Email']=$row1['Email'];
					$_SESSION['IP']=$row1['IP'];
				}
				setcookie('email', $_SESSION['Email'], $year);
				echo"Logged in";
				header("Location: index.php");
			}else{
				echo '<script type="text/javascript"> window.onload = function () { alert("Incorrect Email or Password"); } </script>';
			}
        }else{
			echo '<script type="text/javascript"> window.onload = function () { alert("Account does not exist"); } </script>';
		}
	}
	else
	{
		echo '<script type="text/javascript"> window.onload = function () { alert("Please fill the form"); } </script>';
	}
}

function getName()
{
	$user = (string)$_GET["u"];
	$con = mysqli_connect("","","","");
	$query = "SELECT * FROM `Users` WHERE `ID`='".mysqli_real_escape_string($con,$user)."'";
	$result = mysqli_query($con,$query);
	$row = mysqli_fetch_array($result);
	echo $row['Name'];
}

if(isset($_POST['login']))
{
    LogIn();
}
?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome Home</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/templatemo-style.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div id="loader-wrapper">
            <div id="loader"></div>
        </div>
        <div class="content-bg"></div>
        <div class="bg-overlay"></div>
        <!-- SITE TOP -->
        <div class="site-top">
            <div class="site-header clearfix">
                <div class="container">
					<?php if (!isset($_GET["u"])) { ?>
						<a href="index.php" class="site-brand pull-left"><strong>Welcome</strong></a>
					<?php } ?>
                </div>
            </div> <!-- .site-header -->
			<div class="site-banner">
                <div class="container">
                    <div class="row">
                        <form action="" method="post" class="subscribe-form">
							<?php if (isset($_GET["u"])) { ?>
							<h1>Hello <?php echo getName(); ?>, welcome back</h1>
							<?php } else { ?>
							<fieldset class="col-md-offset-4 col-md-3 col-sm-8">
                                <input type="email" id="txtfield" name="Email" placeholder="Your email">
                            </fieldset>
							<?php } ?>
							<fieldset class="col-md-offset-4 col-md-3 col-sm-8">
                                <input type="password" id="txtfield" name="Password" placeholder="Password">
                            </fieldset>
							<a href="changepass.php" class="site-brand pull-left">Forgot your password?</a>
                            <fieldset class="col-md-5 col-sm-4">
                                <input type="submit" id="subscribe-submit" name="login" class="button white" value="Log in!">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div> <!-- .site-banner -->
        </div> <!-- .site-top -->
        <!-- FOOTER -->
        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="copyright-text">Copyright &copy; 2017 <a rel="nofollow" href="https://play.google.com/store/apps/developer?id=Heavy+Gem">Heavy Gem</a></p>
                    </div>
                </div>
            </div>
        </footer>
        <script src="js/vendor/jquery-1.10.2.min.js"></script>
        <script src="js/min/plugins.min.js"></script>
        <script src="js/min/main.min.js"></script>
        <!-- Preloader -->
        <script type="text/javascript">
            //<![CDATA[
            $(window).load(function() {
                $('#loader').fadeOut();
                    $('#loader-wrapper').delay(350).fadeOut('slow');
                $('body').delay(350).css({'overflow-y':'visible'});
            })
            //]]>
        </script>
    </body>
</html>