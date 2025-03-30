<!DOCTYPE html>
<html>
<head>    
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">         
    
    
    <link rel= 'stylesheet' type='text/css' href= 'inc/style.css?v=2'>  
    <title>Accounts</title>
    </head>
 
<body > 
    
    <div class = 'outerwrap <?php echo $pageid ; ?>'>
        <div class = 'headerwrap'>           
            <a class = 'return' href = 'https://catsandcode.org/accounts'>&larr; Return</a><br><br>
            <?php
            echo "<br><br><img class = 'round' src = 'data/ralph-in-bag2.jpg' alt = 'Ralph in bag'>";        
            echo " <a href = 'index.php'><h1>Manage My Accounts</h1></a>";
            $menuarray = array ( 'home', 'detailed-accounts',  'settings');
            foreach ($menuarray as $item) {
                if ($pageid === trim($item)) {
                    echo "<a class = 'menuitem current' href = 'index.php?page=" . $item . "'>" . ucwords (str_replace ("-", " ",  $item )) . "</a>";
                }
                else {
                        echo "<a class = 'menuitem ' href = 'index.php?page=" . $item . "'>" .  ucwords (str_replace ("-", " ",  $item ))   . "</a>";
                }
            }
          
            ?>          
            
        </div>
    
      
           
                 
