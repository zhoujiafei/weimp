<?php
namespace common\components;

use Yii;
use yii\base\Component;
use common\helpers\Common;

class Uploader extends Component
{
   //允许的扩展名
	public $allowExts = [];
	//允许的文件MIME类型
	public $allowTypes = [];
	//文件保存路径（默认当前目的upload目录）
	private $savePath = './uplaod/';
	//最大上传大小 默认最大上传 2M =2097152 B
	public $maxSize = 2097152;
	//自动检测文件 默认开启
	public $autoCheck = true;
	//是否覆盖同名文件  默认不覆盖
	public $uploadReplace = false;
	//文件上传信息
	private $uploadFileInfo;
	//最近一次的错误 
	private $error = '';
	//返回二级目录
	private $secondFilePath = '';
	//获取保存路径
	public function getSavePath()
	{
		return $this->savePath;
	}
	
	//设置保存路径
	public function setSavePath($path = '')
	{
		if(is_dir($path))
		{
			$this->savePath = $path;
		}
		else if($_path = Yii::getAlias($path))//解析别名路径
		{
			$this->savePath = $_path;
		}
	}

	//上传所有文件
	public function uploadAll($savePath='') {
	   //直接传参支持别名
	   $savePath = Yii::getAlias($savePath);
		if(empty($savePath))
			$savePath=$this->savePath;
		$savePath=rtrim($savePath,'/') . '/' . $this->getSecondPath();
		if(!is_dir($savePath)){
			//目录不存在则尝试创建
			if(!mkdir($savePath, 0777, true)){
				$this->error = '上传目录'.$savePath.'不存在';
				return false;
			}
		}else{
			//检测目录是否可写
			if(!is_writeable($savePath)){
				$this->error = '上传目录'.$savePath.'不可写';
				return false;
			}
		}

		$fileInfo = [];
		$isUpload   = false;
		// 对$_FILES数组信息处理
		$files	 =	 $this->dealFiles($_FILES);
		foreach ($files as $key=>$file){
			if(!empty($file['name'])){
				//保存file信息
				$file['key']        = $key;
				$file['extension']  = $this->getExt($file['name']);
				$file['savepath']   = $savePath;
				$file['savename']   = $this->getSaveName($file);
				$file['secondfilePath'] = $this->secondFilePath;
				// 自动检查附件
				if($this->autoCheck) {
					if(!$this->check($file))
						return false;
				}
				
				//保存文件
				if(!$this->save($file)) return false;
				//上传成功后保存文件信息，供其他地方调用
				unset($file['tmp_name'],$file['error']);
				$fileInfo[] = $file;
				$isUpload   = true;
			}
		}
		if($isUpload) {
			$this->uploadFileInfo = $fileInfo;
			return true;
		}else {
			$this->error  =  '没有选择上传文件';
			return false;
		}
	}

	/**
	 * 通过指定文件的$_FILES['name']上传文件 
	 */
	public function upload($file,$savePath=''){
	   //直接传参支持别名
	   $savePath = Yii::getAlias($savePath);
		//如果不指定保存文件名，则由系统默认
		if(empty($savePath))
			$savePath = $this->savePath;
		$savePath=rtrim($savePath,'/') .'/' . $this->getSecondPath();
		// 检查上传目录
		if(!is_dir($savePath)) {
			// 尝试创建目录
			if(!mkdir($savePath, 0777, true)){
				$this->error = '上传目录'.$savePath.'不存在';
				return false;
			}
		}else {
			if(!is_writeable($savePath)) {
				$this->error  =  '上传目录'.$savePath.'不可写';
				return false;
			}
		}
		//过滤无效的上传
		if(!empty($file['name'])) {
			$fileArray = array();
			if(is_array($file['name'])) {
				$keys = array_keys($file);
				$count =	count($file['name']);
				for ($i=0; $i<$count; $i++) {
					foreach ($keys as $key)
						$fileArray[$i][$key] = $file[$key][$i];
				}
			}else{
				$fileArray[] =  $file;
			}
			$fileInfo =  array();
			foreach ($fileArray as $key=>$file){
				//登记上传文件的扩展信息
				$file['extension']  = $this->getExt($file['name']);
				$file['savepath']   = $savePath;
				$file['savename']   = $this->getSaveName($file);
				$file['secondfilePath'] = $this->secondFilePath;
				// 自动检查附件
				if($this->autoCheck) {
					if(!$this->check($file))
						return false;
				}
				//保存上传文件
				if(!$this->save($file)) return false;
				unset($file['tmp_name'],$file['error']);
				$fileInfo[] = $file;
			}
			
			$this->uploadFileInfo = $fileInfo;
			// 返回上传的文件信息
			return true;
		}else {
			$this->error  =  '没有选择上传文件';
			return false;
		}
	}

