<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%material}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $filepath
 * @property string $filename
 * @property string $type
 * @property integer $imgwidth
 * @property integer $imgheight
 * @property integer $filesize
 * @property integer $create_time
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%material}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'filepath', 'filename', 'type', 'filesize', 'create_time'], 'required'],
            [['imgwidth', 'imgheight', 'filesize', 'create_time','public_id'], 'integer'],
            [['name'], 'string', 'max' => 120],
            [['filepath'], 'string', 'max' => 100],
            [['filename'], 'string', 'max' => 40],
            [['type'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '图片名称',
            'filepath' => '原图的存储路径',
            'filename' => '文件名称',
            'type' => '图片类型',
            'imgwidth' => '图片宽度',
            'imgheight' => '图片高度',
            'filesize' => '图片大小',
            'create_time' => 'Create Time',
        ];
    }
}
