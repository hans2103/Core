<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Block_System_Config_Form_Fieldset_Extensions extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {

	protected $_dummyElement;
	protected $_fieldRenderer;
	protected $_values;

	public function render(Varien_Data_Form_Element_Abstract $element) {
		$html    = $this->_getHeaderHtml($element);
		$modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());
		sort($modules);

		foreach ($modules as $moduleName) {

			if (strstr($moduleName, 'Genmato_') === false) {
				continue;
			}

			$html .= $this->_getFieldHtml($element, $moduleName);
		}
		$html .= $this->_getFooterHtml($element);

		return $html;
	}

	protected function _getDummyElement() {
		if (empty($this->_dummyElement)) {
			$this->_dummyElement = new Varien_Object(array('show_in_default' => 1, 'show_in_website' => 1));
		}

		return $this->_dummyElement;
	}

	protected function _getFieldRenderer() {
		if (empty($this->_fieldRenderer)) {
			$this->_fieldRenderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');
		}

		return $this->_fieldRenderer;
	}

	protected function _getFieldHtml($fieldset, $moduleName) {
		$moduleShortName = str_replace('Genmato_', '', $moduleName);
		$configData      = $this->getConfigData();

		try {
			if ($platform = Mage::getConfig()->getNode("modules/$moduleName/platform")) {
				$platform        = strtolower($platform);
				$ignore_platform = false;
			} else {
				throw new Exception();
			}
		}
		catch (Exception $e) {
			$platform        = "ce";
			$ignore_platform = true;
		}

		$path = 'advanced/modules_disable_output/' . $moduleName; //TODO: move as property of form
		$data = isset($configData[$path]) ? $configData[$path] : array();

		$e = $this->_getDummyElement();

		$moduleKey = substr($moduleName, strpos($moduleName, '_') + 1);
		$ver       = (Mage::getConfig()->getModuleConfig($moduleName)->version);
		$id        = $moduleName;

		$warning = "";
		if (!$ignore_platform) {
			$magentoVersion = $this->_convertVersion(Mage::getVersion());

		}

		$hasUpdate = false;
		if ($displayNames = Mage::app()->loadCache('Genmato_core_extensions_feed')) {
			if ($displayNames = unserialize($displayNames)) {
				if (isset($displayNames[$moduleName])) {
					$url     = @$displayNames[$moduleName]['url'];
					$name    = @$displayNames[$moduleName]['display_name'];
					$version = @$displayNames[$moduleName]['version'];

					$moduleName = '<a href="' . $url . '" target="_blank" title="' . $name . '">' . $name . "</a>";

					if ($warning) {
						$update     = '<a  target="_blank"><img src="' . $this->getSkinUrl('genmato/images/bad.gif') . '" title="' . $this->__("Wrong Extension Platform") . '"/></a>';
						$moduleName = "$update $moduleName";
					} else {

						if ($this->_convertVersion($ver) < $this->_convertVersion($version)) {
							$update     = '<a href="' . $url . '" target="_blank"><img src="' . $this->getSkinUrl('genmato/images/update.gif') . '" title="' . $this->__("Update available") . '"/></a>';
							$hasUpdate  = 1;
							$moduleName = "$update $moduleName";
						}
					}
				}
			}
		}

		if (!$hasUpdate && !$warning) {
			$update     = '<a  target="_blank"><img src="' . $this->getSkinUrl('genmato/images/ok.gif') . '" title="' . $this->__("Installed") . '"/></a>';
			$moduleName = "$update $moduleShortName";
		} elseif ($warning && (!@$displayNames || !@$name)) {
			$update     = '<a  target="_blank"><img src="' . $this->getSkinUrl('genmato/images/bad.gif') . '" title="' . $this->__("Wrong Extension Platform") . '"/></a>';
			$moduleName = "$update $moduleShortName";
		}

		if ($ver) {
			$field = $fieldset->addField($id, 'label', array('name' => 'ssssss', 'label' => $moduleName, 'value' => $warning ? $warning : $ver,

			))->setRenderer($this->_getFieldRenderer());

			return $field->toHtml();
		}

		return '';

	}


	protected function _convertVersion($v) {
		$digits  = @explode(".", $v);
		$version = 0;
		if (is_array($digits)) {
			foreach ($digits as $k => $v) {
				$version += ($v * pow(10, max(0, (3 - $k))));
			}

		}

		return $version;
	}
}
