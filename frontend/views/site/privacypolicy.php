<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Privacy Policy';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="partyanimals">
<h2>Privacy Policy</h2>
<p>We at Infinite E Ticketing Pvt. Ltd. (“Company,” “we,” “us,” “our”) know that our users (“you,” “your”) sincerely care about how your personal information is used and shared, and we take your privacy sincerely. Please read the following to learn more about our Privacy Policy. By visiting or using the Website or Services in any manner, you acknowledge that you accept the practices and policies outlined in this Privacy Policy, and you hereby consent that we will collect, use, and share your information in the following ways. Any capitalized terms used herein without definition shall have the meaning given to them in the company Terms of Services.</p>

<h3>MODIFICATIONS</h3>
<p>We may amend this Privacy Policy from time to time. You are recommended to review it each time you use the services via website or app or other online channels. By continuing to use the Service after those changes become effective, you are agreeing to be bound by the revised Privacy Policy; if you do not agree to the change, simply don’t use the Service after the change is effective.</p>

<h3>USER’S CHOICE</h3>
<p>• You can always opt not to disclose information to use, but keep in mind some information may be needed to register with us or to take advantage of some of our special features.
	<br><br>
   • You may be able to add, update, or delete information which You provide. When you update information, however, we may maintain a copy of the unrevised information in our records. You may request deletion of your account by emailing us at support@partyanimals.in. We will delete all of the content contained in your profile; however, please note that some information may remain in our records after your deletion of such information from your account. We may also keep a copy of any such information for legal archival purposes. We may use any aggregated data derived from or incorporating your Personal Information after you update or delete it, but not in a manner that would identify you personally.
</p>

<h3>INFORMATION WE COLLECT</h3>
<div class="tnc">
<ul>
	<li><strong>Information You Provide to Us:</strong><br>
		We receive and store any information you knowingly provide to us. For example, we collect Personal Information such as your name, email address, bank account information, browser information, and third-party account credentials (for example, your log-in credentials for Facebook or other third party sites). If you provide your third-party account credentials to us, you understand some content and/or information in those accounts (“Third Party Account Information”) may be transmitted into your account with us if you authorize such transmissions, and that Third Party Account Information transmitted to our Services is covered by this Privacy Policy. You can choose not to provide us with certain information, but then you may not be able to register with us or to take advantage of some of our features. We may anonymize your Personal Information so that you cannot be individually identified, and provide that information to our partners.
		If you have provided us with a means of contacting you, we may use such means to communicate with you. For example, we may communicate with you about your use of the Services. Also, we may receive a confirmation when you open a message from us. This confirmation helps us make our communications with you more interesting and improve our services. If you do not want to receive communications from us that are not important to the Service, please indicate your preference by clicking on the unsubscribe link provided at the bottom of each email sent to you by us. Please note that if you do not want to receive legal notices from us, those legal notices will still govern your use of the Services, and you are responsible for reviewing such legal notices for changes.
	</li>
	<li><strong>Information Collected Automatically:</strong><br>
		• When you interact with our Services, we automatically receive and record information on our server logs from your browser including your IP address, “cookie” information, and the page you requested. “Cookies” are identifiers we transfer to your computer or mobile device that allow us to recognize your browser or mobile device and tell us how and when pages and features in our Services are visited and by how many people. You may be able to change the preferences on your browser or mobile device to prevent or limit your computer or device’s acceptance of cookies, but this may prevent you from taking advantage of some of our features. If you click on a link to a third party website, such third party may also transmit cookies to you. This Privacy Policy does not cover the use of cookies by any third parties.
		<br><br>
		• When we collect usage information (such as the numbers and frequency of visitors to the Website), we only use this data in aggregate form, and not in a manner that would identify you personally. For example, this aggregate data tells us how often users use parts of the Services, so that we can make the Services appealing to as many users as possible. We may also provide this aggregate information to our partners; our partners may use such information to understand how often and in what ways people use our Services, so that they, too, can provide you with an optimal experience.
	</li>
</ul>
</div>

<h3>SECURITY</h3>
<p>Your account is password-protected for your privacy and security. If you access your account via a third party site or service, you may have additional or different sign-on protections via that third party site or service. You must prevent unauthorized access to your account and Personal Information by selecting and protecting your password and/or other sign-on mechanism appropriately and limiting access to your computer or device and browser. Signing off after you have finished accessing your account is recommended.</p>
<p>We endeavor to protect the privacy of your account and other Personal Information we hold in our records, but we cannot guarantee complete security. Unauthorized entry or use, hardware or software failure, and other factors, may compromise the security of user information at any time.</p>
<p>We do not specifically intend to service underage user, or user below the age of respective years which an event organizer or club or venue has set, according to the respective law of state across the india and hence do not collect any information in this regard, unless it is an event for all age groups and is permitted by law. If you are a parent or guardian of a minor child and believe that he or she has disclosed personal information to us, please mail us at <a href="mailto:support@partyanimals.in">support@partyanimals.in</a> with appropriate scanned documents so that we can proceed to terminate such accounts.</p>
<p>The Services may contain links to other sites. We are not responsible for the privacy policies and/or practices on other sites. When following a link to another site you should read that site’s privacy policy. Additionally we use Encryption to secure our data.</p>
<p>We will not sell, trade or disclose to third parties any information derived from the registration for, or use of, any online service (including names and addresses) without the consent of the user or customer (except as required by subpoena, search warrant, or other legal process or in the case of imminent physical harm to the user or others). We will allow affiliates to access the information for purposes of confirming your registration and providing you with benefits you are entitled to.</p>

<h3>QUERIES OR CONCERNS</h3>
<p>If you have any questions or concerns regarding our privacy policies, please send us a detailed message to <a href="mailto:support@partyanimals.in">support@partyanimals.in</a>, and we will try to resolve your concerns.</p>
</div>

</div>
<?php

$this->registerJs('$("document").ready(function(){ 
 	$(".navbar-toggle").click(function(e) {
		 $("#wrapper").toggleClass("toggled");
    });
		
});');

?>