<?php

declare(strict_types=1);

namespace wavycraft\rename;

use pocketmine\item\Item;

use pocketmine\player\Player;

use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat as TextColor;

use wavycraft\core\economy\MoneyManager;

final class RenameManager {
    use SingletonTrait;

    public const RENAME_COST = 100;

    public const RENAME_SUCCESS = 0;
    public const INSUFFICIENT_FUNDS = 1;

    public function renameItem(Player $player, string $newName) : int {
        $heldItem = $player->getInventory()->getItemInHand();
        $moneyManager = MoneyManager::getInstance();
        
        if (!$heldItem->isNull() && $heldItem instanceof Item) {
            $playerBalance = $moneyManager->getBalance($player);

            if ($playerBalance >= self::RENAME_COST) {
                $moneyManager->removeMoney($player, self::RENAME_COST);
                
                $coloredName = TextColor::colorize($newName);
                $heldItem->setCustomName($coloredName);

                $player->getInventory()->setItemInHand($heldItem);
                return self::RENAME_SUCCESS;
            } else {
                return self::INSUFFICIENT_FUNDS;
            }
        }

        return self::INSUFFICIENT_FUNDS;
    }
}
