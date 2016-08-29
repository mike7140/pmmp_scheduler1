<?php
namespace Scheduler_2;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\CallbackTask;//さらにこれを追加します
//Scheduler_2では、CallbackTaskを使って自動サーバー停止機能を作ります(A○Rの簡易版です)
class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
                $this->getServer()->getScheduler()->scheduleDelayedTask(
                new CallbackTask([$this,"StopTask"]), 20 * 10);//20x10tick(10秒後)にStopTaskに引き継がせます
	}
        public function StopTask(){
                $this->getServer()->shutdown();//サーバーを止めます
        }
}
