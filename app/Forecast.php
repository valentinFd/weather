<?php

namespace App;

class Forecast
{
    private ?object $object;

    public function __construct(string $city = "Riga")
    {
        $this->object = json_decode(file_get_contents("https://api.weatherapi.com/v1/forecast.json?key={$_ENV["API_KEY"]}&q=$city&days=3"), false);
    }

    public function getThreeDayForecast(): array
    {
        if ($this->object !== null)
        {
            return $this->object->forecast->forecastday;
        }
        return [];
    }

    public function getFourHourForecast(): array
    {
        if ($this->object !== null)
        {
            $currentHour = date('H', time());
            $forecastDay = 0;
            $result = [];
            for ($i = 1; $i <= 4; $i++)
            {
                if ($currentHour + $i > 23)
                {
                    $forecastDay = 1;
                    $forecastHour = $currentHour + $i - 24;
                }
                else
                {
                    $forecastHour = $currentHour + $i;
                }
                $result[] = $this->object->forecast->forecastday[$forecastDay]->hour[$forecastHour];
            }
            return $result;
        }
        return [];
    }

    public function getLocation(): object
    {
        return $this->object->location;
    }
}
