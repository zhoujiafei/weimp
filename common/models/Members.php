<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%members}}".
 *
 * @property integer $id
 * @property integer $public_id
 * @property string $openid
 * @property string $nickname
 * @property string $headimgurl
 * @property integer $sex
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $remark
 * @property integer $subscribe
 * @property integer $subscribe_time
 * @property integer $groupid
 * @property string $unionid
 * @property integer $order_id
 */
class Members extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%members}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['public_id', 'sex', 'subscribe', 'subscribe_time', 'groupid', 'order_id'], 'integer'],
            [['openid', 'nickname', 'headimgurl', 'city', 'province', 'country', 'remark'], 'required'],
            [['openid', 'remark', 'unionid'], 'string', 'max' => 60],
            [['nickname'], 'string', 'max' => 30],
            [['headimgurl'], 'string', 'max' => 255],
            [['city', 'province', 'country'], 'string', 'max' => 20],
            [['openid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键ID',
            'public_id' => '所属公众号ID(系统内部)',
            'openid' => '发送方帐号（一个OpenID）',
            'nickname' => '用户昵称',
            'headimgurl' => '头像URL',
            'sex' => '性别：1男性 2女性',
            'city' => '用户所在城市',
            'province' => '省',
            'country' => '国家',
            'remark' => '用户备注',
            'subscribe' => '是否已经订阅',
            'subscribe_time' => '用户订阅时间',
            'groupid' => '分组ID',
            'unionid' => 'unionid',
            'order_id' => '排序ID',
        ];
    }

    //获取关联的公众号
    public function getPublicNumber() {
       return $this->hasOne(PublicNumber::className(),['id' => 'public_id']);
    }
}
