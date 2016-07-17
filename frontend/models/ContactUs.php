<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contact_us".
 *
 * @property integer $id
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_no
 * @property string $subject
 * @property string $message
 * @property string $created_at
 */
class ContactUs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_us';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_name', 'contact_email', 'contact_no', 'subject', 'message'], 'required'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['contact_email'],"email"],
            [['contact_name', 'subject'], 'string', 'max' => 100],
            [['contact_no'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contact_name' => 'Contact Name',
            'contact_email' => 'Contact Email',
            'contact_no' => 'Contact No',
            'subject' => 'Subject',
            'message' => 'Message',
            'created_at' => 'Created At',
        ];
    }
}
