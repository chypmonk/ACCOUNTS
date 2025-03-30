<?php
//Copyright (c) 2021, Susan V. Rodgers, Lila Avenue, LLC,  lilaavenue@gmail.com 

echo "<div class = 'content-column'>";

$accountid = "";
if (isset ($_GET["account"])){   
    $accountid = filter_input(INPUT_GET, "account", FILTER_SANITIZE_STRING) ;  
}

if ($_SERVER ["REQUEST_METHOD"] == "POST" ) {   
    $_SESSION['accounts-counter']++;
   if (isset($_POST ['removeflag'])) {
      $removeflag = trim($_POST['removeflag']);
      if ($removeflag === "REMOVE") {
          
          if (file_exists ("data/accounts/" . $accountid . ".txt")) {              
              moveToTrash ("accounts", $accountid);        
             echo "<h2>Account removed</h2>";            
              
          }
      }  
   }
}

if (file_exists ("data/accounts/" . $accountid . ".txt") ) { 
    
    echo "<h2>Remove account: " .  $accountid . "</h2>";    
    ?>
    <form method = 'post' action = 'index.php?page=remove-account&account=<?php echo $accountid ;?>'>  

        <h3>Are you sure you want to move <?php echo $accountid ; ?> to the Trash Bin?</h3><br>
        NO: <input type = 'radio' name = 'removeflag' value = '' checked />            
        YES <input type = 'radio' name = 'removeflag' value = 'REMOVE' />  
        <br><br><input class = 'submitbutton' type = 'submit' name = 'submit' value='Remove'/>

    </form>   
  <?php
}
else {
    echo "<h2>This account has been removed</h2>";
}
echo "</div><div class = 'sidebar-column'>";
echo "<a class = 'adminbutton' href = 'index.php?page=home'>Return </a><br>";

echo "</div>";
?>
  

  