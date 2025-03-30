<?php

$accountid =  getFromQueryString ('account');
$accountrecord = assignPostValuesToRecord ($_POST, $accountrecordkeys); 
if ($_SERVER ["REQUEST_METHOD"] == "POST" ) {  
    $_SESSION['accounts-counter']++;
    
    $error = false;
    //Check if new account
    if (!$accountid ) {  
        if (isset ($_POST['name']))  {   
            $accountid = createRecordId ($_POST['name']);
        }
        if ($accountid === '') {
            echo "<div class = 'error'>Unable to create account id from name</div>";
            $error = true;  
        }
        //Check if file already exists
        else if  (file_exists ('data/accounts/' . $accountid . '.txt')) {                
            echo "<div class = 'error'>Account already exists</div>";              
            $error = true;
        }   
    }
    //Check for missing information
    $categories = array();
    if (isset ($_POST['categories'])) {
        $categories = $_POST['categories'];
    }
    if (!$categories) {
        echo "<div class = 'error'>Select a category</div>";
        $error = true;
    }     
    if (!$accountrecord['username']) {
            echo "<div class = 'error'>Select a username</div>";
            $error = true;
    }
    if (!$accountrecord['password']) {
        echo "<div class = 'error'>Select a password</div>";
        $error = true;
    }    
    
    if (!$error) {         
        writeDatabaseRecord($accountrecord, 'data/accounts/' . $accountid . '.txt');   

        removeMapEntries ("data/category-account-map.txt", '', $accountid);
        foreach ($categories as $item) {
            addMapEntry ("data/category-account-map.txt", $item, $accountid);
        }
    }
    
}
echo "<div class = 'content-column'>";
if ($accountid) {
    $accountrecord = readDatabaseRecord($accountrecordkeys, 'data/accounts/' . $accountid . '.txt');
    echo "<h2>Edit account: " . $accountrecord['name'] . "</h2>";
}
else {
    
    echo "<h2>Add account</h2>";

}


echo "<form method = 'post' action = 'index.php?page=add-update-account&account=" . $accountid . "'>";
echo "<div class = 'half-column'>";
echo "<label for= 'name-id' >Name</a><br>";
echo "<input id = 'name-id' type = 'text' name = 'name' value = '" . $accountrecord ['name'] . " '/>";

echo "<br><br><label for= 'url-id' >URL</a><br>";
echo "<input id = 'url-id' type = 'text' name = 'url' value = '" . $accountrecord ['url'] . " '/>";

echo "<br><br>Categories: <br>";
$selectedarray = selectMapEntries ('data/category-account-map.txt', '', $accountid);
$categories = readArray ("data/categories.txt", ',');

foreach ($categories as $item) {
    $item = trim ($item);       
    if (in_array ($item,  $selectedarray)) {
        echo "<input type = 'checkbox' name = 'categories[]' value = '" . $item . "'  checked />" . $item ;
    }
    else {
        echo "<input type = 'checkbox' name = 'categories[]' value = '" . $item . "' />" . $item ;
    }
    echo "<br>";         

}
echo "</div><div class = 'half-column'>";


echo "<label for= 'username-id' >Username</a><br>";
echo "<input id = 'username-id' type = 'text' name = 'username' value = '" . $accountrecord ['username'] . " '/>";

echo "<br><br><label for= 'password-id' >Password</a><br>";
echo "<input id = 'password-id' type = 'text' name = 'password' value = '" . $accountrecord ['password'] . " '/>";

echo "<br><br><label for= 'details-id' >Details</a><br><br>";
echo "<textarea name = 'details' id = 'details-id' cols = '80' rows = '10'>" . $accountrecord ['details'] . " </textarea>";
echo "</div>";
echo "<br><br><input class = 'submitbutton' type = 'submit' name = 'submit' value = 'Submit'>";
echo "</form>";

echo "</div><div class = 'sidebar-column'>";
echo "<a class = 'adminbutton' href = 'index.php'>&larr; Home</a>";
echo "<a class = 'adminbutton' href = 'index.php?page=display-account&account=" . $accountid . "'>View</a>";
echo "<a class = 'adminbutton' href = 'index.php?page=remove-account&account=" . $accountid . "'>Remove</a>";
echo "</div>";
  ?>
  