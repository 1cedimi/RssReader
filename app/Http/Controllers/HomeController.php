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
      $totalText = "";
      $wordsQuantity = 10;
      $commonWords = "the,be,to,of,and,a,in,that,have,I,it,for,not,on,with,he,as,you,do,at,this,but,his,by,from,they,we,say,her,she,or,an,will,my,one,all,would,there,their,what,so,up,out,if,about,who,get,which,go,me";
      $commonWords = strtolower($commonWords);
      $common_words_array = explode (",", $commonWords);  //create array of most common words
    
      $rssObject = new DOMDocument();
      $rssObject->load("https://www.theregister.co.uk/software/headlines.atom"); //load Rss object
      $entries = $rssObject->getElementsByTagName("entry");
      
      foreach($entries as $data){
        $data->nodeValue;
        $title = $data->getElementsByTagName("title")->item(0)->nodeValue;
        $summary = $data->getElementsByTagName("summary")->item(0)->nodeValue;
        $totalText =  $totalText . " " . $summary . " " . $title;
      }
      $result = count_words_quantity($totalText, $common_words_array, $wordsQuantity);

      return view('home')->with('result', $result)
                         ->with(['entries'=>$entries]);                  
    }
    
}