<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * This is the model class for table "club_booking".
 *
 * @property integer $id
 * @property string $pa_pnr
 * @property integer $club_id
 * @property integer $booked_type
 * @property integer $user_id
 * @property integer $price_of_girl
 * @property integer $price_of_stage
 * @property integer $price_of_couple
 * @property string $booking_category
 * @property integer $no_of_girls
 * @property integer $no_of_boys
 * @property double $tax_rate
 * @property integer $commission_rate
 * @property string $commission
 * @property integer $convenience_fee
 * @property double $total_price
 * @property string $booking_date
 * @property integer $in_confirm
 * @property string $created_at
 * @property string $updated_at
 *
 * @property BookingPaymentHistory[] $bookingPaymentHistories
 * @property Club $club
 * @property ClubBookingNames[] $clubBookingNames
 */
class ClubBooking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'club_booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pa_pnr', 'club_id', 'user_id', 'booking_category', 'tax_rate', 'commission_rate', 'commission', 'convenience_fee', 'total_price', 'booking_date', 'created_at'], 'required'],
            [['club_id', 'booked_type', 'user_id', 'price_of_girl', 'price_of_stage', 'price_of_couple', 'no_of_girls', 'no_of_boys', 'commission_rate', 'convenience_fee', 'in_confirm'], 'integer'],
            [['booking_category', 'commission'], 'string'],
            [['tax_rate', 'total_price'], 'number'],
            [['booking_date', 'created_at', 'updated_at'], 'safe'],
            [['pa_pnr'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pa_pnr' => 'Pa Pnr',
            'club_id' => 'Club ID',
            'booked_type' => 'Booked Type',
            'user_id' => 'User ID',
            'price_of_girl' => 'Price Of Girl',
            'price_of_stage' => 'Price Of Stage',
            'price_of_couple' => 'Price Of Couple',
            'booking_category' => 'Book for',
            'no_of_girls' => 'No Of Girls',
            'no_of_boys' => 'No Of Boys',
            'tax_rate' => 'Tax Rate',
            'commission_rate' => 'Commission Rate',
            'commission' => 'Commission',
            'convenience_fee' => 'Convenience Fee',
            'total_price' => 'Total Price',
            'booking_date' => 'Booking Date',
            'in_confirm' => 'In Confirm',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingPaymentHistories()
    {
        return $this->hasMany(BookingPaymentHistory::className(), ['booking_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClub()
    {
        return $this->hasOne(Club::className(), ['id' => 'club_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClubBookingNames()
    {
        return $this->hasMany(ClubBookingNames::className(), ['club_booking_id' => 'id']);
    }
     public function getClubName() {

        if ($this->club_id)
            return $this->club->name;
        else {
            return "-";
        }
    }
    public function getBookedName() 
    {
      
        if ($this->booked_type==0)
        {
         //$userinfo=\backend\models\User::find()->where(['id'=>$this->user_id])->asArray()->one();
          $club=ClubBookingNames::find()->select(['booking_name'])->where(['club_booking_id'=>$this->id])->asArray()->one();
          return $club['booking_name'];
        }
        else if($this->booked_type==1)
        {
         // $userinfo= \backend\models\GuestUser::find()->where(['id'=>$this->user_id])->asArray()->one();;
          $club=ClubBookingNames::find()->select(['booking_name'])->where(['club_booking_id'=>$this->id])->asArray()->one();
          return $club['booking_name'];
        }
        else {
            return "-";
        }
    }

    public function getBookingData() {
        $userinfo = \yii::$app->user->identity;
        $connection=  \Yii::$app->db;
         if ($userinfo['role_id'] == 2) {
              $bookingData=$connection->createCommand("select count(cb.id) as booking_no,cb.booking_date from club_booking as cb left join booking_payment_history as bph on cb.id=bph.booking_id  where cb.club_id=".$userinfo['club_id']." and bph.payment_status='Success' group by cb.booking_date")->queryAll();
           
        }else
        {
        $bookingData=$connection->createCommand("select count(cb.id) as booking_no,cb.booking_date from club_booking as cb left join booking_payment_history as bph on cb.id=bph.booking_id  where bph.payment_status='Success' group by cb.booking_date")->queryAll();
        }
        
       // var_dump($bookingData);die;
    
        return $bookingData;
        
    }
    
    public function getBookingTotal() {
        $userinfo = \yii::$app->user->identity;
        $connection=  \Yii::$app->db;
         if ($userinfo['role_id'] == 2) {
              $bookingData=$connection->createCommand("select count(cb.id) as total from club_booking as cb left join booking_payment_history as bph on cb.id=bph.booking_id  where cb.club_id=".$userinfo['club_id'])->queryAll();
           
        }else
        {
        $bookingData=$connection->createCommand("select count(cb.id) as total from club_booking as cb left join booking_payment_history as bph on cb.id=bph.booking_id ")->queryAll();
        }
        
       // var_dump($bookingData);die;
    
        return $bookingData;
        
    }
     public function getTodayBookingTotal() {
        $userinfo = \yii::$app->user->identity;
        $connection=  \Yii::$app->db;
         if ($userinfo['role_id'] == 2) {
              $bookingData=$connection->createCommand("select count(cb.id) as total from club_booking as cb inner join booking_payment_history as bph on cb.id=bph.booking_id  where cb.club_id=".$userinfo['club_id']." and booking_date=CURDATE()")->queryAll();
           
        }else
        {
        $bookingData=$connection->createCommand("select count(cb.id) as total from club_booking as cb inner join booking_payment_history as bph on cb.id=bph.booking_id  and booking_date=CURDATE()")->queryAll();
        }
        
       // var_dump($bookingData);die;
    
        return $bookingData;
        
    }
    
    public function getIn($date,$inpoutvalue)
    {   
         
        $bookingin= \backend\models\ClubBooking::find()->select("count(*) as inoutvalue")
                ->innerJoin("club_booking_names","club_booking_names.club_booking_id=club_booking.id")
                ->where(['club_booking.booking_date'=>$date])
                ->andWhere(['is_in'=>$inpoutvalue])->asArray()->one();
        if($bookingin)
        {
            return $bookingin['inoutvalue'];
        }
        else {
            return 0;
        }
    }
}
