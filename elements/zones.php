<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_muslimprayertime
 * @copyright	Copyright (C) 2013 Syahril Zulkefli. All rights reserved.
 * @license		GNU General Public License version 3
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(dirname(__FILE__)).'/helper.php';

class JFormFieldZones extends JFormField {
    
    protected $type = 'Zones';
    
    public function getInput()
    {
        $zones = modMuslimPrayerTime::getZones();

        $options = array();
        $count = 0;
        foreach ($zones as $zone)
        {
            $options[$count]['key']  = $zone['Zone'];
            $options[$count]['text'] = $zone['Negeri'].' - '.$zone['Lokasi'];
            $count++;
        }
        
        return JHtml::_('select.genericlist', $options, $this->name, '', 'key', 'text', $this->value, $this->id);
    }
    
}