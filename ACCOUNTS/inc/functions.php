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
    file_put_contents ($filename, $String);      
}


// Maps for table relationships
function addMapEntry ($map, $key1, $key2) {    
    global $dl1,  $dl2;          
    
    $fArray1 = readArray ($map, $dl1);    
    $newentry = $key1 . $dl2 . $key2 . $dl2 . "\n";
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
                    unset ($fArray1 [$Id]);
                }
            }
            else if (! $key0  && $key1 ) {
                if ($fArray2[1] === $key1) {
                    unset ($fArray1 [$Id]);
                }
            }
            else if ($key0  && !$key1) {
                if ($fArray2[0] === $key0) {
                    unset ($fArray1 [$Id]);
                }
            }
        }
    }
    writeArray ($map, $fArray1, $dl1);
    
}

    
function selectMapEntries ($map, $key0, $key1) {
     global $dl1,  $dl2;
     $fArray1 = readArray ($map, $dl1);
    //returns an array with selected key
    global $dl1,  $dl2;
    $selectedarray = array();    
    
    foreach ($fArray1 as $Item1) {    
        $fArray2 = explode ($dl2, $Item1);       
        if (array_key_exists (1, $fArray2)) {
          
            if ($key0 && !$key1 ) {               
                if ($fArray2[0] == $key0 ){           
                    array_push ($selectedarray, $fArray2[1]);
                }
            }  
            else if (!$key0  && $key1) {
                if ($fArray2[1] === $key1) {
                     array_push ($selectedarray, $fArray2[0]);
                }
            }            
        }
    }    
    return $selectedarray;    
}


function selectMapKey ($map, $key0, $key1) {
    
    //returns an single value
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
        rename ($oldfilename, $newfilename);         
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
    file_put_contents ($filename, $String);          
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
		file_put_contents ($filename, $String);
    }
}       
function removeNameFromArray ($filename, $name, $delimiter) {  
    
    if (file_exists($filename)) {  

        $String = file_get_contents ($filename);
        $fArray = explode ($delimiter, $String);   
        
        foreach ($fArray as $Id => $Item) {
            $Item = trim ($Item);
            if ($Item ===  $name) {               
                unset ($fArray [$Id]);
            }
        }
        array_values ($fArray);
        sort ($fArray);       
        $String = implode ($delimiter, $fArray);            
        file_put_contents ($filename, $String);       
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

function specialChars($str) {
    return preg_match("/[^a-zA-Z0-9-:!?*,\.\s]/", $str) > 0;
}

?>
