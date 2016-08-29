<?php
namespace Scheduler_1;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\scheduler\PluginTask;//これを追加します
//scheduler_1では、プレイヤーを参加した10秒後にkickするという(サンプル感が半端ない)プラグインを説明します
class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
	}
	public function onJoin(PlayerJoinEvent $event){//Playerが参加した時のイベントです
		$player = $event->getPlayer();
		$task = new kick($this, $player);//インスタンス作成
		$this->getServer()->getScheduler()->scheduleDelayedTask($task, 20 * 10);//$playerをkickクラスに20x10tick(10秒後)に継承させます
	}
}

class kick extends PluginTask{
   	public function __construct(PluginBase $owner, Player $player) {
      		parent::__construct($owner);
      		$this->player = $player;//Playerデータを引き継ぎます
   	}
   	public function onRun($currentTick){
      		$this->player->kick();//playerをkickします(ちなみにKick by admin.と出ます)
   	}
}
