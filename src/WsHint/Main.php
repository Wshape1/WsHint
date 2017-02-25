<?php

namespace WsHint;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;

class Main extends PluginBase implements Listener{


 public function onEnable(){
$this->getLogger()->info(TextFormat::BLUE."【WHint】感谢使用...");
@mkdir($this->getDataFolder(),0777,true);
		@mkdir($this->getDataFolder());
 $this->Config = new Config($this->getDataFolder()."Config.yml", Config::YAML, array(
                "进退服中间提示"=>"服务器" ,
                "OP"=>"OP",
                "Player"=>"Player",
				"创造"=>"创造",
				"生存"=>"生存",
				"JQOP"=>"§1OP◆先生",
				"OP进服全服公告"=>"§c进入§aMinecraftPE服务器！\n §c有事可以请教他哦!" ,
				"OP退服全服公告"=>"§c退出§aMinecraftPE服务器！",
				"玩家进服欢迎语"=>"§e欢迎进入MinecraftPE服务器",
 ));

		$this->getServer()->getPluginManager()->registerEvents( $this , $this );
}



public function onJoin(PlayerJoinEvent $event){
	
	$event->setJoinMessage("");
	
   $player=$event->getPlayer();
   $name=$player->getName();
   $h=$player->getHealth();
   $mh=$player->getMaxHealth();
   $world=$player->getLevel()->getName();


   $tip=$this->Config->get("进退服中间提示");
   $wop=$this->Config->get("OP");
   $wcz=$this->Config->get("创造");
   $wsc=$this->Config->get("生存");
   $bmopp=$this->Config->get("JQOP");
   $bmop=$this->Config->get("OP进服全服公告");
   $bmop1=$this->Config->get("OP退服全服公告");
   $pj=$this->Config->get("玩家进服欢迎语");
   $wj=$this->Config->get("Player");
   
      		if($player->isOp()){  
			$op=$wop; 
		}else{
			$op=$wj;  
		}
		$gm=$player->getGamemode();  
		if($gm==0){ 
			$gm=$wsc;  
		}
			if($gm==1){ 
				$gm=$wcz;  
      }
		
$player->setDisplayName("§a".$world.">§4[§1".$op."§4]<§b".$name."§4>§6>§7");
$this->getServer()->broadcastTip("§6--§4[ §d".$name." §4]§a进入".$tip."§6--");
if($player->isOp()){
$this->getServer()->broadcastMessage("§4[".$bmopp."§4]<".$name."§4>".$bmop."");
$player->setNameTag("§1".$wop."§e>§6".$name."\n §1>§4".$h."§a/§4".$mh."§1<>§b".$wj."§1<");
$player->sendMessage("".$pj."");
}else{
	$player->setNameTag("§1".$gm."§e>§6".$name."\n §1>§4".$h."§a/§4".$mh."§1<>§b".$wj."§1<");
	$player->sendMessage("".$pj.""); 
}
}
public function onQuit(PlayerQuitEvent $event){
	
	$event->setQuitMessage(""); 
	
	$player=$event->getPlayer();
	$name=$player->getName();
	
	$bmop1=$this->Config->get("OP退服全服公告");
	$tip=$this->Config->get("进退服中间提示");
	$bmopp=$this->Config->get("JQOP");
	
	$this->getServer()->broadcastTip("/n§6--§4[ §d".$name." §4]§a退出".$tip."§6--");
	if($player->isOp()){
	$this->getServer()->broadcastMessage("§4[".$bmopp."§4]<".$name."§4>".$bmop1."");
}
}
}
