<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_muslimprayertime
 * @copyright	Copyright (C) 2013 Syahril Zulkefli. All rights reserved.
 * @license		GNU General Public License version 3
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

// get zone from module parameter
$zone     = $params->get('zone');

// get the zone full information; Zone, Lokasi, Negeri
$zoneInfo = modMuslimPrayerTime::getZoneInfo($zone);

// get current date
$date     = date('Y-m-d');

// now get the prayer times
$solat    = modMuslimPrayerTime::getPrayerTimes($zone, $date);

// get hijiri calendar
$calendar = modMuslimPrayerTime::getHijiriDate();

// get the module class suffix
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// load the layout
require JModuleHelper::getLayoutPath('mod_muslimprayertime', $params->get('layout', 'default'));

