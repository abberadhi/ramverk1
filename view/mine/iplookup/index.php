<?php

namespace Anax\View;

function getIPAddress() {
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     } 
     return $ip;  
}

$ipr = getIPAddress() ?? "";

?>

<h1>IP Lookup/Validator</h1>

<form method="POST">
<label>Enter IP<br>
<input type="text" value="<?= $ipr ?? "" ?>" name="ip"></label>
<input type="submit" value="Check">
</form>
<br>
Test it:
<form method="POST">
    <input type="submit" value="51.15.108.143" name="ip">
    <input type="submit" value="172.217.20.35" name="ip">
    <input type="submit" value="194.47.150.9" name="ip">
    <input type="submit" value="2001:0db8:85a3:0000:0000:8a2e:0370:7334" name="ip">
</form>
<br>
<h1>Result</h1>
<pre style="<?= ($ip ?? null) ? "border: 1px solid red;" : "" ?>" class="hljs">
Entered IP Address: <?= $ip ?? "None" ?> 
IPV4: <?= $validipv4 ?? "None" ?>
IPV6: <?= $validipv6 ?? "None" ?>  
Domain name:  <?= $hostname ?? "None" ?>  
Latitude:  <?= $latitude ?? "None" ?>  
Longitude:  <?= $longitude ?? "None" ?>  
Country:  <?= $country ?? "None" ?>  
City:  <?= $city ?? "None" ?>  
</pre>
<br>
<h1>IP Lookup/Validator (JSON)</h1>
<form method="POST" action="http://www.student.bth.se/~abra19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/api/data">
<label>Enter IP<br>
<input type="text" value="<?= $ipr ?? "" ?>" name="ip"></label>
<input type="submit" value="Check">
</form>
<br>

<h1>API Usage</h1>
Send a POST request to the following:
<pre class="hljs">http://www.student.bth.se/~abra19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/api/data
</pre>

FORM URL Encoded (application/x-www-form-urlencoded)<br>
Body:
<pre class="hljs">
{"ip": "yourip"}
</pre>