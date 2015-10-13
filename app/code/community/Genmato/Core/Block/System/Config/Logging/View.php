<?php

class Genmato_Core_Block_System_Config_Logging_View extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * @param Varien_Data_Form_Element_Abstract $element
     *
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $url = Mage::helper('adminhtml')->getUrl('adminhtml/system_genmato_logging');

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setClass('scalable')
            ->setLabel($this->__('View Logging'))
            ->setOnClick("setLocation('$url')")
            ->toHtml();

        return $html;
    }
}