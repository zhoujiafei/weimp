<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "liv_message".
 *
 * @property integer $id
 * @property string $msg_id
 * @property integer $public_id
 * @property integer $msg_type
 * @property string $media_id
 * @property string $thumb_media_id
 * @property string $to_user_name
 * @property string $from_user_name
 * @property string $voice_format
 * @property string $content
 * @property string $pic_url
 * @property string $location_x
 * @property string $location_y
 * @property integer $scale
 * @property string $label
 * @property string $title
 * @property string $description
 * @property string $url
 * @property integer $create_time
 * @property integer $order_id
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'liv_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg_id', 'to_user_name', 'from_user_name', 'description'], 'required'],
            [['public_id', 'msg_type', 'scale', 'create_time', 'order_id'], 'integer'],
            [['msg_id'], 'string', 'max' => 80],
            [['media_id', 'thumb_media_id'], 'string', 'max' => 200],
            [['to_user_name', 'from_user_name'], 'string', 'max' => 60],
            [['voice_format', 'location_x', 'location_y'], 'string', 'max' => 20],
            [['content', 'description'], 'string', 'max' => 500],
            [['pic_url', 'url'], 'string', 'max' => 250],
            [['label'], 'string', 'max' => 120],
            [['title'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msg_id' => '消息ID',
            'public_id' => '所属哪个公众号的消息',
            'msg_type' => '消息类型',
            'media_id' => '媒体ID',
            'thumb_media_id' => '缩略图mediaid',
            'to_user_name' => '接收该消息的开发者微信号',
            'from_user_name' => '发送该消息的用户openid',
            'voice_format' => '语音格式',
            'content' => '文本消息内容',
            'pic_url' => '图片链接',
            'location_x' => '地理位置纬度',
            'location_y' => '地理位置经度',
            'scale' => '缩放大小',
            'label' => '地理位置信息',
            'title' => '消息标题',
            'description' => '消息描述',
            'url' => '消息链接',
            'create_time' => '消息发送时间',
            'order_id' => '排序ID',
        ];
    }
}
