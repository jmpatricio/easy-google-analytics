<?php

namespace Jmpatricio\EasyGoogleAnalytics;

use Carbon\Carbon;
use Google_Auth_AssertionCredentials;
use Google_Client;
use Google_Service_Analytics;


/**
 * Class Connector
 *
 * @since 1.0
 */
class Connector
{

    /**
     * @var \Google_Service_Analytics
     */
    protected $analytics;

    /**
     * Get a package configuration value
     *
     * @param string $key The config key
     *
     * @return mixed The config value
     * @since 1.0
     */
    protected function getConfig($key)
    {
        return \Config::get(EasyGoogleAnalyticsServiceProvider::PKG_NAME . '::' . $key);
    }

    /**
     * Construct the client and analytics object
     */
    public function __construct()
    {

        $clientId = $this->getConfig('client_id');
        $serviceAccountName = $this->getConfig('service_account_name');
        $keyFile = $this->getConfig('keyfile');
        $this->analyticsIds = $this->getConfig('analytics_id');

        $client = new Google_Client();
        $credentials = new Google_Auth_AssertionCredentials(
            $serviceAccountName,
            ['https://www.googleapis.com/auth/analytics'],
            file_get_contents($keyFile)
        );

        $client->setAssertionCredentials($credentials);

        $client->setClientId($clientId);

        $this->analytics = new Google_Service_Analytics($client);
    }

    /**
     * Get the active users
     *
     * @return int|null The number of active user by real time api
     *
     * @since 1.0
     *
     */
    public function getActiveUsers()
    {
        $results = $this->analytics->data_realtime->get($this->analyticsIds, 'rt:activeUsers');

        return (isset($results['totalsForAllResults']['rt:activeUsers']))
            ? (int)$results['totalsForAllResults']['rt:activeUsers']
            : null;
    }

    /**
     * Get the total visit in time. Default is the current day
     *
     * @param \Carbon\Carbon|null $fromDate The carbon object to from limit
     * @param \Carbon\Carbon|null $toDate   The carbon object to to limit
     *
     * @return int|null The total visits or null
     * @since 1.0
     */
    public function getTotalVisits(Carbon $fromDate = null, Carbon $toDate = null)
    {
        $fromDate = $this->getFromDateDefault($fromDate);

        $toDate = $this->getToDefaultDate($toDate);

        $results = $this->analytics->data_ga->get($this->analyticsIds, $fromDate->format('Y-m-d'),
            $toDate->format('Y-m-d'),
            'ga:visits');

        return (isset($results['totalsForAllResults']['ga:visits']))
            ? (int)$results['totalsForAllResults']['ga:visits']
            : null;
    }


    /**
     * Make a google analytics api request. Default is today
     *
     * @param \Carbon\Carbon|null $fromDate The carbon object to from limit
     * @param \Carbon\Carbon|null $toDate   The carbon object to to limit
     * @param null                $metrics  Requested metrics
     * @param array               $options  The metric options, like dimensions, sorting, filters
     *
     * @return \Google_Service_Analytics_GaData|null
     * @since 1.0
     */
    public function getGA(Carbon $fromDate = null, Carbon $toDate = null, $metrics = null, $options = [])
    {
        if (!$metrics) {
            return null;
        }

        if (!$fromDate) {
            $fromDate = new Carbon('today');
        }

        if (!$toDate) {
            $toDate = new Carbon('today');
            $toDate->hour(23)->minute(59)->second(59);
        }

        return $this->analytics->data_ga->get($this->analyticsIds, $fromDate->format('Y-m-d'), $toDate->format('Y-m-d'),
            $metrics, $options);
    }

    /**
     * Make a realtime api request
     *
     * @param string $metrics Requested metrics
     * @param array  $options The metric options, like dimensions, sorting, filters
     *
     * @return \Google_Service_Analytics_RealtimeData
     * @since
     */
    public function getRT($metrics, $options = [])
    {
        return $this->analytics->data_realtime->get($this->analyticsIds, $metrics, $options);
    }

    /**
     * Make a MFC api request
     *
     * @param \Carbon\Carbon|null $fromDate The carbon object to from limit
     * @param \Carbon\Carbon|null $toDate   The carbon object to to limit
     * @param null                $metrics  Requested metrics
     * @param array               $options  The metric options, like dimensions, sorting, filters
     *
     * @return \Google_Service_Analytics_GaData|null
     * @since 1.0
     */
    public function getMCF(Carbon $fromDate = null, Carbon $toDate = null, $metrics = null, $options = [])
    {
        if (!$metrics) {
            return null;
        }

        $fromDate = $this->getFromDateDefault($fromDate);
        $toDate = $this->getToDefaultDate($toDate);

        return $this->analytics->data_ga->get($this->analyticsIds, $fromDate->format('Y-m-d'), $toDate->format('Y-m-d'),
            $metrics, $options);
    }

    /**
     * Get the default from date
     * @param \Carbon\Carbon $fromDate The date
     *
     * @return \Carbon\Carbon
     * @since 1.0
     */
    protected function getFromDateDefault(Carbon $fromDate = null)
    {
        if (!$fromDate) {
            $fromDate = new Carbon('today');

            return $fromDate;
        }

        return $fromDate;
    }

    /**
     * Get the default to date
     * @param \Carbon\Carbon $toDate The date
     *
     * @return \Carbon\Carbon
     * @since 1.0
     */
    protected function getToDefaultDate(Carbon $toDate = null)
    {
        if (!$toDate) {
            $toDate = new Carbon('today');
            $toDate->hour(23)->minute(59)->second(59);

            return $toDate;
        }

        return $toDate;
    }


}