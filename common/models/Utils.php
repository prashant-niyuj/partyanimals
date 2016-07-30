<?php

namespace common\models;

use Yii;
use yii\base\Model;
use backend\models\UserRoles;
use backend\models\Users;
use backend\models\Company;
use backend\models\Landscapes;
use yii\web\UploadedFile;
use DateTime;
use \yii\helpers\ArrayHelper;

class Utils extends Model {

    /** @var string */
    public $viewPath = '@common/mail';
    public $sender;

    function resize($imagePath, $destinationWidth, $destinationHeight, $destinationPath) {
        if (file_exists($imagePath)) {
            $imageInfo = getimagesize($imagePath);
            $sourceWidth = $imageInfo[0];
            $sourceHeight = $imageInfo[1];
            $source_aspect_ratio = $sourceWidth / $sourceHeight;
            $thumbnail_aspect_ratio = $destinationWidth / $destinationHeight;
            if ($sourceWidth <= $destinationWidth && $sourceHeight <= $destinationHeight) {
                $thumbnail_image_width = $sourceWidth;
                $thumbnail_image_height = $sourceHeight;
            } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                $thumbnail_image_width = (int) ($destinationWidth);
                $thumbnail_image_height = $destinationHeight;
            } else {
                $thumbnail_image_width = $destinationWidth;
                $thumbnail_image_height = (int) ($destinationHeight);
            }
            //$destinationWidth = $thumbnail_image_width;
            //$destinationHeight = $thumbnail_image_height;
            $mimeType = $imageInfo['mime'];
            //  $destinationWidth = $thumbnail_image_width;
            //$destinationHeight = $thumbnail_image_height;
            $destination = imagecreatetruecolor($destinationWidth, $destinationHeight);
            if ($mimeType == 'image/jpeg' || $mimeType == 'image/pjpeg') {
                $source = imagecreatefromjpeg($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                $destinationPath = $destinationPath;
                imagejpeg($destination, $destinationPath);
            } else if ($mimeType == 'image/gif') {
                $source = imagecreatefromgif($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                $destinationPath = $destinationPath;
                imagegif($destination, $destinationPath);
            } else if ($mimeType == 'image/png' || $mimeType == 'image/x-png') {
                $source = imagecreatefrompng($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                $destinationPath = $destinationPath;
                imagepng($destination, $destinationPath);
            } else {
                echo 'This image type is not supported.';
            }
        } else {
            echo 'The requested file does not exist.';
        }
    }

    public function saveFileName($model, $field_name, $path) {

        $image = UploadedFile::getInstance($model, $field_name);
        // var_dump($image);die;
        // store the source file name
        if (isset($image)) {
            //$model->service_filename = $image->name;
            //$ext = end((explode(".", $image->name)));

            $ext = end((explode(".", $image->name)));

            // generate a unique file name
            $model->$field_name = Yii::$app->security->generateRandomString() . ".{$ext}";

            // generate a unique file name
            //$model->$field_name = $image->name;
            // the path to save file, you can set an uploadPath
            // in Yii::$app->params (as used in example below)
            $fullpath = Yii::$app->basePath . "/web/" . $path . "/" . $model->$field_name;


            $image->saveAs($fullpath);
            return $fullpath;
        } else {
            return false;
        }
    }
	
	public function randomString($length = 8) {
		$alphabets = range('A','Z');
		$numbers = range('0','9');
		$additional_characters = array('_');
		$password='';
		$final_array = array_merge($alphabets,$numbers,$additional_characters);
		   while($length--) {
		  $key = array_rand($final_array);

		  $password .= $final_array[$key];
							}
		if (preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password))
		{
		 return $password;
		}else{
		return  random_string();
		}

	 }
public function sendMessage($to, $subject, $view, $params = [],$from='',$from_name='') {
        
        $mailer = \Yii::$app->mailer;
        $mailer->viewPath = $this->viewPath;
        $mailer->getView()->theme = \Yii::$app->view->theme;
        $viewpath=$this->viewPath."/".$view;
       
         $message = Yii::$app->controller->renderPartial($viewpath, $params);
       //  var_dump($message);die;
         if($from=="")
         {
           
                //$this->sender = isset(\Yii::$app->params['adminEmail']) ? \Yii::$app->params['adminEmail'] : 'no-reply@party-animals.in';
                $this->sender ="support@partyanimals.in";
           
         }else{
             
             $this->sender =$from;
         }
           // Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	if($from_name == '')
    {
        $from_name = "Party Animals";
    }
    //$this->sender ="support@partyanimals.in";

    $headers .= 'From: '.$from_name.' <'.$this->sender .'>'. "\r\n";
   //  $headers .= 'From: support@partyanimals.in'. "\r\n";
    $viewPath = $this->viewPath."/".$view;
           
      
        $message = Yii::$app->controller->renderPartial($viewPath, $params);
        
        // $sendmail=  mail($to, $subject, $message,$headers);

        $sendmail=$mailer->compose($viewpath, $params)
                        ->setTo($to)
                        ->setFrom($this->sender)
                        ->setSubject($subject)
                        ->send();
                        
     
        
        return $sendmail;
        
        
    }
    public function sendSMS($to, $subject, $view, $params = [])
    {
        $viewPath = $this->viewPath."/".$view;
      
        $message = Yii::$app->controller->renderPartial($viewPath, $params);
        $fields = array(
						'user' => urlencode("PrashantPatil"),
						'pass' => urlencode("Farkande7"),
						'sender' => urlencode("PARTYA"),
						'phone' => urlencode($params['mobile_no']),
						'text' => urlencode($message),
						'priority' => urlencode("ndnd"),
						'stype' => urlencode("normal")
				);

	//url-ify the data for the POST
	$fields_string="";
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

        $url="http://bhashsms.com/api/sendmsg.php";
      	//echo $url;die;  $url="http://bhashsms.com/api/sendmsg.php?user=PrashantPatil&pass=Farkande7&sender=PARTYA&phone=".$params['mobile_no']."&text=".$message."&priority=ndnd&stype=normal";
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
      
        $output=curl_exec($ch);
     
       
        
    }
	
}
