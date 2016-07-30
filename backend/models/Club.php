<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "club".
 *
 * @property string $id
 * @property string $name
 * @property string $address
 * @property integer $club_capacity
 * @property integer $booking_capacity
 * @property string $logo
 * @property string $area
 * @property string $city_id
 * @property integer $priority_range
 * @property double $booking_rate_ladies
 * @property double $booking_rate_boy
 * @property double $booking_rate_couple
 * @property string $club_open_days
 * @property string $bank_name
 * @property string $bank_account_number
 * @property string $bank_branch
 * @property string $ifsc_code
 * @property integer $is_active
 * @property string $created_date
 * @property string $modified_date
 *
 * @property BookingCapacityAsdate[] $bookingCapacityAsdates
 * @property BookingRateAsdate[] $bookingRateAsdates
 * @property City $city
 * @property ClubBooking[] $clubBookings
 */
class Club extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'club';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','bank_account_holder_name', 'address', 'club_capacity', 'booking_capacity',  'city_id', 'priority_range', 'booking_rate_ladies', 'booking_rate_boy', 'booking_rate_couple', 'is_active','club_open_time','club_close_time','booking_close_time'], 'required'],
            [['club_capacity', 'booking_capacity', 'city_id', 'priority_range','convenience_fee', 'bank_account_number', 'is_active'], 'integer'],
            [['booking_rate_ladies', 'booking_rate_boy', 'booking_rate_couple','tax_rate','commission_rate','convenience_fee','commission_for_girl','commission_for_stage','commission_for_couple'], 'number'],
          //  [['club_open_days'], 'string'],
            [['logo'], 'file'],
         //   [['booking_capacity'],'compare','compareAttribute'=>'club_capacity','operator'=>'<=','message'=>'booking capacity must be less than club capacity.'],
            ['booking_capacity','checkbooking'],
          //  ['club_capacity','checkbooking'],
            [['created_date', 'modified_date','facility'], 'safe'],
            [['created_date', 'modified_date'], 'safe'],
            [['name', 'area','TAN','PAN'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 250],   
            [['ifsc_code','MICR','swift_code','bank_account_number'],'unique','on'=>'create'],
            [['bank_name', 'bank_branch', 'ifsc_code'], 'string', 'max' => 50],
            [['bank_account_holder_name'], 'string', 'max' => 150],
            [['ifsc_code'], 'string', 'max' => 11],
            [['MICR','swift_code'], 'string', 'max' => 150],
            [['convenience_fee'], 'default','value'=>"0"],
            [['convenience_fee'], 'number'],
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
            'club_open_time'=>"Club Open Time",
            'club_close_time'=>"Club Close Time",
            'booking_close_time'=>"Booking Close Time",
            'address' => 'Address',
            'club_capacity' => 'Club Capacity',
            'booking_capacity' => 'Booking Capacity',
            'logo' => 'Logo',
            'area' => 'Location',
            'city_id' => 'City',
            'priority_range' => 'Priority Range',
            'booking_rate_ladies' => 'Girl Rate',
            'booking_rate_boy' => 'Stage Rate',
            'booking_rate_couple' => 'Couple Rate',
            'club_open_days' => 'Club Close On',
            'bank_name' => 'Bank Name',
            'bank_account_number' => 'Bank Account Number',
            'bank_branch' => 'Bank Branch',
            'ifsc_code' => 'Ifsc Code',
            'is_active' => 'Is Active',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingCapacityAsdates()
    {
        return $this->hasMany(BookingCapacityAsdate::className(), ['club_id' => 'id']);
    }
    
     public function checkbooking()
        {
           
                $clubcapacity=$this->getAttribute("club_capacity");
               $bookingcapacity=$this->getAttribute("booking_capacity");
                
                if($clubcapacity < $bookingcapacity)
                {
                     
                    $this->addError('booking_capacity',"booking capacity must be less than club capacity");
                     
                    
                }
        }
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingRateAsdates()
    {
        return $this->hasMany(BookingRateAsdate::className(), ['club_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClubBookings()
    {
        return $this->hasMany(ClubBooking::className(), ['club_id' => 'id']);
    }
    public function getCityName()
    {
        
        return $this->city->name;
    }
	
    static function getCurentClubAvailableCapacity($id,$txt_date)
	{
		$connection = \Yii::$app->db;
		if($id)
		{
			$model = $connection->createCommand('select no_of_booking,is_full from
				booking_capacity_asdate
				where club_id = '.$id.' and capacity_active_date = '.date('Y-m-d' ,strtotime($txt_date)).' limit 0,1');

			//echo $model->getRawSql();
			$arr_result = $model->queryAll();
            
            $arr_city = array();
			
			$return_array = $arr_result;
			if(count($return_array) > 0) {
				if($return_array[0]['is_full'] == 1)
					return 0;
				else
					return $return_array[0]['no_of_booking'];
			}
			else
				return 1;
		}
	}

    static function is_full_club($id,$txt_date)
    {
        $connection = \Yii::$app->db;
        if($id)
        {
            $model = $connection->createCommand('select no_of_booking,is_full from
                booking_capacity_asdate
                where club_id = '.$id.' and capacity_active_date = "'.date('Y-m-d' ,strtotime($txt_date)).'" limit 0,1');

            //echo $model->getRawSql();
            //die;
            $arr_result = $model->queryAll();
            
            $arr_city = array();
            
            $return_array = $arr_result;
            if(count($return_array) > 0) {
                if($return_array[0]['is_full'] == 1)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
    }
}
