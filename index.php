<?php

require_once("vendor/autoload.php");

use App\Forecast;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
          crossorigin="anonymous">
    <title>Weather Forecast</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <form method="get">
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control w-25" id="city" name="city" value="Riga">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
    <?php
    if (isset($_GET["city"])):
        $forecast = new Forecast($_GET["city"]);
        ?>
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <?= "{$forecast->getLocation()->name}, {$forecast->getLocation()->country}" ?>
                </div>
                <?php
                foreach ($forecast->getThreeDayForecast() as $dayForecast): ?>
                    <div class="row">
                        <div class="col">
                            <?= $dayForecast->date ?>
                        </div>
                        <div class="col">
                            <?= $dayForecast->day->maxtemp_c ?>
                        </div>
                        <div class="col">
                            <?= $dayForecast->day->condition->text ?>
                        </div>
                    </div>
                <?php
                endforeach ?>
                <div class="row">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    Next four hours
                </div>
                <?php
                foreach ($forecast->getFourHourForecast() as $hourForecast):?>
                    <div class="row">
                        <div class="col">
                            <?= $hourForecast->time ?>
                        </div>
                        <div class="col">
                            <?= $hourForecast->temp_c ?>
                        </div>
                        <div class="col">
                            <?= $hourForecast->condition->text ?>
                        </div>
                    </div>
                <?php
                endforeach ?>
            </div>
        </div>
    <?php
    endif ?>
</div>
</body>
</html>
