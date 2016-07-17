<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "event_management".
 *
 * @property string $id
 * @property string $club_id
 * @property string $event_name
 * @property string $event_description
 * @property string $event_date
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Club $club
 */
class EventManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['club_id', 'event_name', 'event_date', 'created_by'], 'required'],
            [['club_id', 'created_by'], 'integer'],
            [['event_date', 'created_at', 'updated_at'], 'safe'],
            [['event_name'], 'string', 'max' => 250],
            [['event_description'], 'string', 'max' => 5000]
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
            'event_name' => 'Event Name',
            'event_description' => 'Event Description',
            'event_date' => 'Event Date',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
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
