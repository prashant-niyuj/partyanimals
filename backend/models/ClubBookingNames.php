<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "club_booking_names".
 *
 * @property integer $id
 * @property integer $club_booking_id
 * @property string $booking_name
 * @property string $mobile_no
 * @property integer $is_in
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ClubBooking $clubBooking
 */
class ClubBookingNames extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'club_booking_names';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['club_booking_id', 'booking_name'], 'required'],
            [['club_booking_id', 'is_in'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['booking_name'], 'string', 'max' => 100],
            [['mobile_no'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'club_booking_id' => 'Club Booking ID',
            'booking_name' => 'Booking Name',
            'mobile_no' => 'Mobile No',
            'is_in' => 'Is In',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClubBooking()
    {
        return $this->hasOne(ClubBooking::className(), ['id' => 'club_booking_id']);
    }
     public function getBookingNo()
    {
       
        return $this->clubBooking->booking_no;
        
    }
}
