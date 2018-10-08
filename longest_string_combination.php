<?php
/**
A valid path consists of words from the list, where each word is
formed by add one more character from the previous word.  
For instance: a -> at -> cat -> coat is a valid path.
go -> god -> good is also a valid path.
Write a function that computes the longest valid path for a given list of words.

@author: Padma Priya T V
@date: 01/13/17
**/
?>
<?php
/**
* search for the array with value and return the matching value 
* @param $needle_value - key to validate
* @param $array - input array
* @param $array_search - formed array based on the strings found
**/
function array_search_value( $needle_value, $array, $array_search ) {
	  foreach($array as $newvalue){
		if(strlen($newvalue) !=1) {	
			$needle_value = split_needle ($newvalue);	
			if(!in_array($newvalue, $array_search)){
				if (!empty ($needle_value)) {
					if(preg_grep("'(?=.*".$needle_value.")'", $array)) 
					{ 
						return preg_grep("'(?=.*".$needle_value.")'", $array);
					}
				}
			}	
		}		
	}
	return false;
} 
/**
map function to count elements in a multidimensional array
@param $main_value -  contains the array with sorted and validated words
**/
function count_array($main_value)
{
	return count($main_value);
}
/**
split string to array by splitting each character in the string to an array
@param $string_val -  contains the string to convert to an array
**/
function split_needle ($string_val) {
	$needle_value = '';
	$needle_value_array = str_split($string_val);		
	$count_needle = count($needle_value_array);
	for ($i = 0; $i < $count_needle; $i++){
		$needle_value .= !empty($needle_value_array[$i]) ? '(?=.*'.$needle_value_array[$i].')' : '';
	}
	return $needle_value;
}

/**
* @param $words - input array to validate matching strings
**/
function longest_path_string($words)
{
	$words = array_map('strtolower', array_map('trim', $words));  
	//create callback function dynamically to be used in usort by passing values and returning comparison result
	//$sort_by_strlen = create_function('$a, $b', 'if (strlen($a) == strlen($b)) { return strcmp($a, $b); } return (strlen($a) < strlen($b)) ? -1 : 1;');
	//usort($words, $sort_by_strlen);	
	$array_search = array(); $index = 0; 
	array_multisort(array_map('strlen', $words), $words); 
	$lengths = array_map('strlen', $words);
	$minimum_length = min($lengths);
	foreach ($words as $wordKey => $wordValue) {
		if (strlen($wordValue) == $minimum_length) {
			$needle_value = split_needle ($wordValue);	
			$preg_match = preg_grep("'(?=.*".$needle_value.")'", $words);			
			$array_search[$index][] = $wordValue;					
			$return_val = array_search_value($wordValue, $preg_match, $array_search);	     
			if ($return_val) {
				$array_search[$index] = $array_search[$index] + $return_val;
			}
			$index++;					
		} 
	}
	$maximum_items_in_array = array_keys($array_search, max($array_search));
	$display_path = implode(" => ", $array_search[$maximum_items_in_array[0]]);
	echo 'The longest valid path for a given list of words: '; echo $display_path;
	exit;
}

//$array = array("a", "good", "job", "go", "g", "god","at","cat", "coat");
$array = array("ba", "a", "bca", "dcab", "x", "yx", "xzsdfsfdy");
echo 'Given Array: '; echo '<pre>'; print_r($array);
longest_path_string($array);

?>