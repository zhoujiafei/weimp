<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\UploadedFile;

class Uploader extends Component
{
   const EVENT_BEFORE_UPLOAD = 'beforeUpload';//定义上传之前的事件
   const EVENT_AFTER_UPLOAD = 'afterUpload';//定义上传之后的事件

   private $savePath = null;//保存路径
   private $accessDomain = null;//访问域名

   //获取保存路径
   public function getSavePath() {
      return $this->savePath;
   }
   
   //设置保存路径
   public function setSavePath($savePath = null) {
      $this->savePath = $savePath;
   }
   
   //获取访问域名
   public function getAccessDomain() {
      return $this->accessDomain;
   }
   
   //设置访问域名
   public function setAccessDomain($accessDomain = null) {
      return $this->accessDomain = $accessDomain;
   }
   
   //单文件上传
   public function uploadFile() {
      //上传之前触发的事件
      $this->trigger(self::EVENT_BEFORE_UPLOAD);
      //做好上传之前的准备工作，创建目录结构
      
      
      
      
      
      
      
      
      
      //上传之后触发的事件
      $this->trigger(self::EVENT_AFTER_UPLOAD);
   }
   
   //多文件上传
   public function uplaodFiles() {
      //上传之前触发的事件
      $this->trigger(self::EVENT_BEFORE_UPLOAD);
      
      
      
      //上传之后触发的事件
      $this->trigger(self::EVENT_AFTER_UPLOAD);
   }
   
   //创建目录结构
   private function createSaveDir() {
      
      
      
   }
   
   
   
   
   
   
   
   
   
   
   
   
   
   
}