<?php
session_start(); 
//Prevent to many submissions during session
if (!isset ($_SESSION['accounts-counter'])) { 
    $_SESSION['accounts-counter'] = 0;
}

include ("inc/database-definitions.php");
//include ("inc/functions-no-write.php");
include ("inc/functions.php");
$pageid = "home";
if (isset($_GET['page'])) {
    $pageid = $_GET['page'];
}

include ("inc/header.php");  
echo "<main>";
if (!file_exists ("pages/". $pageid . ".php") ){                 
echo "This admin page does not exist";
}
else {       
    //Limit number of submissions during a session - 7 on live website, 100 for github code
    if ($_SESSION['accounts-counter'] >= 100) {
        echo "<h4>Too many submissions during this session</h4>";
    }
    else {
        include ("pages/" . $pageid . ".php");
    }
}
echo "</main>";
include ("inc/footer.php");

?>
