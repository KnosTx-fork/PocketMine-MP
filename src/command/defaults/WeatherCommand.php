<?php

namespace pocketmine\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\world\World;
use pocketmine\world\weather\WeatherManager;
use pocketmine\utils\TextFormat;

class WeatherCommand extends Command {

    public function __construct() {
        parent::__construct("weather",
        "Changing the weather in the world",
        "/weather <type> [duration]");
        $this->setPermission(DefaultPermissionNames::COMMAND_WEATHER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            $sender->sendMessage(TextFormat::RED . "You don't have permission to use this command");
            return false;
        }

        if (count($args) < 1) {
            $sender->sendMessage(TextFormat::RED . "Usage: /weather <type> [duration]");
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "Hanya pemain yang bisa menggunakan perintah ini.");
            return false;
        }

        $world = $sender->getWorld();
        $weatherManager = $world->getWeatherManager();

        switch (strtolower($args[0])) {
            case "clear":
                $weatherManager->setClear();
                $sender->sendMessage(TextFormat::GREEN . "Cuaca diubah menjadi cerah.");
                break;

            case "rain":
                $weatherManager->setRain();
                $sender->sendMessage(TextFormat::GREEN . "Cuaca diubah menjadi hujan.");
                break;

            case "thunder":
                $weatherManager->setThunder();
                $sender->sendMessage(TextFormat::GREEN . "Cuaca diubah menjadi badai petir.");
                break;

            default:
                $sender->sendMessage(TextFormat::RED . "Jenis cuaca tidak valid! Gunakan: clear, rain, atau thunder.");
                return false;
        }

        return true;
    }
}