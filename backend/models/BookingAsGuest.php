<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "booking_as_guest".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $create_at
 * @property string $updated_at
 */
class BookingAsGuest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking_as_guest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'create_at'], 'required'],
            [['create_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 100],
            [['email'], 'unique']
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
            'email' => 'Email',
            'phone' => 'Phone',
            'create_at' => 'Create At',
            'updated_at' => 'Updated At',
        ];
    }
}
