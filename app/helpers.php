<?php
  function count_words_quantity($text, $excludedWords, $limit)
  {
    $text = strip_tags(html_entity_decode($text)); //first exclude tags
    $text = trim(preg_replace('/\W/', ' ', $text)); //remove non word characters 
    $text = strtolower($text); // Make all text to lowercase
    $words = str_word_count($text, 1); // Returns an array containing all the words found inside the string
    $words = array_diff($words, $excludedWords); // compare array and remove excluded words
    $words = array_count_values($words); // Count words quantity
    arsort($words); // Sort based on count

    foreach ($words as $key => $value){
      if (strlen($key) == 1){ //find all single characters words
        unset($words[$key]); //remove them from array
      }
    }       

    return array_slice($words, 0, $limit); // Limit the number of words and returns the word array
  }
 ?>