<?php
include("minibots.class.php");
$mb = new Minibots();
session_start();
$_SESSION['ID'];
if (!$_SESSION['ID'])
	header("Location: index.php");

function ShowImages()
{
	global $mb;
	$img = $mb->youtubeGetVideos($_POST['Name']);
	echo $img;
	foreach($img as $key => $value) {
		?>
		<a href=<?php echo $value ?> target="_blank">
			<img src=<?php echo $value ?> alt=""/>
		</a>
		<?php
	}
}

function ShowImage()
{
	header("Location: https://www.google.com/search?site=&tbm=isch&source=hp&biw=1920&bih=947&q=".$_POST['Name']."");
}

function AddLink()
{
    $con = mysqli_connect("","","","");
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $IP = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $IP = $_SERVER['REMOTE_ADDR'];
    }
	if(!empty($_POST['Name']) AND !empty($_POST['Image']) AND !empty($_POST['Link'])) {
		$url = $_POST['Link'];
		$parse = parse_url($url);
		$query1 = "SELECT * FROM `Icons` WHERE `Link`='".mysqli_real_escape_string($con,$parse['host'])."'";
		$result1 = mysqli_query($con,$query1);
		$row = mysqli_fetch_array($result1);
		if ($row['Link']){
			$query = "INSERT INTO `Links` (`Title`,`Image`,`Link`, `UserID`) VALUES ('".mysqli_real_escape_string($con, $_POST['Name'])."','".mysqli_real_escape_string($con, $row['Image'])."','".mysqli_real_escape_string($con,  $_POST['Link'])."','".mysqli_real_escape_string($con, $_SESSION['ID'])."')";
		} else {
			$query = "INSERT INTO `Links` (`Title`,`Image`,`Link`, `UserID`) VALUES ('".mysqli_real_escape_string($con, $_POST['Name'])."','".mysqli_real_escape_string($con, $_POST['Image'])."','".mysqli_real_escape_string($con,  $_POST['Link'])."','".mysqli_real_escape_string($con, $_SESSION['ID'])."')";
		}
		$result = mysqli_query($con,$query);
		if($result) {
			echo '<script type="text/javascript"> window.onload = function () { alert("Link added!"); } </script>';
			header('Location: index.php');
		}else {
			echo '<script type="text/javascript"> window.onload = function () { alert("Error, please contact us"); } </script>';
		}
	}
	else {
		echo '<script type="text/javascript"> window.onload = function () { alert("Please fill the form"); } </script>';
	}
}

if(isset($_POST['add'])) {
    AddLink();
}
if(isset($_POST['showimg'])) {
    ShowImage();
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
                    <a href="index.php" class="site-brand pull-left"><strong>Welcome</strong>
					<?php if ($_SESSION['ID']) { ?>
					<?php echo $_SESSION['Name'];?>
					<?php } ?>
					</a>
                </div>
            </div> <!-- .site-header -->
            <div class="site-banner">
                <div class="container">
                    <div class="social-icons pull-left">
                        <ul>
                            <li><a href="https://www.facebook.com/" class="fa fa-facebook"></a></li>
                            <li><a href="https://twitter.com/" class="fa fa-twitter"></a></li>
							<li><a href="https://youtube.com/" class="fa fa-youtube"></a></li>
                        </ul>
                    </div>
                </div>
            </div> <!-- .site-banner -->
			<div class="site-banner">
                <div class="container">
                    <div class="row">
                        <form action="" method="post" class="subscribe-form">
							<fieldset class="col-md-offset-4 col-md-3 col-sm-8">
                                <input type="text" id="txtfield" name="Name" placeholder="Link title">
                            </fieldset>
							<fieldset class="col-md-5 col-sm-4">
                                <input type="submit" id="subscribe-submit" name="showimg" class="button white" value="Show image">
                            </fieldset>
							<fieldset class="col-md-offset-4 col-md-3 col-sm-8">
                                <input type="text" id="txtfield" name="Image" placeholder="Image link">
                            </fieldset>
							<fieldset class="col-md-offset-4 col-md-3 col-sm-8">
                                <input type="text" id="txtfield" name="Link" placeholder="Site link">
                            </fieldset>
                            <fieldset class="col-md-5 col-sm-4">
                                <input type="submit" id="subscribe-submit" name="add" class="button white" value="Add Link!">
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