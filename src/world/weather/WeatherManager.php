<?php

namespace pocketmine\world\weather;

class WeatherManager {

    private string $currentWeather = "clear";

    public function setClear(): void {
        $this->currentWeather = "clear";
    }

    public function setRain(): void {
        $this->currentWeather = "rain";
    }

    public function setThunder(): void {
        $this->currentWeather = "thunder";
    }

    public function getCurrentWeather(): string {
        return $this->currentWeather;
    }

    public function updateWeather(): void {
        // NOOP
    }
}