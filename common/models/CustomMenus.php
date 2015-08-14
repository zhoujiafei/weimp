<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%custom_menus}}".
 *
 * @property integer $id
 * @property string $url
 * @property string $keyword
 * @property string $title
 * @property integer $pid
 * @property integer $order_id
 * @property string $type
 */
class CustomMenus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%custom_menus}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['pid', 'order_id'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['keyword'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'url' => '关联URL',
            'keyword' => '关联关键词',
            'title' => '菜单名',
            'pid' => '一级菜单',
            'order_id' => '排序号',
            'type' => '类型',
        ];
    }
}
