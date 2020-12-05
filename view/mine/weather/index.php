<?php

namespace Anax\View;

?>

<h1>Weather</h1>

<form method="post">
    <label>Your IP address<br>
        <input name="ip" placeholder="your IP"> <input type="submit" value="Search"> 
    </label>
</form>

<h1>Data <?= $data["h1Position"] ?? "" ?></h1>
<div class="weatherContainer">
    <div class="weatherCard current"></div>
</div>