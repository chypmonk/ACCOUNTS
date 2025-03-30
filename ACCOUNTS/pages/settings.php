<?php


if ($_SERVER ["REQUEST_METHOD"] == "POST" ) { 
    $_SESSION['accounts-counter']++;
    if (isset ($_POST['newcategory'])) {   
        $newcategory = createRecordId ($_POST['newcategory']) ;   
        if ($newcategory) {
              addNameToArray ('data/categories.txt', $newcategory,',');    
        }
        else {
              echo "<div class = 'error'>Invalid characters in name</div>";
        }   
    }
    	
	else if (isset ($_POST['submit-credentials'])) { 
        if (isset ($_POST['username'])) {
            file_put_contents ("data/username.txt", $_POST['username']);
        }
        if (isset ($_POST['password'])) {
            file_put_contents ("data/password.txt", $_POST['password']);
        }
        $username = file_get_contents ("data/username.txt");
        $password = file_get_contents ("data/password.txt");
    }
    else if (isset ($_POST['removearray'])) {    
         foreach ($_POST['removearray'] as $item) {           
            removeNameFromArray ('data/categories.txt', $item, ',') ;
        }
    }
}
    
?>
<h2>Manage Categories</h2><br>
   
<form method = 'post' action = 'index.php?page=settings'>         
    <h4>New Category</h4><input type = 'text' name = 'newcategory' /><br>
    <br><br> <input  class = 'submitbutton' type = 'submit' name = 'submit' value='Submit'> 
</form> 


<form method = 'post' action = 'index.php?page=settings'>         
    <h4>All categories - check to remove</h4><br>
    <?php
    $array1 = readArray("data/categories.txt", ',');
    foreach ($array1 as $item) {
        echo "<input type = 'checkbox' name = 'removearray[]' value = '" . $item . "' />";
        echo "<a href = 'index.php?page=update-category&category=" .  $item . "'>";
        echo  ucwords (str_replace ('-', ' ', $item))  . "<a><br>";       
    }  
   
    ?>
    <input  class = 'submitbutton' type = 'submit' name = 'remove' value='Remove'> 
</form>
<br><br><h4>Trash</h4>
<?php   
echo "<button class = 'pink-button' onclick = 'setCheckboxes()'>Remove All</button>";
echo "<form method = 'post' action = 'index.php?page=settings'>";


$array1 = scandir ("data/trash");  
foreach ($array1 as $item) {
    if ($item !== '.' &&  $item !== "..") {   
        $array2 = explode ("----", $item);
        echo "  <input id = 'restore-" . $item . "'  type= 'checkbox' name = 'restorearray[]' value = '".$item . "' />";
        echo "<label for = 'restore-" . $item . "'>Restore </label>"; 
        echo "&nbsp; &nbsp; &nbsp; ";
        echo " <input class = 'checkbox' id = 'remove-" . $item . "'  type= 'checkbox' name = 'removearray[]'  value = '".$item . "'/>";
        echo "<label for = 'remove-" . $item . "'>Delete </label>";  
        echo "&nbsp; &nbsp; &nbsp; ";
        echo $item . "<br>";  
        } 
}
echo "<br><br><input class = 'submitbutton' name = 'submit-trash' type = 'submit' value = 'Submit' />";
echo "</form>"; 
?>



    
 

