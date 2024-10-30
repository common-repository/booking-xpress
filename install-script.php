<?php
global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . servicesTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . servicesTable() . '(
		ServiceId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		ServiceColorCode VARCHAR(10) NOT NULL,
		ServiceName VARCHAR(200) NOT NULL,
		ServiceCost DECIMAL(10, 2) NOT NULL,
		MaxDays VARCHAR(20),
		CostType INTEGER(2) NOT NULL,
		ServiceDisplayOrder INTEGER(5) NOT NULL,
		ServiceMaxBookings INTEGER(10),
		ServiceFullDay INTEGER(2) NOT NULL,
		ServiceTotalTime INTEGER(10) NOT NULL,
		ServiceStartTime INTEGER(10) NOT NULL,
		ServiceEndTime INTEGER(10) NOT NULL,
		Type INTEGER(2) NOT NULL,
		PRIMARY KEY (ServiceId),
		KEY `idx_ServiceName` (`ServiceName`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . customersTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . customersTable() . '(
		CustomerId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		CustomerFirstName VARCHAR(50) NOT NULL,
		CustomerLastName VARCHAR(50) NOT NULL,
		CustomerEmail VARCHAR(100) NOT NULL,
		CustomerTelephone VARCHAR(20) NOT NULL,
		CustomerMobile VARCHAR(20) NOT NULL,
		CustomerAddress1 VARCHAR(100) NOT NULL,
		CustomerAddress2 VARCHAR(100) NOT NULL,
		CustomerSkypeId VARCHAR(100) NOT NULL,
		CustomerCity VARCHAR(50) NOT NULL,
		CustomerZipCode VARCHAR(50) NOT NULL,
		CustomerCountry INTEGER(5) NOT NULL,
		CustomerComments TEXT NOT NULL,
		DateTime DATE NOT NULL,
		PRIMARY KEY (CustomerId),
		KEY `idx_CustomerFirstName` (`CustomerFirstName`),
		KEY `idx_CustomerLastName` (`CustomerLastName`),
		KEY `idx_CustomerEmail` (`CustomerEmail`),
		KEY `idx_CustomerMobile` (`CustomerMobile`),
		KEY `idx_CustomerCity` (`CustomerCity`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . bookingTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . bookingTable() . '( 
		BookingId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		CustomerId INTEGER(10) NOT NULL,
		ServiceId INTEGER(10) NOT NULL,
		TimeSlot INTEGER(10) NOT NULL,
		BookingDate DATE NOT NULL,
		BookingStatus VARCHAR(50),
		DateofBooking DATE NOT NULL,
		Comments VARCHAR(250),
		TransactionId VARCHAR(50),
		PaymentStatus VARCHAR(20),
		PaymentDate DATETIME,
		couponCode VARCHAR(100),
		PRIMARY KEY (BookingId)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . social_Media_settingsTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . social_Media_settingsTable() . '(
		SocialMediaId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		SocialMediaKey VARCHAR(100) NOT NULL,
		SocialMediaValue VARCHAR(100) NOT NULL,
		PRIMARY KEY (SocialMediaId),
		KEY `idx_SocialMediaKey` (`SocialMediaKey`),
		KEY `idx_SocialMediaValue` (`SocialMediaValue`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".social_Media_settingsTable()."(SocialMediaKey,SocialMediaValue) VALUES(%s, %s)",
				"facebook-connect-enable",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".social_Media_settingsTable()."(SocialMediaKey,SocialMediaValue) VALUES(%s, %s)",
				"facebook-api-id",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(  
				"INSERT INTO ".social_Media_settingsTable()."(SocialMediaKey,SocialMediaValue) VALUES(%s, %s)",
				"facebook-secret-key",
				""
			)
		);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . payment_Gateway_settingsTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . payment_Gateway_settingsTable() . '(
		PaymentGatewayId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		PaymentGatewayKey VARCHAR(100) NOT NULL,
		PaymentGatewayValue text NOT NULL,
		PRIMARY KEY (PaymentGatewayId),
		KEY `idx_PaymentGatewayKey` (`PaymentGatewayKey`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".payment_Gateway_settingsTable()."(PaymentGatewayKey,PaymentGatewayValue) VALUES(%s, %s)",
				"paypal-enabled",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".payment_Gateway_settingsTable()."(PaymentGatewayKey,PaymentGatewayValue) VALUES(%s, %s)",
				"paypal-merchant-email-address",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".payment_Gateway_settingsTable()."(PaymentGatewayKey,PaymentGatewayValue) VALUES(%s, %s)",
				"paypal-thankyou-page-url",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".payment_Gateway_settingsTable()."(PaymentGatewayKey,PaymentGatewayValue) VALUES(%s, %s)",
				"paypal-ipn-url",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".payment_Gateway_settingsTable()."(PaymentGatewayKey,PaymentGatewayValue) VALUES(%s, %s)",
				"paypal-payment-image-url",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".payment_Gateway_settingsTable()."(PaymentGatewayKey,PaymentGatewayValue) VALUES(%s, %s)",
				"paypal-payment-cancellation-Url",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".payment_Gateway_settingsTable()."(PaymentGatewayKey,PaymentGatewayValue) VALUES(%s, %s)",
				"paypal-Test-Url",
				"https://paypal.com/cgi-bin/webscr"
			)
		);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . auto_Responders_settingsTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . auto_Responders_settingsTable() . '(
		AutoResponderId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		AutoResponderKey VARCHAR(100) NOT NULL,
		AutoResponderValue VARCHAR(100) NOT NULL,
		PRIMARY KEY (AutoResponderId),
		KEY `idx_AutoResponderKey` (`AutoResponderKey`),
		KEY `idx_AutoResponderValue` (`AutoResponderValue`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".auto_Responders_settingsTable()."(AutoResponderKey,AutoResponderValue) VALUES(%s, %s)",
				"mail-chimp-enabled",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".auto_Responders_settingsTable()."(AutoResponderKey,AutoResponderValue) VALUES(%s, %s)",
				"mail-chimp-api-key",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			( 
				"INSERT INTO ".auto_Responders_settingsTable()."(AutoResponderKey,AutoResponderValue) VALUES(%s, %s)",
				"mail-chimp-unique-id",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			( 
				"INSERT INTO ".auto_Responders_settingsTable()."(AutoResponderKey,AutoResponderValue) VALUES(%s, %s)",
				"mail-double-optin-id",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			( 
				"INSERT INTO ".auto_Responders_settingsTable()."(AutoResponderKey,AutoResponderValue) VALUES(%s, %s)",
				"mail-welcome-email",
				""
			)
		);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . generalSettingsTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . generalSettingsTable() . '(
		GeneralSettingsId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		GeneralSettingsKey TEXT NOT NULL,
		GeneralSettingsValue TEXT NOT NULL,
		PRIMARY KEY (GeneralSettingsId)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
		$wpdb->query
		(
			$wpdb->prepare
			( 
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"resources-visible-enable",
	 			"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"default_Time_Format",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"booking_image",
				"bookNow.jpg"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"default_Date_Format",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"default_Time_Zone",
				"-5.0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"auto-approve-enable",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"booking-ThankYou-message",
				"Thank you for requesting an appointment with us.<br>You will shortly receive an email acknowledging your request  and a member of staff will later contact you to confirm your<br>appointment has been booked.<br>(Please ensure to check your Spam / Junk folders as sometimes emails are caught there).<br><br>Thank you for using our online booking service.<br>The Support Team"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"booking-Footer-message",
				"booking Footer message Here"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"booking-header-message",
				"booking Header message Here"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"reminder-settings",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
				"reminder-settings-interval",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)", 
				"default_Service_Display",
				"0"
			)
		);	
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . currenciesTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . currenciesTable() . '(
		CurrencyId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		CurrencyName VARCHAR(50) NOT NULL,
		CurrencySymbol VARCHAR(10) NOT NULL,
		CurrencyCode VARCHAR(10) NOT NULL,
		CurrencyUsed INTEGER(1) NOT NULL,
		PRIMARY KEY (CurrencyId),
		KEY `idx_CurrencyName` (`CurrencyName`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Albania Lek",
				"0",
				"Lek",
				"ALL"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Afghanistan Afghani",
				"0",
				"؋",
				"AFN"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Argentina Peso",
				"0",
				"$",
				"ARS"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Aruba Guilder",
				"0",
				"ƒ",
				"AWG"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Australia Dollar",
				"0",
				"$",
				"AUD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Azerbaijan New Manat",
				"0",
				"ман",
				"AZN"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Bahamas Dollar",
				"0",
				"$",
				"BSD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Barbados Dollar",
				"0",
				"$",
				"BBD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Belarus Ruble",
				"0",
				"p.",
				"BYR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Belize Dollar",
				"0",
				"BZ$",
				"BZD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Bermuda Dollar",
				"0",
				"$",
				"BMD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Bosnia and Herzegovina Convertible Marka",
				"0",
				"KM",
				"BAM"
			)
		);	
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Botswana Pula",
				"0",
				"P",
				"BWP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Bulgaria Lev",
				"0",
				"лв",
				"BGN"
			)
		);	
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Brazil Real",
				"0",
				"R$",
				"BRL"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Brunei Darussalam Dollar",
				"0",
				"$",
				"BND"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Canada Dollar",
				"0",
				"$",
				"CAD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Cayman Islands Dollar",
				"0",
				"$",
				"KYD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Chile Peso",
				"0",
				"$",
				"CLP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"China Yuan Renminbi",
				"0",
				"¥",
				"CNY"
			)
		);	
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Colombia Peso",
				"0",
				"$",
				"COP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Costa Rica Colon",
				"0",
				"₡",
				"CRC"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Croatia Kuna ",
				"0",
				"kn",
				"HRK"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Cuba Peso",
				"0",
				"₱",
				"CUP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Czech Republic Koruna",
				"0",
				"Kč",
				"CZK"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Denmark Krone",
				"0",
				"kr",
				"DKK"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Dominican Republic Peso",
				"0",
				"RD$",
				"DOP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"East Caribbean Dollar",
				"0",
				"$",
				"XCD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Egypt Pound",
				"0",
				"£",
				"EGP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"El Salvador Colon",
				"0",
				"$",
				"SVC"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Estonia Kroon",
				"0",
				"kr",
				"EEK"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Euro Member Countries",
				"0",
				"€",
				"EUR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Falkland Islands (Malvinas) Pound",
				"0",
				"£",
				"FKP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Fiji Dollar",
				"0",
				"$",
				"FJD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Ghana Cedis",
				"0",
				"¢",
				"GHC"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Gibraltar Pound",
				"0",
				"£",
				"GIP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Guatemala Quetzal",
				"0",
				"Q",
				"GTQ"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Guernsey Pound",
				"0",
				"£",
				"GGP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Guyana Dollar",
				"0",
				"$",
				"GYD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Honduras Lempira",
				"0",
				"L",
				"HNL"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Hong Kong Dollar",
				"0",
				"$",
				"HKD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Hungary Forint",
				"0",
				"Ft",
				"HUF"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Iceland Krona",
				"0",
				"kr",
				"ISK"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"India Rupee",
				"0",
				"Rs",
				"INR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Indonesia Rupiah",
				"0",
				"Rp",
				"IDR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Iran Rial",
				"0",
				"﷼",
				"IRR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Isle of Man Pound",
				"0",
				"£",
				"IMP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Israel Shekel",
				"0",
				"₪",
				"ILS"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Jamaica Dollar",
				"0",
				"J$",
				"JMD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Japan Yen",
				"0",
				"¥",
				"JPY"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Jersey Pound",
				"0",
				"£",
				"JEP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Kazakhstan Tenge",
				"0",
				"лв",
				"KZT"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Kyrgyzstan Som",
				"0",
				"лв",
				"KGS"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Laos Kip",
				"0",
				"₭",
				"LAK"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Latvia Lat",
				"0",
				"Ls",
				"LVL"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Lebanon Pound",
				"0",
				"£",
				"LBP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Liberia Dollar",
				"0",
				"$",
				"LRD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Lithuania Litas",
				"0",
				"Lt",
				"LTL"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Macedonia Denar",
				"0",
				"ден",
				"MKD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Malaysia Ringgit",
				"0",
				"RM",
				"MYR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Mauritius Rupee",
				"0",
				"₨",
				"MUR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Mexico Peso",
				"0",
				"$",
				"MXN"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Mongolia Tughrik",
				"0",
				"₮",
				"MNT"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Mozambique Metical",
				"0",
				"MT",
				"MZN"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Namibia Dollar",
				"0",
				"$",
				"NAD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Nepal Rupee",
				"0",
				"₨",
				"NPR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Netherlands Antilles Guilder",
				"0",
				"ƒ",
				"ANG"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"New Zealand Dollar",
				"0",
				"$",
				"NZD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Nicaragua Cordoba",
				"0",
				"C$",
				"NIO"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Nigeria Naira",
				"0",
				"₦",
				"NGN"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Korea (North) Won",
				"0",
				"₩",
				"KPW"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Norway Krone",
				"0",
				"kr",
				"NOK"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Oman Rial",
				"0",
				"﷼",
				"OMR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Pakistan Rupee",
				"0",
				"₨",
				"PKR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Panama Balboa",
				"0",
				"B/.",
				"PAB"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Paraguay Guarani",
				"0",
				"Gs",
				"PYG"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Peru Nuevo Sol",
				"0",
				"S/.",
				"PEN"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Philippines Peso",
				"0",
				"₱",
				"PHP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Poland Zloty",
				"0",
				"zł",
				"PLN"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Qatar Riyal",
				"0",
				"﷼",
				"QAR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Romania New Leu",
				"0",
				"lei",
				"RON"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Russia Ruble",
				"0",
				"руб",
				"RUB"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Saint Helena Pound",
				"0",
				"£",
				"SHP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Saudi Arabia Riyal",
				"0",
				"﷼",
				"SAR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Serbia Dinar",
				"0",
				"Дин.",
				"RSD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Seychelles Rupee",
				"0",
				"₨",
				"SCR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Singapore Dollar",
				"0",
				"$",
				"SGD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Solomon Islands Dollar",
				"0",
				"$",
				"SBD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Somalia Shilling",
				"0",
				"S",
				"SOS"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"South Africa Rand",
				"0",
				"R",
				"ZAR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Korea (South) Won",
				"0",
				"₩",
				"KRW"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Sri Lanka Rupee",
				"0",
				"₨",
				"LKR"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Sweden Krona",
				"0",
				"kr",
				"SEK"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Switzerland Franc",
				"0",
				"CHF",
				"CHF"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Suriname Dollar",
				"0",
				"$",
				"SRD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Syria Pound",
				"0",
				"£",
				"SYP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Taiwan New Dollar",
				"0",
				"NT$",
				"TWD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Thailand Baht",
				"0",
				"฿",
				"THB"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Trinidad and Tobago Dollar",
				"0",
				"TT$",
				"TTD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Turkey Lira",
				"0",
				"₤",
				"TRL"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Tuvalu Dollar",
				"0",
				"$",
				"TVD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Ukraine Hryvna",
				"0",
				"₴",
				"UAH"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"United Kingdom Pound",
				"0",
				"£",
				"GBP"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"United States Dollar",
				"1",
				"$",
				"USD"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Uzbekistan Som",
				"0",
				"лв",
				"UZS"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Venezuela Bolivar",
				"0",
				"Bs",
				"VEF"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Viet Nam Dong",
				"0",
				"₫",
				"VND"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Yemen Rial",
				"0",
				"﷼",
				"YER"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
				"Zimbabwe Dollar",
				"0",
				"Z$",
				"ZWD"
			)
		);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . countriesTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . countriesTable() . '( 
		CountryId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		CountryName VARCHAR(100) NOT NULL,
		CountryUsed INTEGER(1) NOT NULL,
		CountryDefault INTEGER(1) NOT NULL,
		PRIMARY KEY (CountryId),
		KEY `idx_CountryName` (`CountryName`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
		
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Afganisthan",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
			"Akrotiri",
			"0",
			"0"
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Aland Islands",
				"0",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Albania",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Algeria",
				0,
				0
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"American Samoa",
				"0",
				"0"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Andorra",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Angola",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Anguilla",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Antarctica",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Antigua and Barbuda",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Argentina",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Armenia",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Aruba",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Ashmore and Cartier Islands",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Australia",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Austria",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
	  			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Azerbaijan",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bahamas, The",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bahamas",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bahrain",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bangladesh",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Barbados",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bassas da India",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Belarus",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Belgium",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Belize",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Benin",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bermuda",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bhutan",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bolivia",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bosnia and Herzegovina",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Botswana",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bouvet Island",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Brazil",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"British Indian Ocean territory",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"British Virgin Islands",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Brunei",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Bulgaria",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Burkina Faso",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Burma",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Burundi",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cambodia",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cameroon",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Canada",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cape Verde",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cayman Islands",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Central African Republic",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Chad",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Chile",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"China",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Christmas Island",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Clipperton Island",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cocos (Keeling) Islands",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Colombia",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Comoros",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Congo, Democratic Republic of the",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Congo, Republic of the",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Congo",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Democratic Republic",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cook Islands",
				"0",
				"0"		  
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Coral Sea Islands",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Costa Rica",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cote d'Ivoire",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Côte d Ivoire (Ivory Coast)",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Croatia (Hrvatska)",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cuba",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Cyprus",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Czech Republic",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Denmark",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Dhekelia",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Djibouti",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Dominica",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Dominican Republic",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"East Timor",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Ecuador",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Egypt",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"El Salvador",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Equatorial Guinea",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Eritrea",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Estonia",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Ethiopia",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
			"Europa Island",
			"0",
			"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Falkland Islands (Islas Malvinas)",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Faroe Islands",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Fiji",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Finland",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"France",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"French Guiana",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"French Polynesia",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"French Southern and Antarctic Lands",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"French Southern Territories",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Gabon",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Gambia, The",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Gaza Strip",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Gambia",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Georgia",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Germany",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Ghana",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Gibraltar",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Glorioso Islands",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Greece",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Greenland",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Grenada",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Guadeloupe",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Guam",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Guatemala",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Guernsey",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Guinea",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Guinea-Bissau",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Guyana",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Haiti",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Heard Island and McDonald Islands",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Holy See (Vatican City)",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Heard and McDonald Islands",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Honduras",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Hong Kong",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Hungary",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Iceland",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"India",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Indonesia",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Iran",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Iraq",
				"0",
				"0"	
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Ireland",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Isle of Man",
				"0",
				"0"			
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Israel",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Italy",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Jamaica",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Japan",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Jersey",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Jordan",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Juan de Nova Island",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Kazakhstan",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Kenya",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Kiribati",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Korea, North",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Korea, South",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Kuwait",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Kyrgyzstan",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Laos",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Lao Peoples Democratic Republic",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Latvia",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Lebanon",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Lesotho",
				"0",
				"0"		
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Liberia",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Libya",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Liechtenstein",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Lithuania",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Luxembourg",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Macau",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Macedonia",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Madagascar",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Malawi",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Malaysia",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Maldives",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Mali",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Malta",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Marshall Islands",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Martinique",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Mauritania",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Mauritius",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Mayotte",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Mexico",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Micronesia, Federated States of",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Micronesia",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Moldova",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Monaco",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Mongolia",
				"0",
				"0"	
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Montserrat",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Morocco",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Mozambique",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Myanmar",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Namibia",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Nauru",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Navassa Island",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Nepal",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Netherlands",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Netherlands Antilles",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"New Caledonia",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"New Zealand",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Nicaragua",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Niger",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Nigeria",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Niue",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Norfolk Island",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Northern Mariana Islands",
				"0",
				"0"			
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Norway",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Oman",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Pakistan",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Palau",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Palestinian Territories",
				"0",
				"0"			
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Panama",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Papua New Guinea",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Paracel Islands",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Paraguay",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Peru",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Philippines",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Pitcairn Islands",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Pitcairn",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Poland",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Portugal",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Puerto Rico",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Qatar",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Reunion",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Réunion",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Romania",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Russian Federation",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Rwanda",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Saint Helena",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Saint Kitts and Nevis",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Saint Lucia",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Saint Pierre and Miquelon",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Saint Vincent and the Grenadines",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Samoa",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"San Marino",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Sao Tome and Principe",
				"0",
				"0"			
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Saudi Arabia",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Senegal",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Serbia and Montenegro",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Seychelles",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Sierra Leone",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Singapore",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Slovakia",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Slovenia",
				"0",
				"0"			
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Solomon Islands",
				"0",
				"0"			
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Somalia",
				"0",
				"0"			
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"South Africa",
				"0",
				"0"			
			) 
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"South Georgia and the South Sandwich Islands",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Spain",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Spratly Islands",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Sri Lanka",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Sudan",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Suriname",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Svalbard and Jan Mayen Islands",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Swaziland",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Sweden",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Switzerland",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Syria",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Taiwan",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Tajikistan",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Tanzania",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Thailand",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Timor-Leste",
				"0",
				"0"			
			)
		);
	    $wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Togo",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Tokelau",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Tonga",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Trinidad and Tobago",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Tromelin Island",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Tunisia",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Turkey",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Turkmenistan",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Turks and Caicos Islands",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Tuvalu",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Uganda",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Ukraine",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"United Arab Emirates",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"United Kingdom",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"United States of America",
				"1",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Uruguay",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Uzbekistan",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Vanuatu",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Vatican City",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Venezuela",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Vietnam",
				"0",
				"0"		
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Virgin Islands (British)",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Virgin Islands (US)",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Wake Island",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Wallis and Futuna Islands",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"West Bank",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Western Sahara",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Yemen",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Zaire",
				"0",
				"0"			
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Zambia",
				"0",
				"0"			
				)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
				"Zimbabwe",
				"0",
				"0"			
			)
		);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . bookingFormTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . bookingFormTable() . '(
		BookingFormId INTEGER(10) UNSIGNED AUTO_INCREMENT,
		BookingFormField VARCHAR(100),
		status INT(1),
		required INT(1),
		type VARCHAR(50),
		validation VARCHAR(15),
		PRIMARY KEY (BookingFormId)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Email :",
				"1",
				"1",
				"textbox",
				"email"
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"First Name :",
				"1",
				"1",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Last Name :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Mobile :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Phone :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Skype Id :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Address Line 1 :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(	
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Address Line 2 :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"City :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Post Code :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Coupon Code :",
				"0",
				"0",
				"textbox",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Country :",
				"0",
				"0",
				"dropdown",
				""
			)
		);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
				"Notes :",
				"0",
				"0",
				"textarea",
				""
			)
		);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . email_templatesTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . email_templatesTable() . '(
		EmailId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		EmailContent text NOT NULL,
		EmailSubject VARCHAR(500) NOT NULL,
		EmailType VARCHAR(100) NOT NULL,
		PRIMARY KEY (EmailId),
		KEY `idx_EmailSubject` (`EmailSubject`),
		KEY `idx_EmailType` (`EmailType`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . multiple_bookingTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . multiple_bookingTable() . '(
		multipleId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		bookingId INTEGER(10) NOT NULL,
		bookingDate DATE NOT NULL,
		PRIMARY KEY (multipleId)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . block_outs() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . block_outs() . '( 
		RepeatId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		ServiceId INTEGER(10) UNSIGNED NOT NULL,
		Repeats INTEGER(2) NOT NULL,
		RepeatEvery INTEGER(100) NOT NULL,
		StartDate DATE NOT NULL,
		FullDayBlockOuts INTEGER(2) NOT NULL,
		StartTime INTEGER(50) NOT NULL,
		EndTime INTEGER(50) NOT NULL,
		EndDate DATE NULL,
		RepeatDays VARCHAR(100),
		PRIMARY KEY (RepeatId)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}	
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . coupons() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . coupons() . '( 
		couponId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		couponName VARCHAR(100) NOT NULL,
		couponValidFrom DATE NOT NULL,
		couponValidUpto DATE NOT NULL,
		 Amount DECIMAL(10,2) NOT NULL,
		amountType INTEGER(11) NOT NULL,
		couponApplicable INTEGER(5) NOT NULL,
		couponStatus INTEGER(2) NOT NULL,
		PRIMARY KEY (couponId)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . coupons_products() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . coupons_products() . '( 
		couponProductsId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		couponId INTEGER(10) NOT NULL,
		serviceId INTEGER(10) NOT NULL,
		PRIMARY KEY (couponProductsId)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . bookingsCountTable() . '"')) == 0)
	{
		$sql = 'CREATE TABLE ' . bookingsCountTable() . '( 
		bookingCountId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		ServiceId INTEGER(10) NOT NULL,
		BookingDate DATE NOT NULL,
		CountTotal INTEGER(10) NOT NULL,
		PRIMARY KEY (bookingCountId)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	$url = plugins_url('', __FILE__);
	$url1 = site_url();
		$wpdb->insert(email_templatesTable(), array('EmailType' => "booking-pending-confirmation", 'EmailContent' => "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /><title>Bookings Xpress</title></head><body leftmargin=\"0\" marginwidth=\"0\" topmargin=\"0\" marginheight=\"0\" offset=\"0\"><div style=\"background-color: #f5f5f5; width:100%; -webkit-text-size-adjust:none !important; margin:0; padding: 70px 0 70px 0;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\"><tr><td align=\"center\" valign=\"top\"><p style=\"margin-top:0;\"><img src=\"$url/gfx/logo.png\" alt=\"Bookings Xpress\" /></p><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" id=\"template_container\" style=\"-webkit-box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important; box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important; -webkit-border-radius:6px !important; border-radius:6px !important; background-color: #fdfdfd; border: 1px solid #dcdcdc; -webkit-border-radius:6px !important; border-radius:6px !important; \"><tr><td align=\"center\" valign=\"top\"><!-- Header --><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" id=\"template_header\" style=\"background-color: #4b9700;color: #ffffff; -webkit-border-top-left-radius:6px !important; -webkit-border-top-right-radius:6px !important; border-top-left-radius:6px !important; border-top-right-radius:6px !important; border-bottom: 0; font-family:Arial; font-weight:bold; line-height:100%; vertical-align:middle; \" bgcolor=\"#cd2122\"><tr>
		<td><h1 style=\"color: #ffffff; margin:0; padding: 28px 24px 0px 24px; text-shadow: 0 1px 0 #d74d4e; display:block; font-family:Arial; font-size:30px; font-weight:bold; text-align:left; line-height: 150%; \">Pending Confirmation</h1><h3 style=\"color: #ffffff; margin:0; padding: 8px 24px; text-shadow: 0 1px 0 #d74d4e; display:block; font-family:Arial; font-size:20px; font-weight:bold; text-align:left; line-height: 150%; \">Thank you for your booking request!</h3></td></tr></table><!-- End Header --></td></tr><tr><td align=\"center\" valign=\"top\"><!-- Body --><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" id=\"template_body\"><tr><td valign=\"top\" style=\" background-color: #fdfdfd;-webkit-border-radius:6px !important;border-radius:6px !important;\"><!-- Content --><table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\"><tr><td valign=\"top\"><div style=\"color: #737373; font-family:Arial; font-size:14px; line-height:150%; text-align:left;\"><p>As soon as your booking will be approved we will notify you by email.</p>
		<h2>Your Booking Details are as follows:</h2>
		<p><strong>For :</strong> [service_name]</p>
		<p><strong>[At :]</strong> [companyName]</p>
		<p><strong>On :</strong>[booked_date] [booked_time]</p>
		<p><strong>[Transaction Id:]</strong> [transaction_id]</p>
		<p><strong>[Payment Date:]</strong> [payment_date]</p>
		<p><strong>[Payment Status:] </strong>[payment_status]</p>
		 Best Regards,
		<p><strong>Support Team</strong></p></div></td></tr></table><!-- End Content --></td></tr></table><!-- End Body --></td></tr><tr><td align=\"center\" valign=\"top\"><!-- Footer --><table border=\"0\" cellpadding=\"10\" cellspacing=\"0\" width=\"600\" id=\"template_footer\" style=\"border-top:0;-webkit-border-radius:6px;\"><tr><td valign=\"top\"><table border=\"0\" cellpadding=\"10\" cellspacing=\"0\" width=\"100%\"><tr><td colspan=\"2\" valign=\"middle\" id=\"credit\" style=\"border:0;color: #4b9700;font-family: Arial;font-size:12px;line-height:125%;text-align:center;\"><p>Bookings Xpress &#8211; The Ultimate Appointments/Bookings Software</p></td></tr></table></td></tr></table><!-- End Footer --></td></tr></table></td></tr></table></div></body></html>",
		'EmailSubject' => "Your Booking is Pending Approval"));
	$wpdb->insert(email_templatesTable(), array('EmailType' => "booking-confirmation", 'EmailContent' => "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<div style=\"background-color: #f5f5f5; width: 100%; -webkit-text-size-adjust: none !important; margin: 0; padding: 70px 0 70px 0;\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td align=\"center\" valign=\"top\">
<p style=\"margin-top: 0;\"><img alt=\"Bookings Xpress\" src=\"$url/gfx/logo.png\" /></p>
<table id=\"template_container\" style=\"-webkit-box-shadow: 0 0 0 3px rgba(0,0,0,0.025) !important; box-shadow: 0 0 0 3px rgba(0,0,0,0.025) !important; -webkit-border-radius: 6px !important; border-radius: 6px !important; background-color: #fdfdfd; border: 1px solid #dcdcdc;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td align=\"center\" valign=\"top\"><!-- Header -->
<table id=\"template_header\" style=\"background-color: #4b9700; color: #ffffff; -webkit-border-top-left-radius: 6px !important; -webkit-border-top-right-radius: 6px !important; border-top-left-radius: 6px !important; border-top-right-radius: 6px !important; border-bottom: 0; font-family: Arial; font-weight: bold; line-height: 100%; vertical-align: middle;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#4b9700\">
<tbody>
<tr>
<td>
<h1 style=\"color: #ffffff; margin: 0; padding: 28px 24px 0px 24px; text-shadow: 0 1px 0 #d74d4e; display: block; font-family: Arial; font-size: 30px; font-weight: bold; text-align: left; line-height: 150%;\">Booking has been Confirmed!</h1>
<!-- <h3 style=\"color: #ffffff; margin: 0; padding: 8px 24px; text-shadow: 0 1px 0 #d74d4e; display: block; font-family: Arial; font-size: 20px; font-weight: bold; text-align: left; line-height: 150%;\">Thank you for your booking request!</h3> -->
</td>
</tr>
</tbody>
</table>
<!-- End Header --></td>
</tr>
<tr>
<td align=\"center\" valign=\"top\"><!-- Body -->
<table id=\"template_body\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td style=\"background-color: #fdfdfd; -webkit-border-radius: 6px !important; border-radius: 6px !important;\" valign=\"top\"><!-- Content -->
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"20\">
<tbody>
<tr>
<td valign=\"top\">
<div style=\"color: #737373; font-family: Arial; font-size: 14px; line-height: 150%; text-align: left;\">
Hi [client_name],
<p>Your Booking for [service_name] on [booked_date] [at] [booked_time] is now CONFIRMED!</p>
<p>I look forward to seeing you, please ensure to be 5 minutes early for your appointment.</p>
<p><span style=\"color: red;\">**Cancellation Policy: Booking must be cancelled at least 48 hours prior to your appointment.</span></p>
<p><strong>[Transaction Id:]</strong> [transaction_id]</p>
<p><strong>[Payment Date:]</strong> [payment_date]</p>
<p><strong>[Payment Status:] </strong>[payment_status]</p>
Best Regards,
<p><strong>Support Team</strong></p>
</div></td>
</tr>
</tbody>
</table>
<!-- End Content --></td>
</tr>
</tbody>
</table>
<!-- End Body --></td>
</tr>
<tr>
<td align=\"center\" valign=\"top\"><!-- Footer -->
<table id=\"template_footer\" style=\"border-top: 0; -webkit-border-radius: 6px;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
<tbody>
<tr>
<td valign=\"top\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
<tbody>
<tr>
<td id=\"credit\" style=\"border: 0; color: #4b9700; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;\" colspan=\"2\" valign=\"middle\">Bookings Xpress – The Ultimate Appointments/Bookings Software</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!-- End Footer --></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
&nbsp;
&nbsp;", 'EmailSubject' => "Your Booking has been Confirmed"));
	$wpdb->insert(email_templatesTable(), array('EmailType' => "admin-control", 'EmailContent' => "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<div style=\"background-color: #f5f5f5; width: 100%; -webkit-text-size-adjust: none !important; margin: 0; padding: 70px 0 70px 0;\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td align=\"center\" valign=\"top\">
<p style=\"margin-top: 0;\"><img alt=\"Bookings Xpress\" src=\"$url/gfx/logo.png\" /></p>
<table id=\"template_container\" style=\"-webkit-box-shadow: 0 0 0 3px rgba(0,0,0,0.025) !important; box-shadow: 0 0 0 3px rgba(0,0,0,0.025) !important; -webkit-border-radius: 6px !important; border-radius: 6px !important; background-color: #fdfdfd; border: 1px solid #dcdcdc;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td align=\"center\" valign=\"top\"><!-- Header -->
<table id=\"template_header\" style=\"background-color: #4b9700; color: #ffffff; -webkit-border-top-left-radius: 6px !important; -webkit-border-top-right-radius: 6px !important; border-top-left-radius: 6px !important; border-top-right-radius: 6px !important; border-bottom: 0; font-family: Arial; font-weight: bold; line-height: 100%; vertical-align: middle;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#cd2122\">
<tbody>
<tr>
<td>
<h1 style=\"color: #ffffff; margin: 0; padding: 28px 24px 0px 24px; text-shadow: 0 1px 0 #d74d4e; display: block; font-family: Arial; font-size: 30px; font-weight: bold; text-align: left; line-height: 150%;\">A New Booking has been made</h1>
<!-- <h3 style=\"color: #ffffff; margin: 0; padding: 8px 24px; text-shadow: 0 1px 0 #d74d4e; display: block; font-family: Arial; font-size: 20px; font-weight: bold; text-align: left; line-height: 150%;\">Thank you for your booking request!</h3> -->
</td>
</tr>
</tbody>
</table>
<!-- End Header --></td>
</tr>
<tr>
<td align=\"center\" valign=\"top\"><!-- Body -->
<table id=\"template_body\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td style=\"background-color: #fdfdfd; -webkit-border-radius: 6px !important; border-radius: 6px !important;\" valign=\"top\"><!-- Content -->
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"20\">
<tbody>
<tr>
<td valign=\"top\">
<div style=\"color: #737373; font-family: Arial; font-size: 14px; line-height: 150%; text-align: left;\">
Dear Admin,
<p>A new booking request was made by [client_name] for [service_name] on the [booked_date] [at] [booked_time] .</p>
<p>The Contact Details are as follows:</p>
<p><strong>Email: </strong>[email_address]</p>
<p><strong>Mobile:</strong>[mobile_number]</p>
<p>You now need to [approve] or [deny] the booking via these links.</p>
Best Regards,
<p><strong>Support Team</strong></p>
</div></td>
</tr>
</tbody>
</table>
<!-- End Content --></td>
</tr>
</tbody>
</table>
<!-- End Body --></td>
</tr>
<tr>
<td align=\"center\" valign=\"top\"><!-- Footer -->
<table id=\"template_footer\" style=\"border-top: 0; -webkit-border-radius: 6px;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
<tbody>
<tr>
<td valign=\"top\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
<tbody>
<tr>
<td id=\"credit\" style=\"border: 0; color: #4b9700; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;\" colspan=\"2\" valign=\"middle\">Bookings Xpress – The Ultimate Appointments/Bookings Software</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!-- End Footer --></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
&nbsp;
&nbsp;", 'EmailSubject' => "Hi Admin - A New Booking was made"));	
	$wpdb->insert(email_templatesTable(), array('EmailType' => "booking-disapproved", 'EmailContent' => "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<div style=\"background-color: #f5f5f5; width: 100%; -webkit-text-size-adjust: none !important; margin: 0; padding: 70px 0 70px 0;\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td align=\"center\" valign=\"top\">
<p style=\"margin-top: 0;\"><img alt=\"Bookings Xpress\" src=\"$url/gfx/logo.png\" /></p>
<table id=\"template_container\" style=\"-webkit-box-shadow: 0 0 0 3px rgba(0,0,0,0.025) !important; box-shadow: 0 0 0 3px rgba(0,0,0,0.025) !important; -webkit-border-radius: 6px !important; border-radius: 6px !important; background-color: #fdfdfd; border: 1px solid #dcdcdc;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td align=\"center\" valign=\"top\"><!-- Header -->
<table id=\"template_header\" style=\"background-color: #4b9700; color: #ffffff; -webkit-border-top-left-radius: 6px !important; -webkit-border-top-right-radius: 6px !important; border-top-left-radius: 6px !important; border-top-right-radius: 6px !important; border-bottom: 0; font-family: Arial; font-weight: bold; line-height: 100%; vertical-align: middle;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#cd2122\">
<tbody>
<tr>
<td>
<h1 style=\"color: #ffffff; margin: 0; padding: 28px 24px 0px 24px; text-shadow: 0 1px 0 #d74d4e; display: block; font-family: Arial; font-size: 30px; font-weight: bold; text-align: left; line-height: 150%;\">Booking Disapproved</h1>
<!-- <h3 style=\"color: #ffffff; margin: 0; padding: 8px 24px; text-shadow: 0 1px 0 #d74d4e; display: block; font-family: Arial; font-size: 20px; font-weight: bold; text-align: left; line-height: 150%;\">Thank you for your booking request!</h3> -->
</td>
</tr>
</tbody>
</table>
<!-- End Header --></td>
</tr>
<tr>
<td align=\"center\" valign=\"top\"><!-- Body -->
<table id=\"template_body\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td style=\"background-color: #fdfdfd; -webkit-border-radius: 6px !important; border-radius: 6px !important;\" valign=\"top\"><!-- Content -->
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"20\">
<tbody>
<tr>
<td valign=\"top\">
<div style=\"color: #737373; font-family: Arial; font-size: 14px; line-height: 150%; text-align: left;\">
Hi [first name],
<p>Sorry but your appointment for [service] on [date] of [at] [time] is unfortunately unavailable.</p>
<p>You are receiving this email because the Administrator has just decline your appointment which can be for a verity of different reasons that has to do with availability on that specific time or service.</p>
<p>We recommend that you either try to book for another time or date or alternatively contact us for further information.</p>
<p><strong>[Transaction Id:]</strong> [transaction_id]</p>
<p><strong>[Payment Date:]</strong> [payment_date]</p>
<p><strong>[Payment Status:] </strong>[payment_status]</p>
<p>Thank you for your understanding and we look forward seeing soon.</p>
Best Regards,
<p><strong>Support Team</strong></p>
</div></td>
</tr>
</tbody>
</table>
<!-- End Content --></td>
</tr>
</tbody>
</table>
<!-- End Body --></td>
</tr>
<tr>
<td align=\"center\" valign=\"top\"><!-- Footer -->
<table id=\"template_footer\" style=\"border-top: 0; -webkit-border-radius: 6px;\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
<tbody>
<tr>
<td valign=\"top\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
<tbody>
<tr>
<td id=\"credit\" style=\"border: 0; color: #4b9700; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;\" colspan=\"2\" valign=\"middle\">Bookings Xpress – The Ultimate Appointments/Bookings Software</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!-- End Footer --></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
&nbsp;
&nbsp;", 'EmailSubject' => "You Booking has been disapproved."));
?>