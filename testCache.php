<?php
//����
$cache = new Cache();
$cache->dir = "../cc/";
//$cache->setCache("zhang", "zhangsan", 100);
echo $cache->getCache("zhang");
//$cache->removeCache("zhang");

$cache->setCache("liu", "liuqi", 100);
echo $cache->getCache("liu");

class Cache{
	public $cacheFile = "cache.json";	//�ļ�
	public $dir = "./cach2/";			//Ŀ¼

	//����
	public function setCache($name, $val, $expires_time){
		$file = $this->hasFile();
		//�ַ���ת����
		$str = file_get_contents($file);
		$arr = json_decode($str, true);
		
		//ֵΪ�գ����Ƴ��û���
		if(empty($val)){
			unset($arr[$name]);
		}else{
			$arr[$name] = array("value"=>$val, "expires_time"=>$expires_time, "add_time"=>time());
		}	
		//����ת�ַ���
		$str = json_encode($arr);
		file_put_contents($file, $str);
    }
    public function getCache($name){
		$file = $this->hasFile();
		
		//�ַ���ת����
		$str = file_get_contents($file);
		$allArr = json_decode($str, true);
		$arr = $allArr[$name];

		if(!$arr || time() > ($arr["expires_time"] + $arr["add_time"])){
			$this->removeCache($name);	//�����Ƴ�
			return false;
		}
		return $arr["value"];
    }
	public function removeCache($name){
		$this->setCache($name, '', 0);
	}
	
	private function hasFile(){
		//��������ڻ����ļ����򴴽�һ��
		if(!file_exists($this->dir)){
			mkdir($this->dir);
		}
		if(!file_exists($this->dir . $this->cacheFile)){
			touch($this->dir . $this->cacheFile);
		}
        return $this->dir . $this->cacheFile;
	}
}

?>