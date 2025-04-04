<?php

namespace unknown\managers;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use unknown\Loader;

class BountyManager
{
    public array $bountySe = [];
    public array $bounty = [];
    private Config $config;

    public function __construct()
    {
        $this->config = new Config(Loader::getInstance()->getDataFolder() . "bounty.json", Config::JSON);
        $this->load();
    }

    public function load(): void
    {
        $this->bounty = $this->config->get("bounty");
    }

    public function setBounty(Player $player, Player $target, int $amount): void
    {
        $this->bounty[$target->getName()] = [
            "player" => $player->getName(),
            "amount" => $amount
        ];
        $this->save();
    }

    public function removeBounty(Player $player): void
    {
        unset($this->bounty[$player->getName()]);
    }

    public function getBounty(Player $player, string $value): array
    {
        if (isset($this->bounty[$player->getName()])) {
            return $this->bounty[$player->getName()][$value];
        }
        return [];
    }

    public function getBountys(): array
    {
        return $this->bounty;
    }

    public function save(): void
    {
        $this->config->set("bounty", $this->bounty);
        $this->config->save();
    }

    public function addtBountySe(Player $player, string $target): void
    {
        $this->bountySe[$player->getName()] = $target;
        $player->sendMessage("§aYou have selected a bounty on " . $target);
    }

    public function removeBountySe(Player $player): void
    {
        unset($this->bountySe[$player->getName()]);
        $player->sendMessage("§cYou have removed the bounty selection.");
    }

    public function isBountySe(Player $player): bool
    {
        return isset($this->bountySe[$player->getName()]);
    }

    public function getCordsTarget(Player $player): array
    {
        $targets = $this->bountySe[$player->getName()] ?? null;
        if ($targets instanceof Player) {
            $x = (int)$targets->getPosition()->getX();
            $z = (int)$targets->getPosition()->getZ();
            return $this->isBountySe($player) ? $this->bountySe[$player->getName()] : [];
        }
    }
}