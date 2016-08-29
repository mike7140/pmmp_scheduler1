<?php
namespace Scheduler_3;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\CallbackTask;//さらにこれを追加します
use pocketmine\utils\Config;//前回の復習です
//Scheduler_3では、A○Rにもっと近づけます。前回のconfigも使用します。
class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		if (!file_exists($this->getDataFolder())) {//なにこれという方は前回の講習をご覧ください
            		mkdir($this->getDataFolder(), 0744, true);
			$this->time = new Config($this->getDataFolder() . "time.json", Config::JSON, array());//yamlでもいいですがjsonの方が個人的に好きです(名前もかっこいいです)
		}
		$this->time = new Config($this->getDataFolder() . "time.json", Config::JSON, array());
		if($this->time->exists("time")){//もしconfigにtimeがなかったら
			$this->time->set("time", 30);
			$this->time->save();//save()の書き忘れにお気をつけ下さい
		}
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this,"CountTask"]), 20);//20tick(1秒後)にStopTaskに引き継がせます
		$this->count = $this->time->get("time");
	}
        public function CountTask(){
                if($this->count >= 1){//もし再起動まで1秒以上あったら
			$s = $this->count;
			$this->getServer()->broadcastMessage("再起動まで" . $s . "秒");//全員にメッセージを送ります
			$this->count--;//残り時間を一秒引きます
		}else{
			$this->getServer()->shutdown();//シャットダウン
		}
		
        }
}
