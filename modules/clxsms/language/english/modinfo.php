<?php

	// Admin Menus
	define('_MI_CLXSMS_ADMENU1', "Dashboard");
	define('_MI_CLXSMS_ADMENU2', "About module");

	// Module Preferences & Configurations
	define('_MI_CLXSMS_USERNAME', 'Cardboard CLX Allocated Username');
	define('_MI_CLXSMS_USERNAME_DESC', 'This is the Username provided by <a href="http://www.cardboardclx.com">HTTPSMS Services on Cardboard CLX</a>');
	define('_MI_CLXSMS_PASSWORD', 'Cardboard CLX Allocated Password');
	define('_MI_CLXSMS_PASSWORD_DESC', 'This is the Password provided by <a href="http://www.cardboardclx.com">HTTPSMS Services on Cardboard CLX</a>');
	define('_MI_CLXSMS_SMS_NODE_ONE_URL', 'Cardboard CLX SMS Node 1 URL');
	define('_MI_CLXSMS_SMS_NODE_ONE_URL_DESC', 'This is the URL provided as Node 1 by <a href="http://www.cardboardclx.com">HTTPSMS Services on Cardboard CLX</a>');
	define('_MI_CLXSMS_SMS_NODE_TWO_URL', 'Cardboard CLX SMS Node 2 URL');
	define('_MI_CLXSMS_SMS_NODE_TWO_URL_DESC', 'This is the URL provided as Node 2 by <a href="http://www.cardboardclx.com">HTTPSMS Services on Cardboard CLX</a>');
	define('_MI_CLXSMS_SMS_NODE_THREE_URL', 'Cardboard CLX SMS Node 2 URL');
	define('_MI_CLXSMS_SMS_NODE_THREE_URL_DESC', 'This is the URL provided as Node 3 by <a href="http://www.cardboardclx.com">HTTPSMS Services on Cardboard CLX</a>');
	define('_MI_CLXSMS_SMS_NODE_RECOMMENDED', 'SMS Node Recommended to you by Cardboard CLX');
	define('_MI_CLXSMS_SMS_NODE_RECOMMENDED_DESC', 'SMS Node Recommended to you when subscribing to <a href="http://www.cardboardclx.com">HTTPSMS Services on Cardboard CLX</a> <em>(This is the one that is used by this module)</em>');
	define('_MI_CLXSMS_SMS_NODE_ONE', 'SMS Node One');
	define('_MI_CLXSMS_SMS_NODE_TWO', 'SMS Node Two');
	define('_MI_CLXSMS_SMS_NODE_THREE', 'SMS Node Three');
	define('_MI_CLXSMS_MAXIMUM_SMS_PER_DAY', 'Maximum SMS to send per Day');
	define('_MI_CLXSMS_MAXIMUM_SMS_PER_DAY_DESC', 'This is the maximum amount of SMS allowed to be sent each day, "0" is unlimited, and the previous days tally is added to the next days amount!');
	define('_MI_CLXSMS_MAXIMUM_SMS_PER_MONTH', 'Maximum SMS to send per month');
	define('_MI_CLXSMS_MAXIMUM_SMS_PER_MONTH_DESC', 'This is the absolute maximum amount of SMS allowed to be sent each month, "0" is unlimited!');
	define('_MI_CLXSMS_VIRTUAL_NUMBER', 'Cardboard CLX Virtual Number');
	define('_MI_CLXSMS_VIRTUAL_NUMBER_DESC', 'This is the +44 number you are given when you subscribe to <a href="http://www.cardboardclx.com">Virtual numbers on Cardboard CLX</a>');
	define('_MI_CLXSMS_RETRY_SECONDS', 'Number of seconds to wait before retrying');
	define('_MI_CLXSMS_RETRY_SECONDS_DESC', 'This is the number of seconds to wait before retrying sending an SMS or Direct action in the system!');
	define('_MI_CLXSMS_RECIEVE_METHOD', 'How you are recieving your SMS');
	define('_MI_CLXSMS_RECIEVE_METHOD_DESC', 'This is how you want to receive your SMS on this module');
	define('_MI_CLXSMS_RECIEVE_METHOD_CALLBACK', 'Receive with Callback');
	define('_MI_CLXSMS_RECIEVE_METHOD_POLL', 'Receive by Polling');
	define('_MI_CLXSMS_POLLING_SECONDS', 'Receive by polling every period');
	define('_MI_CLXSMS_POLLING_SECONDS_DESC', 'This is the number of seconds to wait between polling for SMS on Cardboard CLX when the cron method is set to "XOOPS Preloaders"');
	define('_MI_CLXSMS_API_METHOD', 'API Calling Method');
	define('_MI_CLXSMS_API_METHOD_DESC', 'This is the function method to use when polling or using the Cardboard CLX API\'s');
	define('_MI_CLXSMS_API_METHOD_FURL', 'Furl Methods');
	define('_MI_CLXSMS_API_METHOD_CURL', 'Curl Methods');
	define('_MI_CLXSMS_CRON_METHOD', 'Schedule tasks method is');
	define('_MI_CLXSMS_CRON_METHOD_DESC', 'This is the method you have either set up on your service with either "crontab" or "scheduled tasks" which you would select "System" otherwise if you want XOOPS to take control of it select "XOOPS Preloaders"');
	define('_MI_CLXSMS_CRON_METHOD_PRELOADER', 'XOOPS Preloader');
	define('_MI_CLXSMS_CRON_METHOD_SYSTEM', 'System Set Tasks');
	define('_MI_CLXSMS_CRON_SECONDS', 'Schedule task periodical wait');
	define('_MI_CLXSMS_CRON_SECONDS_DESC', 'If you have for your scheduled task method selected "XOOPS Preloader" this setting is how often these tasks execute!');
	define('_MI_CLXSMS_SMS_LEVELS_ANYWAY', 'Send SMS Anyway when Level is');
	define('_MI_CLXSMS_SMS_LEVELS_ANYWAY_DESC', 'This is the SMS Levels that when you create with the "send" class an SMS that is set to one of these levels, if credits exist and limits have been set and been hit then it will send anyway!');
	define('_MI_CLXSMS_SMS_LEVELS_REQUIRED', 'SMS Level Required');
	define('_MI_CLXSMS_SMS_LEVELS_IMPORTANT', 'SMS Level Important');
	define('_MI_CLXSMS_SMS_LEVELS_NORMAL', 'SMS Level Normal');
	define('_MI_CLXSMS_SMS_LEVELS_LOW', 'SMS Level Low');
	define('_MI_CLXSMS_NO_CREDIT_NOTIFY', 'No Credits Reported by API Report to Group');
	define('_MI_CLXSMS_NO_CREDIT_NOTIFY_DESC', 'When the cardclx API has no credits to send an SMS this is the Groups that are notified on the System <em>("Normally only admin")</em>');
	define('_MI_CLXSMS_RESPONSES_DELETED', 'Seconds API Responses Kept For');
	define('_MI_CLXSMS_RESPONSES_DELETED_DESC', 'This is the number of seconds an API Response is kept for incase any debugging is needed <em>("0" stops any recorded API responses in the Database)</em>.');
	define('_MI_CLXSMS_SMS_DELETED', 'Seconds SMS are Kept For');
	define('_MI_CLXSMS_SMS_DELETED_DESC', 'Number of Seconds by Default unless specified diffently by programmer, plugin or system variable that an SMS either sent or received is stored in the database for Auditing!');
	define('_MI_CLXSMS_CURL_CONNECT_TIMEOUT', 'Seconds connection can take before timeout');
	define('_MI_CLXSMS_CURL_CONNECT_TIMEOUT_DESC', 'Number of Seconds a connection can take before timeout on curl responses!');
	define('_MI_CLXSMS_CURL_TIMEOUT', 'Seconds response can take before timeout');
	define('_MI_CLXSMS_CURL_TIMEOUT_DESC', 'Number of Seconds a response can take before timeout on a curl response!');
	define('_MI_CLXSMS_CURL_USER_AGENT', 'UserAgent for cURL');
	define('_MI_CLXSMS_CURL_USER_AGENT_DESC', 'This is the client User Agent used when a curl API method is used!');
	
	//Module Settings	
	define('_MI_CLXSMS_NAME', 'Cardboard CLX Services');
	define('_MI_CLXSMS_VERSION', 1.04);
	define('_MI_CLXSMS_RELEASDATE', 'Sunday: 11 May 2014');
	define('_MI_CLXSMS_STATUS', 'Mature');
	define('_MI_CLXSMS_AUTHOR', 'Chronolabs Cooperative');
	define('_MI_CLXSMS_CREDITS', 'Simon Roberts');
	define('_MI_CLXSMS_TEAMMEMBERS', 'Wishcraft');
	define('_MI_CLXSMS_LICENSE', 'GPL');
	define('_MI_CLXSMS_OFFICIAL', false);
	define('_MI_CLXSMS_DESCRIPTION', 'Cardboard CLX SMS Services was written for Ringwould Farm & John Sanches who kindly donated it to the Open Source & XOOPS Community');
	define('_MI_CLXSMS_HELP', '');
	define('_MI_CLXSMS_IMAGE', 'images/clxsms_slogo.png');
	define('_MI_CLXSMS_DIRNAME', 'clxsms');
	define('_MI_CLXSMS_WEBSITE', 'chrono.labs.coop');

?>