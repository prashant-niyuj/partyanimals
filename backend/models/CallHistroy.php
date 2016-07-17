<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "call_histroy".
 *
 * @property integer $id
 * @property string $self
 * @property string $incoming
 * @property string $name
 * @property string $c_type
 * @property string $created_time
 */
class CallHistroy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'call_histroy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['self', 'incoming', 'c_type'], 'required'],
            [['created_time'], 'safe'],
            [['self', 'incoming'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
            [['c_type'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'self' => 'Self',
            'incoming' => 'Incoming',
            'name' => 'Name',
            'c_type' => 'C Type',
            'created_time' => 'Created Time',
        ];
    }
}
