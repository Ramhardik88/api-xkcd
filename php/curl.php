<?php                                                     //cURL(client URL) cURL is a library that lets you make HTTP requests in PHP

function apiCalling($url){
                                                        // Create cURl resources with initialize function 
$curl =  curl_init();                                   //$curl is going to be datatype curl resource
curl_setopt($curl, CURLOPT_URL, $url);
                                                        // Set cURL options
                                                        //Once cURL resource is created, When can then manipulate that   
                                                        //resource using functions, specifically designed for that resource (eg:Curl_setopt())

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);       //able to store the result in variable instead for showing directly to the browser
    if(curl_exec($curl) === false){                     
        echo 'Curl error: ' . curl_error($curl);        //Return a string containing the last error for the current session
    }
    else{
        $resp = curl_exec($curl);                       //Run cURL (execute http request )
        $decoded =  json_decode($resp, true);           // json_decode() used to decode a JSON string. It converts a JSON encoded string into object
                                                        // If it is true then objects returned will be converted into associative arrays.
        $decoded = array_values($decoded);              //array_values() The returned array will have numeric keys, starting at 0 and increase by 1.
        return $decoded;
        curl_close($curl);
    } 
}

$lastcomics =  apiCalling('https://xkcd.com/info.0.json');        // this url (current comic) which means last updated comics 
$rt_num = mt_rand(1,$lastcomics[1]);
$url = "https://xkcd.com/$rt_num/info.0.json";
$comic_data = apiCalling($url);
$comics = array();
$comic_name  = ucwords($comic_data[9]);                           //the name of the comics used as a key inside the associative array
$comics[$comic_name]['image'] = $comic_data[8];                  // and the second Dimension of array is created
$comics[$comic_name]['num'] = $comic_data[1];
         

foreach($comics as $comic_name => $info){                          // for each to loop through the comics array
    $content ="<table align='center' cellpadding='0' cellspacing='0' border='0' width='100%'bgcolor='#f0f0f0'>"
    ."<tr>"
    ."<td style='padding: 30px 30px 20px 30px;'>"
        ."<table cellpadding='0' cellspacing='0' border='0' width='100%' bgcolor='#ffffff' style='max-width: 650px; margin: auto;'>"
        ."<tr>"
            ."<td colspan='2' align='center' style='background-color: #333; padding: 40px;'>"
                ."<img src='https://xkcd.com/s/0b7742.png' border='0' style='width: 150px; height=150px;' />"
            ."</td>"
        ."</tr>"
        ."<tr>"
            ."<td colspan='2' align='center' style='padding: 50px 50px 0px 50px;'>"
                ."<h1 style='padding-right: 0em; margin: 0; line-height: 40px; font-weight:300; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 1em;'>
                  XKCD-Comics"
                ."</h1>"
            ."</td>"
        ."</tr>"
        ."<tr>"
            ."<td style='text-align: left; padding: 0px 50px;' valign='top'>"
                ."<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
                    Hello there,"
                ."</p>"
                ."<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #666; text-align: left; padding-bottom: 3%;'>
                  <p style='margin: 0;'>Comic Name : $comic_name</p>
                    <p style='margin: 0;'>Comic Id :  $info[num]</p>"
                ."</p>"
            ."</td>"
        ."</tr>"
         ."<tr>"
            ."<td colspan='2' align='center' style='background-color: #333; padding: 40px;'>"
                ."<img src='$info[image]' alt='Comicimage' width='600' style='display: block; width: 100%; max-width: 100%;'>"
            ."</td>"
        ."</tr>"
        ."<tr>"
            ."<td style='text-align: left; padding: 30px 50px 50px 50px' valign='top'>"
                ."<p style='font-size: 18px; margin: 0; line-height: 24px; font-family: 'Nunito Sans', Arial, Verdana, Helvetica, sans-serif; color: #505050; text-align: left;'>
                    Thank you"
                ."</p>"
            ."</td>"
        ."</tr>"
        ."<tr>"
            ."<td colspan='2' align='center' style='padding: 20px 40px 40px 40px;' bgcolor='#f0f0f0'>"
            ."</td>"
        ."</tr>"
      //  <!-- start footer -->
."<tr>"
  ."<td align='center' bgcolor='#e9ecef' style='padding: 24px;'>"
    ."<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>"

      //<!-- start unsubscribe -->
      ."<tr>"
        ."<td align='center' bgcolor='#e9ecef' style='padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;'>"
          ."<p style='margin: 0;'>To stop receiving these emails, you can <a href='https://sendgrid.com' target='_blank' rel='noopener noreferrer'>unsubscribe</a> at any time.</p>"
        ."</td>"
      ."</tr>"
      //<!-- end unsubscribe -->
    ."</table>"
  ."</td>"
."</tr>"
//<!-- end footer -->
        ."</table>"
    ."</td>"
."</tr>"
."</table>"


;  

}
//echo $content;