	/**
	 * 处理$_FILES信息  将多个file分离
	 */
	private function dealFiles($files){
		$fileArray = [];
		$n = 0;
		foreach($files as $file){
			if(is_array($file['name'])){
				//关联数组
				$keys = array_keys($file);
				$count = count($file['name']);
				for($i = 0;$i < $count;$i++){
					foreach ($keys as $key)
						$fileArray[$n][$key] = $file[$key][$i];
					$n++;
				}
			}else{
				$fileArray[$n]=$file;
				$n++;
			}
		}
		return $fileArray;
	}
	
	/**
	 * 保存一个文件
	 * 
	 */
	private function save($file) {
		$filename = $file['savepath'] . $file['savename'];
		if(!$this->uploadReplace && is_file($filename)) {
			// 不覆盖同名文件
			$this->error	=	'文件已经存在！'.$filename;
			return false;
		}
		// 如果是图像文件 检测文件格式
		if( in_array(strtolower($file['extension']),array('gif','jpg','jpeg','bmp','png','swf')) && false === getimagesize($file['tmp_name'])) {
			$this->error = '非法图像文件';
			return false;
		}
		//上传文件
		if(!move_uploaded_file($file['tmp_name'], $filename)) {
			$this->error = '文件上传保存错误！';
			return false;
		}
		return true;
	}

	/**
	 * 获取扩展名
	 */
	private function getExt($filename){
		$pathinfo = pathinfo($filename);
        return $pathinfo['extension'];
	}

	/**
	 * 文件命名 规则
	 */
	private function getSaveName($file){
		$saveName = md5(uniqid() . Common::getGenerateSalt()).'.'.$file['extension'];
		return $saveName;
	}

	/**
	 * 获取二级目录路径
	 */
	private function getSecondPath() {
	    
	    $this->secondFilePath = date('Y',time()) . DIRECTORY_SEPARATOR . date('m',time()) . DIRECTORY_SEPARATOR;
	    return $this->secondFilePath;
	}

	/**
	 * 捕获错误上传信息
	 */
	private function error($errorCode){
		switch($errorCode) {
            case 1:
                $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
                break;
            case 2:
                $this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                break;
            case 3:
                $this->error = '文件只有部分被上传';
                break;
            case 4:
                $this->error = '没有文件被上传';
                break;
            case 6:
                $this->error = '找不到临时文件夹';
                break;
            case 7:
                $this->error = '文件写入失败';
                break;
            default:
                $this->error = '未知上传错误！';
        }
        return ;
	}

	/**
	 * 检测文件大小，文件扩展名，文件Mime类型，是否非法上传
	 * 
	 */
	private function check($file){
		if($file['error']!==0){
			//文件上传失败
			//捕获错误代码
			$this->error($file['error']);
			return false;
		}
		//检测文件大小
		if(!$this->checkSize($file['size'])){
			$this->error = '上传文件大小不符！';
            return false;
		}
		//检测文件扩展名
		if(!$this->checkExt($file['extension'])){
			$this->error = '上传文件类型不允许！';
			return false;
		}
		//检查文件Mime类型
		if(!$this->checkType($file['type'])) {
			$this->error = '上传文件MIME类型不允许！';
			return false;
		}
		//检测是否非法上传
		if(!$this->checkUpload($file['tmp_name'])) {
			$this->error = '非法上传文件！';
			return false;
		}
		return true;
	}

	/**
	 * 检测文件大小
	 */
	private function checkSize($size){
		return $size < $this->maxSize;
	}

	/**
	 * 检测文件扩展名
	 * 
	 */
	private function checkExt($extension){
		if(!empty($this->allowExts))
            return in_array(strtolower($extension),$this->allowExts,true);
      return true;
	}

	/**
	 * 检查文件Mime类型
	 */
	private function checkType($type){
		if(!empty($this->allowTypes))
			return in_array(strtolower($type),$this->allowTypes,true);
		return true;
	}

	/**
	 * 检测是否非法上传
	 */
	private function checkUpload($filename){
		return is_uploaded_file($filename);
	}

	/**
	 * 获取文件上传成功之后的信息
	 */
	public function getUploadFileInfo(){
	  if (is_array($this->uploadFileInfo) && count($this->uploadFileInfo) == 1){
	      return $this->uploadFileInfo[0];
	  }else{
	      return $this->uploadFileInfo;
	  }
   }

   /**
    * 获取最近一次的错误信息
    * 
    */
   public function getErrorMsg(){
    	return $this->error;
   }
}