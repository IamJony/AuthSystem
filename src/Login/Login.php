<?php

namespace Login;

use Login\Form\FormUI;
use Login\Commands\{PassCmd, LoginCmd, RegisterCmd};
use pocketmine\utils\Config;
use pocketmine\{Server, Player};
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class Login extends PluginBase implements Listener{
  
  use FormUI;
  
  public $command = [];
  public $l = [];
  public $r = [];
  
  public static $instance = null;
  
  public function onEnable(){
  $this->saveResource("config.yml");
  $this->getServer()->getPluginManager()->registerEvents($this, $this);
  $this->getServer()->getCommandMap()->register("as", $this->command[] = new PassCmd($this));
  $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
  if($config->get("allow-ui") == false){
  $this->getServer()->getCommandMap()->register("login", $this->l[] = new LoginCmd($this));
  $this->getServer()->getCommandMap()->register("register", $this->r[] = new RegisterCmd($this));
  $this->getLogger()->notice("Comandos Cargados");
  }
  $this->saveResource("pass.yml");
  $this->saveResource("config.yml");
  $this->saveResource("messages.yml");
  }
  
 /* public static function getConfigs(string $value) {
	  return new Config($this->getDataFolder() . "{$value}.yml", Config::YAML);
	}*/

  public function onJoin(PlayerJoinEvent $e){
  $player = $e->getPlayer();
  
  $player->setImmobile(true);
  
  $config = new Config($this->getDataFolder() . "pass.yml", Config::YAML);
  $data = new Config($this->getDataFolder() . "config.yml", Config::YAML);
  
  if($data->get("allow-ui") == true){
  if(!$config->get($player->getName()) != null){
  $this->registerForm($player);
  }else{
  $this->loginForm($player);
  }
  }else if($data->get("allow-ui") == false){
  if(!$config->get($player->getName()) != null){
  $player->sendMessage("§l§a» §r§7Use /register (password) (password)");
  }else{
  $player->sendMessage("§l§a» §r§7Use /login (password)");
  }
  }
  }
  
  public function registerForm(Player $pl){
  $f = $this->createCustomFor(function(Player $pl, ?array $data){
  if( !is_null($data)){
  
  if(empty($data[0])){
  $config = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
  $pl->sendMessage($config->get("pass-empty"));
  $this->registerForm($pl);
  return false;
  }
  
  $pass = new Config($this->getDataFolder() . "pass.yml", Config::YAML);
  
  $pass->set($pl->getName(), $data[0]);
  
  $pass->save();
  
  $pl->setImmobile(false);
  $config = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
  $pl->sendMessage($config->get("pass-register"));
  }
  });
  $f->setTitle("§l§eREGISTER");
  $f->addInput("", "Enter password");
  $f->sendToPlayer($pl);
  }
  
  public function loginForm(Player $pl){
  $f = $this->createCustomFor(function(Player $pl, ?array $data){
  if( !is_null($data)){
  
  if(empty($data[0])){
  $config = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
  $data = new Config($this->getDataFolder() . "config.yml", Config::YAML);
  $pl->sendMessage($config->get("pass-empty"));
  $this->loginForm($pl);
  return false;
  }
  
  $pass = new Config($this->getDataFolder() . "pass.yml", Config::YAML);
  
  $contra = $pass->get($pl->getName());
  
  if($contra == $data[0]){
  $pl->setImmobile(false);
      $config = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
  $pl->sendMessage($config->get("pass-correct"));
  }else{
  $data = new Config($this->getDataFolder() . "config.yml", Config::YAML);
  if($data->get("allow-kick") == true){
  $config = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
  $pl->kick($config->get("pass-incorrect"), false);
  }else if($data->get("allow-kick") == false){
  $this->loginForm($pl);
  }
  }
  
  
  }
  });
  $f->setTitle("§l§bINGRESA");
  $f->addInput("", "YourPass");
  $f->sendToPlayer($pl);
}
  
  public function onDisable(){
  $this->saveResource("config.yml");
  }
}
