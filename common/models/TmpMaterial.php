<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tmp_material}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $media_id
 * @property integer $create_time
 * @property integer $order_id
 */
class TmpMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tmp_material}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'media_id'], 'required'],
            [['create_time', 'order_id','public_id','pic_id'], 'integer'],
            [['type','name'], 'string', 'max' => 20],
            [['media_id'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '素材类型',
            'media_id' => '微信平台上对应的素材ID',
            'create_time' => '素材上传时间',
            'order_id' => '排序ID',
        ];
    }
}
