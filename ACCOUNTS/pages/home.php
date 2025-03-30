
<a class = 'menuitem' href = 'index.php?page=add-update-account'>Add New Account</a> 

<?php

$categories = readArray ('data/categories.txt', ',');
echo "<div>";
sort($categories);
foreach ($categories as $cat) { 
    $cat = trim ($cat);
    $selectedaccounts = selectMapEntries ('data/category-account-map.txt',  $cat, '');

    echo "</div><div class = 'box'>";
    echo "<h4>" . ucwords(str_replace ('-', ' ', $cat)) . "</h4><br>";    
    
    $array1 = scandir ("data/accounts");
   
    foreach ($array1 as $item) {
        if ($item !== "." && $item !== ".."){
            $accountid = str_replace (".txt", "", $item);
            if (in_array ($accountid, $selectedaccounts)) {
                      
                $accountrecord = readDatabaseRecord($accountrecordkeys, 'data/accounts/' . $accountid . '.txt');
                
                echo "<a  class = 'gridcolumn' href = 'index.php?page=display-account&account=" . $accountid . "'>" . $accountrecord['name'] .  "</a>";    
            }
        }
    }
    
}
echo "</div>";


echo "<h2>All Accounts</h2>"; 
echo "<div class = 'box'>";
$array1 = scandir ("data/accounts");
foreach ($array1 as $item) {
    if ($item !== "." && $item !== ".."){
        $accountid = str_replace (".txt", "", $item);
        $accountrecord = readDatabaseRecord($accountrecordkeys, 'data/accounts/' . $accountid . '.txt');
        echo "<a  class = 'gridcolumn' href = 'index.php?page=display-account&account=" . $accountid . "'>" . $accountrecord['name'] . " </a>";
        
    }
}   
echo "</div>";
echo "<br><br><br><h2>Uncategorized</h2>";
$array1 = scandir ("data/accounts");
foreach ($array1 as $item) {
    if ($item !== "." && $item !== ".."){
        $accountid = str_replace (".txt", "", $item);
        $selectedarray = selectmapEntries ('data/category-account-map.txt', '', $accountid);
       
        if (! $selectedarray) {           
            $accountrecord = readDatabaseRecord($accountrecordkeys, 'data/accounts/' . $accountid . '.txt');      
            echo "<a  class = 'gridcolumn' href = 'index.php?page=display-account&account=" . $accountid . "'>" . $accountrecord['name'] .  "</a>";   
        }        
    }
}

    ?>