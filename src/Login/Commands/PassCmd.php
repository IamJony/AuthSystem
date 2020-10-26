<?php

namespace Login\Commands;

use Login\Login;
use pocketmine\command\{Command, CommandSender};
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\Player;

class PassCmd extends Command {
  
  protected $plugin;
  
  public function __construct(Login $plugin){
  $this->plugin = $plugin;
  parent::__construct("as", "Use /as help For More Details By: YoSoyJony", null, ["authsystem"]);
  }
  
  public function execute(CommandSender $pl, string $label, array $args) {
    
  if(empty($args[0])){
  $pl->sendMessage("§l§c» §r§7/as help: All Commands");
  return false;
  }
  
  if($args[0]=="help"){
  $pl->sendMessage("§l§f» §r§7=_=_=_=_=_=_=_=_=_=_=_=_=_=_=");
  $pl->sendMessage("§l§7» §r§6/as help : §fAll Commands");
  $pl->sendMessage("§l§f» §r§6/as author : §fAuthor for AuthSystem");
  $pl->sendMessage("§l§7» §r§6/as see (player): §fSee Player Password");
  $pl->sendMessage("§l§f» §r§6/as reset (player): §fReset Player Password");
  $pl->sendMessage("§l§7» §r§7=_=_=_=_=_=_=_=_=_=_=_=_=_=_=");
  }else if($args[0]=="see"){
    
  if($pl->hasPermission("pass.see")){
  
  $config = new Config($this->plugin->getDataFolder() . "pass.yml", Config::YAML);
  
  if(empty($args[1])){
  $pl->sendMessage("§l§c» §r§7Write player name");
  return false;
  }
  
  $player = $args[1];
  
  if($config->get($player) == null){
  $pl->sendMessage("§l§c» §r§7The player $args[1] is not Registered");
  return false;
  }
  
  $password = $config->get($player);
  $pl->sendMessage("§l§a» §r§7The password for $args[1] is §6$password");
  }else{
  $pl->sendMessage("§l§c» §r§7You do not have permission to use this command");
  }
    
  }else if($args[0]=="reset"){
    
  if($pl->isOp()){
  
  $config = new Config($this->plugin->getDataFolder() . "pass.yml", Config::YAML);
  
  if(empty($args[1])){
  $pl->sendMessage("§l§c» §r§7Write player name");
  return false;
  }
  
  $player = $args[1];
  
  if($config->get($player) == null){
  $pl->sendMessage("§l§c» §r§7The player $args[1] is not Registered");
  return false;
  }
  
  $config->set($player, "");
  
  $config->save();
  
  $pl->sendMessage("§l§a» §r§7You reset the password to $player");
  }else{
  $pl->sendMessage("§l§c» §r§7You do not have permission to use this command");
  }
  
  }else if($args[0]=="author"){
  $pl->sendMessage("§l§7     AuthSystem");
  $pl->sendMessage("§7By: §6YoSoyJony");
  $pl->sendMessage("§7Version: §62.0.0");
  }
  
  
  
}
}

