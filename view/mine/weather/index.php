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

<?php if (isset($data["lon"])): ?>
    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $data["lon"] ?>%2C<?= $data["lat"] ?>%2C<?= $data["lon"] ?>7%2C<?= $data["lat"] ?>&amp;layer=mapnik&amp;marker=<?= $data["lat"] ?>%2C<?= $data["lon"] ?>" style="border: 1px solid black"></iframe>


<div class="weatherContainer">
    

    <?= var_dump($data) ?>



</div>
<?php endif;?>