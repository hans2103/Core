<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Block_System_Config_Form extends Mage_Adminhtml_Block_System_Config_Form {

	protected function _afterToHtml($html) {
		$html = parent::_afterToHtml($html);

		return $html;
	}

}
