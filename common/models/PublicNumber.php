<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%public_number}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property string $appid
 * @property string $appsecret
 * @property string $encoding_aes_key
 * @property string $url
 * @property string $token
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $order_id
 */
class PublicNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%public_number}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'appid', 'appsecret', 'url', 'token', 'update_time'], 'required'],
            [['type', 'create_time', 'update_time', 'order_id'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['appid', 'appsecret'], 'string', 'max' => 120],
            [['encoding_aes_key', 'token'], 'string', 'max' => 60],
            [['url'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'appid' => 'Appid',
            'appsecret' => 'Appsecret',
            'encoding_aes_key' => 'Encoding Aes Key',
            'url' => 'Url',
            'token' => 'Token',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'order_id' => 'Order ID',
        ];
    }
}
