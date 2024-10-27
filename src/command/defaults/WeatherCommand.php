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

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function count;
use function strtolower;

class WeatherCommand extends VanillaCommand {

	public function __construct() {
		parent::__construct("weather",
		"Changing the weather in the world",
		"/weather <type> [duration]");
		$this->setPermission(DefaultPermissionNames::COMMAND_WEATHER);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
		if (!$this->testPermission($sender)) {
			$sender->sendMessage(TextFormat::RED . "You don't have permission to use this command");
			return false;
		}

		if (count($args) < 1) {
			$sender->sendMessage(TextFormat::RED . "Usage: /weather <type> [duration]");
			return false;
		}

		if (!$sender instanceof Player) {
			$sender->sendMessage(TextFormat::RED . "Only players can uses this command.");
			return false;
		}

		$world = $sender->getWorld();
		$weatherManager = $world->getWeatherManager();

		switch (strtolower($args[0])) {
			case "clear":
				$weatherManager->setClear();
				$sender->sendMessage(TextFormat::GREEN . "Weather changed to clear.");
				break;

			case "rain":
				$weatherManager->setRain();
				$sender->sendMessage(TextFormat::GREEN . "Weather changed to rain.");
				break;

			case "thunder":
				$weatherManager->setThunder();
				$sender->sendMessage(TextFormat::GREEN . "Weather changed to thunder.");
				break;

			default:
				$sender->sendMessage(TextFormat::RED . "Type invalid, Usage /weather <clear|rain|thunder> [duration]");
				return false;
		}
		return true;
	}
}
