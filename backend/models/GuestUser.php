<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "guest_user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email_address
 * @property integer $mobile_no
 * @property string $created_at
 * @property string $updated_at
 */
class GuestUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guest_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email_address', 'mobile_no', 'created_at'], 'required'],
            [['mobile_no'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email_address'], 'string', 'max' => 100]
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
            'email_address' => 'Email Address',
            'mobile_no' => 'Mobile No',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
