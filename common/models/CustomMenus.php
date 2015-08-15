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
            [['order_id', 'public_id','create_time','update_time','fid'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['keyword'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 30]
        ];
    }
}
