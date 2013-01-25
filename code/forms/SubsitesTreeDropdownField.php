<?php
/**
 * Wraps around a TreedropdownField to add ability for temporary
 * switching of subsite sessions.
 * 
 * @package subsites
 */
class SubsitesTreeDropdownField extends TreeDropdownField {
	
	protected $subsiteID = 0;
	
	protected $extraClasses = array('SubsitesTreeDropdownField');
	
	function Field($properties = array()) {
		$html = parent::Field($properties);
		
		Requirements::javascript('subsites/javascript/SubsitesTreeDropdownField.js');
		
		return $html;
	}
	
	function setSubsiteID($id) {
		$this->subsiteID = $id;
	}
	
	function getSubsiteID() {
		return $this->subsiteID;
	}
	
	function tree(SS_HTTPRequest $request) {
		$oldSubsiteID = Subsite::currentSubsite();

		Subsite::changeSubsite($this->subsiteID);
		$results = parent::tree($request);
		Subsite::changeSubsite($oldSubsiteID);
		
		return $results;
	}
}