<?php
/**
 * Created by PhpStorm.
 * User: Klaus
 * Date: 22/08/2018
 * Time: 18:56
 */

namespace klaus;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\event\server\DataPacketReceiveEvent;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GREEN . "DeviceChat enabled!");
    }

    public function onDisable()
    {
        $this->getLogger()->info(TextFormat::RED . "DeviceChat disabled!");
    }

    public function getDevice(DataPacketReceiveEvent $event)
    {
        if ($event->getPacket() instanceof LoginPacket) {
            $device = $event->getPacket()->clientData["DeviceOS"];
            $types = ["Unknown", "Android", "iOS", "macOS", "FireOS", "GearVR", "HoloLens", "Windows10", "Windows", "Dedicated", "Orbis", "NX"];
            $this->data[$event->getPacket()->username] = ["OS" => $types[$device]];
        }
    }

    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer()->getName();
        $message = $event->getMessage();
        $event->setFormat(TextFormat::GRAY . "OS: ". $this->data[$event->getPlayer()->getName()]["OS"]. "§a ". $event->getPlayer()->getName() . "§7: " . $message);
    }
}