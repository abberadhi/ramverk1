<?php

namespace Anax\View;

?>

<h1>Weather</h1>

<form method="post">
    <label>Your IP address<br>
        <input name="ip" placeholder="your IP"> <input type="submit" value="Search"> 
    </label>
</form>

<h1>Data</h1>

<?php if (isset($data["lon"])): ?>
    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $data["lon"] ?>%2C<?= $data["lat"] ?>%2C<?= $data["lon"] ?>7%2C<?= $data["lat"] ?>&amp;layer=mapnik&amp;marker=<?= $data["lat"] ?>%2C<?= $data["lon"] ?>" style="border: 1px solid black"></iframe>

<div class="wrapper">

    <div class="box currentWeather">
        <p>Current</p>
        <p><?= gmdate("Y-m-d", $forecast->current->dt) ?></p>
        <p><?= $forecast->current->weather[0]->description ?></p>
        <p><?= $forecast->current->temp ?>°C</p>
    </div>

    <?php foreach ($forecast->daily as $value): ?>
        <div class="box">
        <p><?= gmdate("Y-m-d", $value->dt) ?></p>
        <p><?= $value->weather[0]->description ?></p>
        <p><?= $value->temp->min ?>°C - <?= $value->temp->max ?>°C</p>
        <p>Avr: <?= $value->temp->day ?>°C</p>
    </div>
    <?php endforeach; ?>

    <?php foreach ($timemachine as $value): ?>
        <div class="box oldData">
        <p>Old data:</p>
        <p><?= gmdate("Y-m-d", $value->current->dt) ?></p>
        <p><?= $value->current->weather[0]->description ?></p>
        <p><?= $value->current->temp ?>°C</p>

    </div>
    <?php endforeach; ?>

</div>
<?php elseif(isset($data["specifiedIP"])): ?>
    Something went wrong. Please check your specified IP address.
<?php endif;?>

<h1>API Usage</h1>
Send a GET request to the following:
<pre class="hljs">http://www.student.bth.se/~abra19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/api/weatherapi?ip={ip address}
</pre>