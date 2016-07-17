<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "booking_payment_history".
 *
 * @property integer $id
 * @property integer $booking_id
 * @property string $payment_type
 * @property double $amount
 * @property string $payment_transaction_id
 * @property string $raw_request
 * @property string $response
 * @property string $payment_status
 * @property string $customer_ip
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ClubBooking $booking
 */
class BookingPaymentHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking_payment_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['booking_id', 'amount', 'raw_request', 'customer_ip'], 'required'],
            [['booking_id'], 'integer'],
            [['amount'], 'number'],
            [['response', 'payment_status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['payment_type'], 'string', 'max' => 100],
            [['payment_transaction_id'], 'string', 'max' => 150],
            [['raw_request'], 'string', 'max' => 500],
            [['customer_ip'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'booking_id' => 'Booking ID',
            'payment_type' => 'Payment Type',
            'amount' => 'Amount',
            'payment_transaction_id' => 'Payment Transaction ID',
            'raw_request' => 'Raw Request',
            'response' => 'Response',
            'payment_status' => 'Payment Status',
            'customer_ip' => 'Customer Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooking()
    {
        return $this->hasOne(ClubBooking::className(), ['id' => 'booking_id']);
    }
    public function getPaymentHistory($booking_id)
    {
        $db = Yii::$app->db;

        $query = $db->createCommand("SELECT * FROM  `booking_payment_history` WHERE booking_id =  '" . $booking_id . "' ");

        $result = $query->queryOne();
        
        return $result;
        
    }
}
