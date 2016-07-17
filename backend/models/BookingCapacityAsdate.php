<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "booking_capacity_asdate".
 *
 * @property string $id
 * @property string $club_id
 * @property integer $booking_capacity
 * @property string $capacity_active_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $no_of_booking
 * @property integer $is_full
 */
class BookingCapacityAsdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking_capacity_asdate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['club_id', 'booking_capacity', 'capacity_active_date', 'created_at'], 'required'],
            [['club_id', 'booking_capacity', 'no_of_booking', 'is_full'], 'integer'],
            [['capacity_active_date', 'created_at', 'updated_at'], 'safe'],
            ['booking_capacity','checkclubCapacity'],
            [['club_id', 'capacity_active_date'], 'unique', 'targetAttribute' => ['club_id', 'capacity_active_date'], 'message' => 'The combination of Club and Capacity Active Date has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'club_id' => 'Club',
            'booking_capacity' => 'Booking Capacity',
            'capacity_active_date' => 'Capacity Active Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'no_of_booking' => 'No Of Booking',
            'is_full' => 'Is Full',
        ];
    }

    public function checkclubCapacity()
    {
    	$club_capacity=$this->club->club_capacity;
    	$clubname=$this->club->name;
    	if($this->booking_capacity>$club_capacity)
    	{
    		$this->addError("booking_capacity","booking capacity must be less than club capacity.(club capacity of $clubname is $club_capacity)");
    	}
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClub()
    {
        return $this->hasOne(Club::className(), ['id' => 'club_id']);
    }
    

    
    public function getClubName() {

        if ($this->club_id)
            return $this->club->name;
        else {
            return "-";
        }
    }
}
