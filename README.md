## Introduction
ExpertTexting REST API allows you to send text and unicode messages, read unread messages, check your account balance etc. ExpertTexting API is served over HTTPS. To ensure data privacy, unencrypted HTTP is not supported.

## Documentation 
- Send message : https://www.experttexting.com/appv2/Documentation/Send .
- Get status : https://www.experttexting.com/appv2/Documentation/Status .
- Retrieve account balance : https://www.experttexting.com/appv2/Documentation/Balance .
- List unread received messages : https://www.experttexting.com/appv2/Documentation/UnreadInbox .
## Instalition
- first create a new account in expert texting  
https://www.experttexting.com/appv2/

	 	composer require ahmed-aliraqi/expert-texting-sms
- add  provider class to app.php in config folder  . 
	
		Aliraqi\ET\ServiceProvider::class,

- add aliases class

		'SMS' => Aliraqi\ET\SMSFasade::class,
		
- then call this command from terminal

		php artisan vendor:publish
	you can get this file from this path on your project `config/sms_et.php`

		return [
            /**
             * All requests require your user credentials & API key, which you can find under "Account Settings"
             * in [https://www.experttexting.com/appv2/Dashboard/Profile] .
             */
            'username' => '', // Required. Your ET username. Ex: starcity
        
            'password' => '', // Required. Your ET password. Ex: StarCity123
        
            'api_key' => '',  // Required. Your API key. Ex: sswmp8r7l63y
        ];
   
## Usage
- Sends a text or unicode message. :

		$sms = SMS::from('YourName')
			->to('PhoneNumber')
			->Message('Hello World')
			->send();
		
		// Get response object.
		dd($sms->getResponse());
		
	result
		
		{
           "Response": {
              "message_id": "671729375",
              "message_count": 1,
              "price": 0.0085
           },
           "ErrorMessage": "",
           "Status": 0
        }

	

- Search a previously sent message for a given message id.

		SMS::getStatus($messageId)->getResponse();

- List all unread received messages.
		
		SMS::getUnreadInbox()->getResponse();

- Retrieve your current account balance.

		SMS::getBalance()->getResponse();