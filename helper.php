<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_muslimprayertime
 * @copyright	Copyright (C) 2013 SyahrilZulkefli. All rights reserved.
 * @license		GNU General Public License version 3
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');

class modMuslimPrayerTime {
    
    public static function getZones()
    {
        $cacheFile = JPATH_ROOT.'/cache/mod_muslimprayertimes_zones.json';

        // check if the cache file exists
        if (JFile::exists($cacheFile))
        {
            $zones = JFile::read($cacheFile);
        }
        else
        {
            $url = "https://api.scraperwiki.com/api/1.0/datastore/sqlite?format=jsondict&name=esolat&query=select+%2A+from+%60zone%60+order+by+%60Zone%60+asc";
            $ch = curl_init();
            $timeout = 10;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PORT , 443); 
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $zones = curl_exec($ch);
            curl_close($ch);

            // write to cache
            modMuslimPrayerTime::writeCache($cacheFile, $zones);
        }
        
        return json_decode($zones, TRUE);
    }
    
    public static function getZoneInfo($selZone)
    {
        $zones = modMuslimPrayerTime::getZones();

        foreach ($zones as $zone)
        {
            if ($zone['Zone'] === strtoupper($selZone))
            {
                $out = array(
                    'Zone' => $zone['Zone'],
                    'Negeri' => $zone['Negeri'],
                    'Lokasi' => $zone['Lokasi']
                );
                return $out;
            }
        }
    }


    public static function getPrayerTimes($zone, $date)
    {
        $url       = "https://api.scraperwiki.com/api/1.0/datastore/sqlite?format=jsondict&name=esolat&query=select+%2A+from+%60solat%60+where+%60Zone%60+%3D+%27".$zone."%27+and+%60Tarikh%60+%3D+%27".$date."%27+limit+1";
        $cacheFile = JPATH_ROOT.'/cache/mod_muslimprayertimes_'.$zone.'_'.$date.'.json';
        
        // check if the cache file exists
        if (JFile::exists($cacheFile))
        {
            $prayerTimes = json_decode(JFile::read($cacheFile), TRUE);
        }
        else
        {
            $prayerTimes = modMuslimPrayerTime::getData($url, $zone, $date);
        }
        return $prayerTimes;
    }
    
    /* gets the data from a URL */
    private static function getData($url, $zone, $date) 
    {
        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PORT , 443); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        
        // write to cache
        $cacheFile = JPATH_ROOT.'/cache/mod_muslimprayertimes_'.$zone.'_'.$date.'.json';
        modMuslimPrayerTime::writeCache($cacheFile, $data);
        return json_decode($data, TRUE);
    }
    
    private static function writeCache($file, $buffer)
    {
        // check if the cache file not exists
        if ( ! JFile::exists($file))
        {
            if ( ! JFile::write($file, $buffer))
            {
                // return some error message
            }
        }
    }
    
    public static function getHijiriDate()
	{
		// get today date
		$theDate	= getdate();
		
		$wday		= $theDate['wday'];
		$hr			= $theDate['mday'];
		$theMonth	= (int) $theDate['mon'];
		$theYear	= (int) $theDate['year'];

		if (($theYear > 1582) || (($theYear == 1582) && ($theMonth > 10)) || (($theYear == 1582) && ($theMonth == 10) && ($hr > 14))) 
		{
			$zjd = (int)((1461 * ($theYear + 4800 + (int)(($theMonth - 14) / 12))) / 4) + (int)((367 * ($theMonth - 2 - 12 * ((int)(($theMonth - 14) / 12)))) / 12) - (int)((3 * (int)((($theYear + 4900 + (int)(($theMonth - 14) / 12)) / 100))) / 4) + $hr - 32075;
		} 
		else 
		{
			$zjd = 367 * $theYear - (int)((7 * ($theYear + 5001 + (int)(($theMonth - 9) / 7))) / 4) + (int)((275 * $theMonth) / 9) + $hr + 1729777;
		}

		$zl			= $zjd - 1948440 + 10632;
		$zn			= (int)(($zl-1)/10631);
		$zl			= $zl - 10631 * $zn + 354;
		$zj			= ((int)((10985 - $zl)/5316))*((int)((50 * $zl)/17719))+((int)($zl/5670))*((int)((43 * $zl)/15238));
		$zl			= $zl-((int)((30 - $zj)/15))*((int)((17719 * $zj)/50))-((int)($zj/16))*((int)((15238 * $zj)/43))+29;
		$theMonth	= (int)((24 * $zl)/709);
		$hijriDay	= $zl-(int)((709 * $theMonth)/24);
		$hijriYear	= 30 * $zn + $zj - 30;
		
		
		$hijriMonthName = 'MOD_MUSLIMPRAYERTIME_MONTH_'.$theMonth;
		$hijriDayString = 'MOD_MUSLIMPRAYERTIME_DAY_'.$wday;
		

		$hijiri = array(
			'dayName'	=> JText::_($hijriDayString),
			'day'		=> $hijriDay,
			'month'		=> JText::_($hijriMonthName),
			'year'		=> $hijriYear
		);
		
		return $hijiri;
	}
}