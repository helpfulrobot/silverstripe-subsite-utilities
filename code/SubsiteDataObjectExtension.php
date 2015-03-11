<?php
/**
 * Allowing subsite specific dataobjects
 * See https://github.com/silverstripe/silverstripe-subsites#enable-subsite-support-on-dataobjects
 * 
 * TODO consider if it would make more sense to use this module instead:
 * https://github.com/adrexia/silverstripe-subsite-modeladmins/blob/master/SubsiteModelExtension.php
 * 
 */
class SubsiteDataObjectExtension extends DataExtension {

	private static $has_one = array(
		'Subsite' => 'Subsite'
	);	

	function updateCMSFields(FieldList $fields) {
		if(class_exists('Subsite')){
			$fields->push(new HiddenField('SubsiteID','SubsiteID', Subsite::currentSubsiteID()));
		}
		return $fields;
		}

	
}