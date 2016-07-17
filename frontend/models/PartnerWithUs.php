<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "partner_with_us".
 *
 * @property integer $id
 * @property string $partner_type
 * @property string $name_of_venue
 * @property string $description
 * @property string $address
 * @property string $email
 * @property string $contact_no
 * @property string $contact_name
 * @property string $created_at
 */
class PartnerWithUs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_with_us';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_type', 'name_of_venue', 'address', 'email', 'contact_no', 'contact_name'], 'required'],
            [['partner_type', 'description'], 'string'],
            [['created_at'], 'safe'],
            [['email'],'email'],
            [['name_of_venue',  'contact_no', 'contact_name'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_type' => 'Partner Type',
            'name_of_venue' => 'Name Of Venue',
            'description' => 'Description',
            'address' => 'Address',
            'email' => 'Email',
            'contact_no' => 'Contact No',
            'contact_name' => 'Contact Name',
            'created_at' => 'Created At',
        ];
    }
}
