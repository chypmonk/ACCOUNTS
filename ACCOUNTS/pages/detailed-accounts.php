<br><br><div class = 'dropdownwrap'>
    <div class = 'dropdownbutton'  id = 'accounts-by-category'  onclick= 'accordionToggle(this.id)'><h2>Detailed Accounts by Category &nbsp;&#9662;</h2></div>
    <div id ='accounts-by-category-content' class = 'dropdowncontent1'  style =  'display: none;  '  >  
<?php

$categories = readArray ('data/categories.txt', ',');
//Detailed accounts by category
foreach ($categories as $cat) { 
    $cat = trim ($cat);
    echo "<div class = 'box'>";
    echo "<br><h3>Category: " . ucwords ($cat) . "</h3>";
    $selectedarray = selectMapEntries ('data/category-account-map.txt', $cat, '');
   
    $array1 = scandir ("data/accounts");
    foreach ($array1 as $item) {
        if ($item !== "." && $item !== ".."){
            $accountid = str_replace ('.txt', '', $item);
            
            if (in_array ($accountid, $selectedarray)) {
                $accountrecord = readDatabaseRecord($accountrecordkeys, 'data/accounts/' . $accountid . '.txt');         
                            
                echo "<a  href = 'index.php?page=display-account&account=" . $accountid . "'><h4>" . $accountrecord['name'] .  "</h4></a>"; 

                echo " &nbsp; <b>Username: </b> " . $accountrecord['username'] . "  &nbsp;<b>Password: </b> " . $accountrecord['password'] ;                

                if ($accountrecord['details'] !== "") {
                    echo  " &nbsp; <b> Details: </b>" . $accountrecord['details'];
                }                
                echo "<br>";
            }
        }
        
    }
    echo "</div>";
}
//Detailed accounts in alphabetical order
?>
</div></div>
<br>
<div class = 'dropdownwrap'>
    <div class = 'dropdownbutton'  id = 'accounts-alpha'  onclick= 'accordionToggle(this.id)'><h2>Detailed Accounts in Alphabetical Order &nbsp;&#9662;</h2></div>
    <div id ='accounts-alpha-content' class = 'dropdowncontent1'  style =  'display: none;  '  > 
<?php
echo "<br><br><h32>Accounts in Alphabetical Order</h3>"; 
$array1 = scandir ("data/accounts");
foreach ($array1 as $item) {
    if ($item !== "." && $item !== ".."){
        $accountid = str_replace (".txt", "", $item);        
        $accountrecord = readDatabaseRecord($accountrecordkeys, 'data/accounts/' . $accountid . '.txt');
         
        echo " <a  href = 'index.php?page=display-account&account=" . $accountid . "'><h4>" . $accountrecord['name'] .  "</h4></a>"; 

        echo " &nbsp; <b>Username: </b> " . $accountrecord['username'] . "  &nbsp;<b>Password: </b> " . $accountrecord['password'] ;                

        if ($accountrecord['details'] !== "") {
            echo  " &nbsp; <b> Details: </b>" . $accountrecord['details'];
        }   
        $selectedarray = selectMapEntries ('data/category-account-map.txt', '', $accountid);
        $selectedstring = implode (',', $selectedarray);
        echo " &nbsp; <b>Categories: </b>" . $selectedstring;             
        echo "<br>";
    }
} 
    ?>
    </div></div>

