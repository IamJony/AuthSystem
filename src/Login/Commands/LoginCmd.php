<?php

namespace Login\Commands;

use Login\Login;
use pocketmine\command\{Command, CommandSender};
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\Player;

class LoginCmd extends Command {
  
  protected $plugin;
  
  public function __construct(Login $plugin){
  $this->plugin = $plugin;
  parent::__construct("login", "Use /login (password) By: YoSoyJony", null);
  }
  
  public function execute(CommandSender $pl, string $label, array $args) {
  
  if(empty($args[0])){
  $pl->sendMessage("§l§c» §r§7Enter Password");
  return false;
  }
  
  $config = new Config($this->plugin->getDataFolder() . "pass.yml", Config::YAML);
  $m = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
  $c = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
  
  if($config->get($pl->getName()) == null){
  $pl->sendMessage("§l§c» §r§7You cannot login without being registered");
  return false;
  }
  
  if($args[0] == $config->get($pl->getName())){
  $pl->setImmobile(false);
  $pl->sendMessage($m->get("pass-correct"));
  }else{
  if($c->get("allow-kick") == true){
    
  $pl->kick($m->get("pass-incorrect"), false);
  $pl->sendMessage($m->get("pass-incorrect"));
  }else if($c->get("allow-kick") == false){
  $pl->sendMessage($m->get("pass-incorrect"));
  }
  }
  
  
  }
}