<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%members_group}}".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $name
 * @property integer $count
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $order_id
 */
class MembersGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%members_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['group_id', 'name','public_id'], 'required'],
            [['group_id', 'count', 'create_time', 'update_time', 'order_id','public_id'], 'integer'],
            [['name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'name' => 'Name',
            'count' => '该分组内用户数',
            'create_time' => 'Create Time',
            'update_time' => '更新时间',
            'order_id' => '排序ID',
        ];
    }
}
