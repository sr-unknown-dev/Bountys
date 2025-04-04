<?php

namespace unknown\menu;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\transaction\SimpleInvMenuTransaction;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use unknown\Loader;

class BountyMenu
{
    public function open(Player $player): void
    {
        $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $bountyManager = Loader::getInstance()->getBountyManager();
        $bountys = $bountyManager->getBountys();
        foreach ($bountys as $targetName => $bounty) {
            $playerName = $bounty["player"] ?? "Unknown";
            $targetAmount = $bounty["amount"] ?? 0;

            $bountyItem = VanillaItems::PAPER()->setCustomName("§a" . $targetName)->setLore([
                "§7By: " . $playerName,
                "§7Amount: " . $targetAmount,
                "§7Click to claim bounty"
            ]);
            $bountyItem->getNamedTag()->setString("bounty", $targetName);

            $menu->getInventory()->addItem($bountyItem);
        }
        $menu->setListener(function (SimpleInvMenuTransaction $transaction) use ($bountyManager): InvMenuTransactionResult {
            $player = $transaction->getPlayer();
            $item = $transaction->getItemClicked();

            if ($item->getCustomName() !== null && $item->getCustomName() !== "") {
                $bountyName = $item->getNamedTag()->getString("bounty", "");
                if ($bountyName !== "") {
                    if (!$bountyManager->isBountySe($player)){
                        $bountyManager->addtBountySe($player, $bountyName);
                        return $transaction->discard();
                    } else {
                        $bountyManager->removeBounty($player);
                        $bountyManager->addtBountySe($player, $bountyName);
                        return $transaction->discard();
                    }
                }
            }
            return $transaction->discard();
        });
        $menu->send($player, TextFormat::GREEN . "Bounty Menu");
    }
}