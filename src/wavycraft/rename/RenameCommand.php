<?php

declare(strict_types=1);

namespace wavycraft\rename;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\player\Player;

use pocketmine\utils\TextFormat as TextColor;

class RenameCommand extends Command {

    public function __construct() {
        parent::__construct("rename");
        $this->setDescription("Renames the item in your hand");
        $this->setUsage("Usage: /rename <new name>");
        $this->setPermission("rename.cmd");
    }

    public function execute(CommandSender $sender, string $label, array $args) : bool{
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game...");
            return false;
        }

        if (count($args) < 1) {
            $sender->sendMessage(TextColor::RED . $this->getUsage());
            return false;
        }

        $newName = implode(" ", $args);
        $renameResult = RenameManager::getInstance()->renameItem($sender, $newName);

        switch ($renameResult) {
            case RenameManager::RENAME_SUCCESS:
                $sender->sendMessage(TextColor::GREEN . "Your item has been renamed to " . $newName . TextColor::RESET . TextColor::GREEN . " for $" . RenameManager::RENAME_COST);
                break;

            case RenameManager::INSUFFICIENT_FUNDS:
                $sender->sendMessage(TextColor::RED . "You do not have enough money to rename this item. You need $" . RenameManager::RENAME_COST . "...");
                break;
        }

        return true;
    }
}