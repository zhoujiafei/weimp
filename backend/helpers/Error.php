<?php

namespace backend\helpers;

class Error
{
   const SUCCESS = 0;
	const ERR_UNKNOW = -1;
	const ERR_FAIL = 10001;
	const ERR_NOID = 10002;
	const ERR_PUBLIC_NUMBER_NOT_EXIST = 10003;
	public static function output($errorCode = '')
	{
		$errorMsg = self::getErrorInfo();
		if(!isset($errorMsg[$errorCode]))
		{
			$errorCode = self::ERR_UNKNOW;
		}
		
		$error = [
			'errorCode' => $errorCode,
			'errorText' => $errorMsg[$errorCode]
		];
		
		header('Content-Type: text/plain');
        echo json_encode($error);
        exit;
	}
	
	public static function getErrorInfo()
	{
		return [
		   self::SUCCESS              => '成功', 
			self::ERR_UNKNOW 				=> '未知错误',
			self::ERR_FAIL 			   => '失败',
			self::ERR_NOID         	   => '缺少ID',
			self::ERR_PUBLIC_NUMBER_NOT_EXIST => '该公众号不存在',
		];
	}
}