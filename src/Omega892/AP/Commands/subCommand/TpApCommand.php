<?php

namespace Omega892\AP\Commands\subCommand;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\constraint\InGameRequiredConstraint;
use Omega892\AP\Main;
use Omega892\CustomItem\CustomItem;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\world\Position;
use pocketmine\world\World;
use pocketmine\Server;

final class TPApCommand extends BaseSubCommand {

    public function __construct(private Main $plugin){
        parent::__construct("tp", "Teleport to an AP");
        $this->setPermission("ap.use");
    }

    protected function prepare(): void {
        $this->addConstraint(new InGameRequiredConstraint($this));
        $this->registerArgument(0, new RawStringArgument("apName"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        $config = Main::$config;
        $apName = $args["apName"];
        $apNameAvailable = ["north", "south", "east", "west"];

        if (!in_array($apName, $apNameAvailable)) {
            $sender->sendMessage("§cYou must choose a valid AP (north, south, east, west).");
            return;
        }

        $apX = $config->getNested("aps.$apName.x");
        $apY = $config->getNested("aps.$apName.y");
        $apZ = $config->getNested("aps.$apName.z");
        $apWorldName = $config->getNested("aps.$apName.world");

        $worldManager = Server::getInstance()->getWorldManager();
        $world = $worldManager->getWorldByName($apWorldName);

        if ($world === null) {
            if (!$worldManager->loadWorld($apWorldName)) {
                $sender->sendMessage("§cThe world {$apWorldName} could not be found.");
                return;
            }
            $world = $worldManager->getWorldByName($apWorldName);
        }

        $position = new Position($apX, $apY, $apZ, $world);
        $sender->teleport($position);
        $sender->sendMessage("§aTeleported to AP §e{$apName}§a.");
    }
}
