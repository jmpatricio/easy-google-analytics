# Easy Google Analytics
Laravel Package to connect Google Analytics
---
[![Latest Stable Version](https://poser.pugx.org/jmpatricio/easy-google-analytics/v/stable)](https://packagist.org/packages/jmpatricio/easy-google-analytics)
[![Codacy Badge](https://www.codacy.com/project/badge/6040a34eaf90464bb64920edee3a53dd)](https://www.codacy.com/app/jmpatricio/easy-google-analytics)
[![Code Climate](https://codeclimate.com/github/jmpatricio/easy-google-analytics/badges/gpa.svg)](https://codeclimate.com/github/jmpatricio/easy-google-analytics)
[![License](https://poser.pugx.org/jmpatricio/easy-google-analytics/license)](https://packagist.org/packages/jmpatricio/easy-google-analytics)

## Changelog

* 1.0.4 | 2015-08-21
 * Added new users metric
 * Duplicate code removed
 * PHP Docs improved
 * Code Style fixed

## Instalation

1. Run `composer require jmpatricio/easy-google-analytics`

2. Add `Jmpatricio\EasyGoogleAnalytics\EasyGoogleAnalyticsServiceProvider` to your service providers 

3. Instalation Done.

## Configuration

This step is the most important. Let's make it simple:

* Open a terminal and run: `php artisan config:publish "jmpatricio/easy-google-analytics"`.
* Now you have `{$projectRoot}/app/config/packages/jmpatricio/easy-google-analytics/config.php` file with:

```php
return [
    'client_id'            => 'xxx.apps.googleusercontent.com',
    'service_account_name' => 'xxx@developer.gserviceaccount.com',
    'keyfile'              => storage_path('xxx.p12'),
    'analytics_id'         => 'ga:xxx',
];
```	

* Now you have to go to your googe developer account and configure a new project. (If you already have a project, ignore this step)
![Create a new project](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/configure_project.png)

* You need to enable the Analytics API to your project. Inside project, go to APIs & auth and then inside APIs. Enable the analytics

* Inside the project, on developers console, go to Credentials inside APIs & auth, create a new Service Account
![](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/add_service_account_001.png)

* Choose a p12 key
![](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/add_service_account_002.png)

* Save your p12 key inside `{$projectRoot}/app/storage`. 

![](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/add_service_account_003.png)

* Edit the config file and define the keyfile entry: `'keyfile'              => storage_path('Easy-Google-Analytics-da31194a03c6.p12'),`

* Now you have the information about the credentials
![](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/client_data_001.png)
Click on the email, and the following screen shows up:
![](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/client_data_002.png)

* Add the client id and the email address to the config:
```php
return [
	'client_id'            => '459875649264-vs034lhn7ocddcch0nq1vdurst1mr8bu.apps.googleusercontent.com',
	'service_account_name' => '459875649264-vs034lhn7ocddcch0nq1vdurst1mr8bu@developer.gserviceaccount.com',
	'keyfile'              => storage_path('Easy-Google-Analytics-da31194a03c6.p12'),
	'analytics_id'         => 'ga:xxx',
];
```

* Now the only thing missing is the analytics id
 * Go to your analytics dashboard, and inside the admin area select the view settings:
 ![](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/admin_analytics_001.png)
 * Copy the view id and add to the config:
 ![](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/admin_analytics_002.png)
 
 The config will be the following:

```php 
return [
    'client_id'            => '459875649264-vs034lhn7ocddcch0nq1vdurst1mr8bu.apps.googleusercontent.com',
    'service_account_name' => '459875649264-vs034lhn7ocddcch0nq1vdurst1mr8bu@developer.gserviceaccount.com',
    'keyfile'              => storage_path('Easy-Google-Analytics-da31194a03c6.p12'),
    'analytics_id'         => 'ga:106917230',
];
```
 
 * Now we have to add permissions to the service account inside analytics console:
  * Go to the analytics admin console, and add the user with the respective permissions:
  ![](https://raw.githubusercontent.com/jmpatricio/easy-google-analytics-files/master/service_account_permissions_001.png)	
	
* The configuration is complete!

## Basic usage


```php
$connector = new Jmpatricio\EasyGoogleAnalytics\Connector();

// Total visits for today
$totalVisitors = $connector->getTotalVisits();

// Total visits with from-to dates
$totalVisitors = $connector->getTotalVisits(new Carbon\Carbon('2015-08-01'), new Carbon\Carbon('2015-08-05'));

// Active users
$activeUsers = $connector->getActiveUsers();

// Generic API Access

// GA API
$fromDate = new Carbon\Carbon('2015-08-01');
$toDate = new Carbon\Carbon('2015-08-05');
$serviceResponse = $connector->getGA($fromDate,$toDate,'ga:visitors')

// Realtime API
$serviceResponse = $connector->getRT('rt:activeUsers',['dimensions'=>'rt:country']);
```
		
		
