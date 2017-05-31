<?php session_start();
if(isset($_SESSION["valid"])){
  //here sends the user to his personal page.
  header("Location: PersonalPage.php");
}?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Social School</title>

    <!-- css-->
    <link rel="stylesheet" type="text/css" href="vendors/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <!-- jQuery-->
    <script src="vendors/jquery/js/jQuery.js" type="text/javascript" xml:space="preserve"></script>

    <!-- jQuery Cookies management-->
    <script src="vendors/jquery/jquery-cookie/jquery.cookie.js" type="text/javascript" xml:space="preserve"></script>

    <!-- Angular-->
    <script src="vendors/angular/js/angular.min.js" type="text/javascript" xml:space="preserve"></script>
    <script src="vendors/angular/js/angular-file-upload.js" type="text/javascript" xml:space="preserve"></script>
    <script src="vendors/angular/js/angular-i18n/angular-locale_es-es.js" type="text/javascript" xml:space="preserve"></script>
    <script src="vendors/angular/js/ng-currency.js" type="text/javascript" xml:space="preserve"></script>
    <script src="vendors/angular/js/angular-cookies.js" type="text/javascript" xml:space="preserve"></script>
    <script src="vendors/angular/js/dirPagination.js" type="text/javascript" xml:space="preserve"></script>
    <script src="vendors/bootstrap/js/ui-bootstrap-tpls-2.3.1.js" type="text/javascript" xml:space="preserve"></script>
  </head>
  <body>
    <div class="image .col-md-8">
      <img src="https://haltonparents.files.wordpress.com/2013/08/teens-starting-high-school.jpg">
    </div>
    <div class="enlace .col-md-8">
      <a href="LogIn/login.php" class=".col-md-4">Log in</a><br><br>
    </div>
    <div class="enlace .col-md-4">
      <a href="LogIn/login.php" class=".col-md-4">Log in</a><br><br>
      <a href="Register/register.php" class=".col-md-4">Register</a>
    </div>
    </form>
  </body>
</html>
