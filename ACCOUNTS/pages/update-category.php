<?php
//Copyright (c) 2021, Susan V. Rodgers, Lila Avenue, LLC,  lilaavenue@gmail.com 

$category = "";
if (isset ($_GET['category'])) {        
    $category = filter_input(INPUT_GET, "category", FILTER_SANITIZE_STRING) ;
}

if ($_SERVER ["REQUEST_METHOD"] == "POST" ) { 
    $_SESSION['accounts-counter']++;
     if (isset ($_POST['selected'])) {
        $selected = $_POST['selected'];  
        foreach ($selected as $accountid) {
            addMapEntry ("data/category-account-map.txt", $category, $accountid);
        }
    }
   
}
?>

<div class = 'content-column'>  
    <h2>Update Category</h2>
     <h4> <?php echo ucwords (str_replace ('-', ' ', $category)); ?> </h4>  
    <form method = 'post' action = 'index.php?page=update-category&category=<?php  echo $category ;?>'>  

        <?php
        $currentarray = selectMapEntries ('data/category-account-map.txt', $category, "");
        $array1 = scandir ('data/accounts');
        foreach ($array1 as $item1){
            if ($item1 !== "."  && $item1 !== "..") {
                $accountid = str_replace (".txt", "", $item1);
                $selectedarray = selectMapEntries ('data/category-account-map.txt', '', $accountid);
                $selectedstring = implode (',', $selectedarray);
                if (in_array($accountid, $currentarray)) {
                    echo "<input id = '" . $accountid . "' type = 'checkbox' name = 'selected[]' value = '" . $accountid . "' checked />";  
                    echo "<label for = '" .$accountid . "'><a href = 'index.php?page=add-update-accountd&accountid=" . $accountid . "'>" . $accountid . "</a></label>";
                }
                else {
                    echo "<input id = '" . $accountid . "' type = 'checkbox' name = 'selected[]' value = '" . $accountid . "'  /> "; 
                     echo "<label for = '" .$accountid . "'><a href = 'index.php?page=add-update-account&accountid=" . $accountid . "'>" . $accountid . "</a></label>";
                }
                echo "&nbsp; &nbsp; " . $selectedstring . "</br>";
            }
        }
         ?> 
    <br><br> <input  class = 'submitbutton' name = 'submit' type = 'submit' value='Select'>         
    </form>  
</div><div class = 'sidebar-column'>
	
</div>



  