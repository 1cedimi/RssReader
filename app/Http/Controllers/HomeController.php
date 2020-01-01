<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DOMDocument;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      function count_words_quantity($text, $excludedWords, $limit)
      {
        $text = strip_tags(html_entity_decode($text)); //exclude tags
        $text = strtolower($text); // Make all text to lowercase
        $words = str_word_count($text, 1); // Returns an array containing all the words found inside the string
        $words = array_diff($words, $excludedWords); // compare array and remove excluded words
        $words = array_count_values($words); // Count words quantity
        arsort($words); // Sort based on count
        
        return array_slice($words, 1, $limit); // Limit the number of words and returns the word array
      }

      $totalSummary = "";
      $wordsQuantity = 10;
      $commonWords = "the,be,to,of,and,a,in,that,have,I,it,for,not,on,with,he,as,you,do,at,this,but,his,by,from,they,we,say,her,she,or,an,will,my,one,all,would,there,their,what,so,up,out,if,about,who,get,which,go,me";
      $commonWords = strtolower($commonWords);
      $common_words_array = explode (",", $commonWords);  //create array of most common words
    
      $rssObject = new DOMDocument();
      $rssObject->load("https://www.theregister.co.uk/software/headlines.atom"); //load Rss object
      $entries = $rssObject->getElementsByTagName("entry");
      
      foreach($entries as $data){
        /* $id = $data->getElementsByTagName("id")->item(0)->nodeValue; 
        $updated = $data->getElementsByTagName("updated")->item(0)->nodeValue;
        $link = $data->getElementsByTagName("link")->item(0)->nodeValue;
        $author = $data->getElementsByTagName("author")->item(0)->nodeValue;
        $uri = $data->getElementsByTagName("uri")->item(0)->nodeValue;
        $name = $data->getElementsByTagName("name")->item(0)->nodeValue;
        $title = $data->getElementsByTagName("title")->item(0)->nodeValue; */
        $summary = $data->getElementsByTagName("summary")->item(0)->nodeValue;
    
        $totalSummary =  $totalSummary . " " . $summary;
      }
      $result = count_words_quantity($totalSummary, $common_words_array, $wordsQuantity);

      return view('home')->with('result', $result)
                         /* ->with('entries', $entries); */
                         ->with(['entries'=>$entries]);
                        
    }
    
}