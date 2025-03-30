<?php

function  createRecordId ($name) {
    $newname = "";
    if ($name !== "") {       
        $newname = trim ($name);
        $newname = str_replace (" " , "-", $newname);            
        $newname = strtolower ($newname);
        $newname = preg_replace('/[^A-Za-z0-9-?!]/', '', $newname); 
        $newname = preg_replace('/-+/', '-', $newname);        
    }    
    return $newname;        
}

function initializeRecord ($keys){  
   
    $record = array ();
    foreach ($keys as $Id => $key) {
        $record[$key] = ""; 
    }  
    return ($record);
}

function readDatabaseRecord ($keys,  $filename) {
 
    global $dl1;
    //Initialize record
    $record = array();  
    foreach ($keys as $Id => $key) {
        $record[$key] = ""; 
    }   
    
    if ($filename && file_exists($filename)) {        
        $string = file_get_contents ($filename);  
        $fArray1= explode ($dl1, $string);
        foreach ($keys as $Id => $key) { 
            if (array_key_exists ($Id, $fArray1)) {
                $record [$key] = $fArray1[$Id]; 
            }        
        }          
    } 
    return $record;  
   
}


function writeDatabaseRecord ($record,  $filename) { 
  
    global $dl1;    
    $String = implode ($dl1, $record);     
    //file_put_contents ($filename, $String);      
}


// Maps for table relationships
function addMapEntry ($map, $key1, $key2) {    
    global $dl1,  $dl2;          
    
    $fArray1 = readArray ($map, $dl1);    
    $newentry = $key1 . $dl2 . $key2 . "\n";
    array_push ($fArray1, $newentry);
    $fArray1 =  array_unique ($fArray1);       
    sort ($fArray1);
    writeArray ($map, $fArray1, $dl1);
}

function removeMapEntries ($map, $key0, $key1) {
    //Remove entries containing either or both key0 and key1
    global $dl1,  $dl2;       
   
    $fArray1 = readArray ($map, $dl1);
    
    foreach ($fArray1 as $Id => $Item1) {
        $fArray2 = explode ($dl2, $Item1);          
        if (array_key_exists (0, $fArray2) && array_key_exists (1, $fArray2)) {               
        
            if ($key0  && $key1 ) {
                if ( $fArray2[0] === $key0  && $fArray2[1] === $key1 ) {                       
                    //unset ($fArray1 [$Id]);
                }
            }
            else if (! $key0  && $key1 ) {
                if ($fArray2[1] === $key1) {
                    //unset ($fArray1 [$Id]);
                }
            }
            else if ($key0  && !$key1) {
                if ($fArray2[0] === $key0) {
                    //unset ($fArray1 [$Id]);
                }
            }
        }
    }
    writeArray ($map, $fArray1, $dl1);
    
}


function selectMapEntries ($map, $key0, $key1) {
    //for many-to-many relationships 
    //returns an array with selected key
    global $dl1,  $dl2;
    $fArray1 = readArray ($map, $dl1);    
    $selectedarray = array();    

    if ($key0 && !$key1 ) {    
        foreach ($fArray1 as $Item1) {    
            $fArray2 = explode ($dl2, $Item1);       
            if (array_key_exists (1, $fArray2)) {  
                if ($fArray2[0] == $key0 ){           
                    array_push ($selectedarray, $fArray2[1]);
                }
            }  
        }
    }
    else if (!$key0  && $key1) {
        foreach ($fArray1 as $Item1) {  
            $fArray2 = explode ($dl2, $Item1);   
            if (array_key_exists (1, $fArray2)) {  
               if ($fArray2[1] === $key1) {               
                   array_push ($selectedarray, $fArray2[0]);
               }
            }
        } 
    }    
    return $selectedarray;    
}


function selectMapKey ($map, $key0, $key1) {
    //For one-to-many relationships
    //returns a single value
    global $dl1,  $dl2;   
    $returnvalue = '';
   
    $fArray1 = readArray ($map, $dl1);
   
    foreach ($fArray1 as $Id => $Item1) {
        $fArray2 = explode ($dl2, $Item1);      
      
        if ( array_key_exists (1, $fArray2)) {
           
           if (!$key0  && $key1) {
              if ($fArray2[1] === $key1) {
                  $returnvalue = $fArray2[0];
                  break;
              }                
            }
            else if ($key0  && ! $key1) {
               
                if ($fArray2[0] === $key0){                  
                    $returnvalue = $fArray2[1];                   
                    break;                  
                }
            }
        }
    }    
    return $returnvalue;    
}

function extractFromMap($map, $key) {
    //returns a new array of either the the first or second columns
    global $dl1,  $dl2;
  
    $selectedarray = array();  
    $fArray1 = readArray ($map, $dl1);
    foreach ($fArray1 as $Item1) {
      
        $fArray2 = explode ($dl2, $Item1);       
        if ($key == 0)  { 
            array_push ($selectedarray, $fArray2[0]); 
        }
        else if ($key == 1) {   
            if (array_key_exists (1, $fArray2)) {
                array_push ($selectedarray, $fArray2[1]);                 
            }
        }       
    }    
    return $selectedarray;    
}



