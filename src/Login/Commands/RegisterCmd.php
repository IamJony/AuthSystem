<?php

namespace Login\Commands;

use Login\Login;
use pocketmine\command\{Command, CommandSender};
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\Player;

class RegisterCmd extends Command {
  
  protected $plugin;
  
  public function __construct(Login $plugin){
  $this->plugin = $plugin;
  parent::__construct("register", "Use /register (password) By: YoSoyJony", null);
  }
  
  public function execute(CommandSender $pl, string $label, array $args) {
    
  $config = new Config($this->plugin->getDataFolder() . "pass.yml", Config::YAML);
  
  
  if($config->get($pl->getName()) != null){
  $pl->sendMessage("§l§c» §r§7You are already registered");
  return false;
  }
  
  if(empty($args[0])){
  $pl->sendMessage("§l§c» §r§7Enter a Password");
  return false;
  }
  
  $config = new Config($this->plugin->getDataFolder() . "pass.yml", Config::YAML);
  
  $config->set($pl->getName(), $args[0]);
  
  $config->save();
  
  $m = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
  $pl->sendMessage($m->get("pass-register"));
  }
}