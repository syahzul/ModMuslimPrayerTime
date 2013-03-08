<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_muslimprayertime
 * @copyright	Copyright (C) 2013 Syahril Zulkefli. All rights reserved.
 * @license		GNU General Public License version 3
 */

// no direct access
defined('_JEXEC') or die;

if ($params->get('use_css')) 
{
    $document = JFactory::getDocument();
    $document->addStyleSheet(JURI::root(TRUE).'/modules/mod_muslimprayertime/assets/css/mod_muslimprayertime.css');
}
?>
<div class="mod_muslimprayertime">
    <?php if ($params->get('show_zoneinfo')) : ?>
    <p class="zoneinfo-state"><?php echo $zoneInfo['Negeri']; ?></p>
    <p class="zoneinfo-location"><?php echo $zoneInfo['Lokasi']; ?></p>
    <?php endif; ?>
    
    <?php if ($params->get('show_hijiri_date')) : ?>
	<p class="hijiri-date">
		<?php echo $calendar['day'].' '.$calendar['month'].' '.$calendar['year']; ?>
	</p>
	<?php endif; ?>
    
	<dl class="prayer-times">
		<?php if ($params->get('show_imsak')) : ?>
		<dt><?php echo JText::_('MOD_MUSLIMPRAYERTIME_LAYOUT_IMSAK'); ?></dt>
		<dd>
			<?php 
			$time = date('g:i a', strtotime($solat[0]['Imsak']));
			echo $time;
			?>
		</dd>
		<?php endif; ?>

		<?php if ($params->get('show_subuh')) : ?>
		<dt><?php echo JText::_('MOD_MUSLIMPRAYERTIME_LAYOUT_SUBUH'); ?></dt>
		<dd>
			<?php 
			$time = date('g:i a', strtotime($solat[0]['Subuh']));
			echo $time;
			?>
		</dd>
		<?php endif; ?>

		<?php if ($params->get('show_syuruk')) : ?>
		<dt><?php echo JText::_('MOD_MUSLIMPRAYERTIME_LAYOUT_SYURUK'); ?></dt>
		<dd>
			<?php 
			$time = date('g:i a', strtotime($solat[0]['Syuruk']));
			echo $time;
			?>
		</dd>
		<?php endif; ?>

		<?php if ($params->get('show_zuhur')) : ?>
		<dt><?php echo JText::_('MOD_MUSLIMPRAYERTIME_LAYOUT_ZUHUR'); ?></dt>
		<dd>
			<?php 
			$time = date('g:i a', strtotime($solat[0]['Zohor']));
			echo $time;
			?>
		</dd>
		<?php endif; ?>

		<?php if ($params->get('show_asar')) : ?>
		<dt><?php echo JText::_('MOD_MUSLIMPRAYERTIME_LAYOUT_ASAR'); ?></dt>
		<dd>
			<?php 
			$time = date('g:i a', strtotime($solat[0]['Asar']));
			echo $time;
			?>
		</dd>
		<?php endif; ?>

		<?php if ($params->get('show_maghrib')) : ?>
		<dt><?php echo JText::_('MOD_MUSLIMPRAYERTIME_LAYOUT_MAGHRIB'); ?></dt>
		<dd>
			<?php 
			$time = date('g:i a', strtotime($solat[0]['Maghrib']));
			echo $time;
			?>
		</dd>
		<?php endif; ?>

		<?php if ($params->get('show_isyak')) : ?>
		<dt><?php echo JText::_('MOD_MUSLIMPRAYERTIME_LAYOUT_ISYAK'); ?></dt>
		<dd>
			<?php 
			$time = date('g:i a', strtotime($solat[0]['Isyak']));
			echo $time;
			?>
		</dd>
		<?php endif; ?>
	</dl>
    <div style="clear: both;"></div>
	
</div>