function moveToTrash ($table, $recordid) {   
    $oldfilename = 'data/' . $table . '/' . $recordid . '.txt';
    $newfilename = 'data/trash/' . $table . '----' . $recordid . '.txt';  
    if (file_exists ($oldfilename)) {
        //rename ($oldfilename, $newfilename);         
    }   
}

//ARRAYS 

function readArray ($filename, $delimiter){
  
    $fArray1 = array();
    if (file_exists($filename)) { 
      
        $String = file_get_contents ($filename);
        if ($String !== "") {
            $fArray1 = explode ($delimiter, $String); 
        }
    }  
    return $fArray1;    
}

 function writeArray ($filename, $array, $delimiter){    
    $String = implode ($delimiter, $array);    
    //file_put_contents ($filename, $String);          
}  
        
function addNameToArray ($filename, $name, $delimiter) {
  
    if (file_exists($filename)) {  
        $String = file_get_contents ($filename);
        $fArray1 = explode ($delimiter, $String);  
		array_push ($fArray1, $name);
        $fArray1 = array_unique ($fArray1);
        sort ($fArray1);
		$String = implode ($delimiter, $fArray1);	
        $String = preg_replace('/,+/', ',', $String); 			
		//file_put_contents ($filename, $String);
    }
}       
function removeNameFromArray ($filename, $name, $delimiter) {  
    
    if (file_exists($filename)) {  

        $String = file_get_contents ($filename);
        $fArray = explode ($delimiter, $String);   
        
        foreach ($fArray as $Id => $Item) {
            $Item = trim ($Item);
            if ($Item ===  $name) {               
                //unset ($fArray [$Id]);
            }
        }
        array_values ($fArray);
        sort ($fArray);       
        $String = implode ($delimiter, $fArray);            
        //file_put_contents ($filename, $String);       
    }
}

//Validate 'GET'  value
function getFromQueryString ($label) {   
  
	$value = "";
	if (isset ($_GET[$label])) { 
        $value =  $_GET[$label];	
        if (specialChars($value) || strlen ($value) > 300) {            
            //Invalid input
            $value = '';
        }            
	}   
	return $value;    
}

//Filter input text
function sanitizeFormInput($text) {
    global $dl1, $dl2;  
    $text = trim($text);       
    $text = str_replace ($dl1, '', $text);
    $text = str_replace ($dl2, '', $text);
    return $text;
  }

  function showWords ($text) {
    $fancytext = str_replace (',', ', ', $text);
    $fancytext = ucwords (str_replace ('-', ' ', $fancytext));
    return $fancytext;
}

//CHECK FOR DUPLICATE EMAILS
function checkForDuplicateEmail ($sendtoemail, $message) {
    global $dl1, $dl2;  
    $error = false;
    $emailarchive = readArray ('data/email-archive.txt', $dl1);
    $emailentry = date ("Y-m-d") . $dl2 .$sendtoemail . $dl2  . $message . "\n";	
    if ( in_array ($emailentry, $emailarchive)) {
        $error = true;
        echo "<div class = 'error'>Message is a duplicate</div>";
    }
    else {
        array_push ( $emailarchive, $emailentry);
        $String = implode ($dl1, $emailarchive);
		//file_put_contents ('data/email-archive.txt', $String);
    }
    return $error;
}

function randomString () {    
   $String = "";
   $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $size = strlen($chars);
   for ($i = 0; $i < 7; $i++) {
       $String .= $chars[rand(0, $size - 1)];
   }
   return $String; 
}

function assignPostValuesToRecord ($postarray, $keys) {
   
    //Assign  values to record   
    $record = array();      
    foreach ($keys as $Id => $key) {
        $record[$key] = ""; 
        if (isset ($postarray[$key])) {
            $record[$key] =  sanitizeFormInput ($postarray[$key]); 
        }
    }    
    return $record;   
    
}
function saveToLog ($text) {
    
    global $dl1, $dl2;    
    $currenttime = date ("h-i:sa");       
    $date = date ("Y-m-d");
    $filename = 'data/log.txt';
    $String = file_get_contents ($filename);
    $String = $String . "\n\n "  . $date . " " . $currenttime . "  ". $text;
    //file_put_contents ($filename, $String);
}
function formatDate ($inputdate) {   
 
    $returndate = '';      
    if (is_numeric (substr ($inputdate, 0,4))) {
        //format yyyy/mm/dd
        $month = substr ($inputdate, 5, 2);
        $day = substr ($inputdate, 8,2);        
        $year = substr ($inputdate, 0, 4);
        $returndate = $year . '-' . $month . '-' . $day; 
    }
    else if (is_numeric (substr ($inputdate, 0, 2))) {
        //Year is last mm/dd/yyyy
        $month = substr ($inputdate, 0, 2);
        $day = substr ($inputdate, 3,2);        
        $year = substr ($inputdate, 6, 4);
        $returndate = $year . '-' . $month . '-' . $day; 
    }   

    else { 
        //default current date  
        $returndate = date('Y-m-d');
    }
    return $returndate;
}

function specialChars($str) {
    return preg_match("/[^a-zA-Z0-9-:!?*@#$,\.\s]/", $str) > 0;
}

function notPhoneNumber($str) {
    return preg_match('/[^0-9-\)\(\s]/', $str) > 0;
}
?>
