<?php
ini_set ('allow_url_fopen', 1);
//get the q parameter from URL
// $q=$_GET["q"];
// $q="Google";
$q="catholic";

$defaulturl = "http://www.usccb.org/bible/readings";

//find out which feed was selected
if ($q=="catholic") {
  $url=("http://www.usccb.org/bible/readings/rss/index.cfm");
}else if ("catholics") {
  $url =("http://www.catholic.org/xml/rss_dailyreadings.php");
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$file = curl_exec($ch);

curl_close($ch);

$xmlDoc = new DOMDocument();
//$xmlDoc->load($xml);
@$xmlDoc->loadHTML($file);

//print_r($file);


//get elements from "<channel>"
$channel = $xmlDoc->getElementsByTagName('channel')->item(0);
$channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
$channel_link = $channel->getElementsByTagName('link')->item(0)->nodeValue;
$channel_desc = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;

//print($channel_link);

//output elements from "<channel>"
  /*echo("<p><a href='" . $channel_link
    . "'>" . $channel_title . "</a>");
  echo("<br>");
  echo($channel_desc."</p>");*/

$today = date("Y-m-d");

$item_link = "";
//childNodes->item(0)->

//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');
for ($i=0; $i<=2; $i++) {
  $item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
  $item_pubdate=$x->item($i)->getElementsByTagName('pubdate')->item(0)->childNodes->item(0)->nodeValue;

  if($item_link ==""){
    $item_link = $defaulturl;
  }

  if($item_pubdate != ""){

    $pdate = date('Y-m-d', strtotime($item_pubdate));
    $today_time = strtotime($today);
    $pub_time = strtotime($pdate);

    if ($pub_time == $today_time) {
      echo ("<p><a href='" . $item_link . "' target='_blank'>" . $item_title . "</a>");
      echo ("<br>");
      echo ($item_desc . "</p>");
    }


  }
}

?>