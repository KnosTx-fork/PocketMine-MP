<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\world\weather;

use pocketmine\event\Listener;
use pocketmine\event\world\WeatherChangeEvent;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\LevelEventType;
use pocketmine\world\sound\ThunderSound;
use pocketmine\world\World;
use function mt_rand;

class WeatherManager implements Listener {
	private WeatherType $currentWeather;
	private World $world;

	public function __construct(World $world) {
		$this->world = $world;
		$this->currentWeather = WeatherType::CLEAR;
	}

	public function setWeather(WeatherType $type) : void {
		if ($this->currentWeather !== $type) {
			$this->currentWeather = $type;
			$event = new WeatherChangeEvent($this->world, $this->currentWeather);
			$this->world->getServer()->getPluginManager()->callEvent($event);

			switch ($type) {
				case WeatherType::CLEAR:
					$this->sendWeatherEvent(LevelEventType::STOP_RAIN);
					break;
				case WeatherType::RAIN:
					$this->sendWeatherEvent(LevelEventType::START_RAIN);
					break;
				case WeatherType::THUNDER:
					$this->sendWeatherEvent(LevelEventType::START_RAIN);
					$this->playThunderSound();
					break;
			}
		}
	}

	public function getWeather() : WeatherType {
		return $this->currentWeather;
	}

	private function playThunderSound() : void {
		if (mt_rand(0, 2) === 0) {  // Thunder occasionally
			$this->world->broadcastSound(new ThunderSound(), $this->world->getPlayers());
		}
	}

	private function sendWeatherEvent(int $eventType) : void {
		$packet = new LevelEventPacket();
		$packet->evid = $eventType;
		$packet->data = 0;
		$this->world->broadcastPacketToViewers($packet);
	}
}
