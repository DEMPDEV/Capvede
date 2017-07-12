<?php
session_start();
$_SESSION['ID'];
if (isset($_GET["u"])){	
	$user = (string)$_GET["u"];	
	header('Location: login.php?u='.$user);
}
function getLinks(){
    $con = mysqli_connect("","","","");
	$query = "SELECT `ID`, `Title`, `Image`, `Description`, `Link` FROM `Links` WHERE `UserID`='".mysqli_real_escape_string($con,$_SESSION['ID'])."'";
	$result = mysqli_query($con,$query);	$row = mysqli_fetch_array($result);
	foreach($result as $row) {
		?>
		<div class="post-masonry col-md-2 col-sm-4">
			<div class="post-thumb">				<a href=<?php echo $row['Link'] ?> target="_blank">
					<img src=<?php echo $row['Image'] ?> alt=""/>				</a>
			</div>
		</div>
		<?php
	}
}

if(isset($_POST['login']))
	header("Location: login.php");
if(isset($_POST['logout']))	
	header("Location: logout.php");
if(isset($_POST['register']))	
	header("Location: register.php");
if(isset($_POST['add']))	
	header("Location: addlink.php");
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
                    <a href="index.php" class="site-brand pull-left"><strong>Welcome</strong><?php if ($_SESSION['ID']) { ?><?php echo $_SESSION['Name'];?><?php } ?></a>
                </div>
            </div> <!-- .site-header -->
			<div class="site-banner">
                <div class="container">
                    <div class="row">
                        <form action="#" method="post" class="subscribe-form">
                            <fieldset class="col-md-5 col-sm-4">
                                <input type="submit" id="subscribe-submit" name="home" class="button white" value="HOME">
								<?php if ($_SESSION['ID']) { ?>
								<input type="submit" id="subscribe-submit" name="logout" class="button white" value="LOG OUT">
								<input type="submit" id="subscribe-submit" name="add" class="button white" value="ADD LINK">
								<?php } else { ?>
								<input type="submit" id="subscribe-submit" name="login" class="button white" value="LOG IN">
								<input type="submit" id="subscribe-submit" name="register" class="button white" value="REGISTER">
								<?php } ?>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div> <!-- .site-banner -->
        </div> <!-- .site-top -->
        <!-- MAIN POSTS -->
        <div class="main-posts">
            <div class="container">
                <div class="row">
                    <div class="blog-masonry masonry-true">
					<?php if ($_SESSION['ID']) { ?>
					<?php echo getLinks(); ?>
					<?php } ?>
                    </div>
                </div>
            </div>
        </div>
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