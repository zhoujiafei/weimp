<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%forever_material}}".
 *
 * @property integer $id
 * @property integer $public_id
 * @property integer $material_id
 * @property string $name
 * @property string $type
 * @property string $media_id
 * @property integer $create_time
 * @property integer $order_id
 */
class ForeverMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forever_material}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['public_id', 'material_id', 'create_time', 'order_id'], 'integer'],
            [['name', 'type', 'media_id'], 'required'],
            [['name', 'type'], 'string', 'max' => 20],
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
            'public_id' => 'Public ID',
            'material_id' => '关联本地素材库的素材ID',
            'name' => '素材名称（用户后台显示，对于真正提交微信的时候作用不大）',
            'type' => '素材类型',
            'media_id' => '微信平台上对应的素材ID',
            'create_time' => '素材上传时间',
            'order_id' => '排序ID',
        ];
    }
}
