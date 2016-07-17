<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "booking_rate_asdate".
 *
 * @property string $id
 * @property string $club_id
 * @property integer $girl_rate
 * @property integer $boy_rate
 * @property integer $couple_rate
 * @property string $rate_date
 * @property string $create_at
 * @property string $updated_at
 *
 * @property Club $club
 */
class BookingRateAsdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking_rate_asdate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['club_id', 'girl_rate', 'boy_rate', 'couple_rate', 'rate_date'], 'required'],
            [['club_id', 'girl_rate', 'boy_rate', 'couple_rate'], 'integer'],
            [['rate_date', 'create_at', 'updated_at'], 'safe'],
            [['club_id', 'rate_date'], 'unique', 'targetAttribute' => ['club_id', 'rate_date'], 'message' => 'The combination of Club and rate Date has already been taken.'],
        
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
            'girl_rate' => 'Girl Rate',
            'boy_rate' => 'Stage Rate',
            'couple_rate' => 'Couple Rate',
            'rate_date' => 'Rate Date',
            'create_at' => 'Create At',
            'updated_at' => 'Updated At',
        ];
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
