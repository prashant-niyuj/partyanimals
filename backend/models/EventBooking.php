<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "event_booking".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property integer $no_ticket
 * @property string $total_amount
 * @property string $pnr
 * @property string $ip
 * @property integer $is_confrm
 * @property string $payment_id
 * @property string $payment_responce
 * @property string $created_date
 */
class EventBooking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'mobile', 'no_ticket', 'total_amount', 'pnr', 'ip', 'payment_id', 'payment_responce'], 'required'],
            [['no_ticket', 'is_confrm'], 'integer'],
            [['created_date'], 'safe'],
            [['name', 'email'], 'string', 'max' => 200],
            [['mobile', 'total_amount', 'ip'], 'string', 'max' => 100],
            [['pnr'], 'string', 'max' => 20],
            [['payment_id'], 'string', 'max' => 50],
            [['payment_responce'], 'string', 'max' => 500]
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
            'email' => 'Email',
            'mobile' => 'Mobile',
            'no_ticket' => 'No Ticket',
            'total_amount' => 'Total Amount',
            'pnr' => 'Pnr',
            'ip' => 'Ip',
            'is_confrm' => 'Is Confrm',
            'payment_id' => 'Payment ID',
            'payment_responce' => 'Payment Responce',
            'created_date' => 'Created Date',
        ];
    }
}
