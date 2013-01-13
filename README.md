# MageBehat

Behat Integration for Magento + Magento Extensions

## Installation
1. [Install composer](http://getcomposer.org/doc/01-basic-usage.md#installation)
2. Install all dependencies: `composer install`

		curl http://getcomposer.org/installer | php
		php composer.phar install

3. [Download Selenium2](http://seleniumhq.org/download/)

## Documentation for Extension Developers
As an extension developer you are able to place your feature descriptions in your extension directory's Test/features folder.

Example:
Hackathon_MageBehatTest1/Test/features/homepage.feature

Place a behat context file in your extension directory Test/FeatureContext.php to use an extra context (sub context), which is used only for your extension.

Example:
Hackathon_MageBehatTest1/Test/FeatureContext.php

## Implemented Features
- Magento Frontend
	- Cart 	
	- Checkout 

## Usage
1. Start Selenium2 
		
		java -jar selenium-server-standalone.jar

2. Run Features from Magento root folder

		php -f shell/behat.php

## Ideas