<?php

class Genmato_Core_Model_System_Config_Source_Debug_Level
{
    public function toOptionHash()
    {
        $result = array();

        $result[Zend_Log::CRIT] = Mage::helper('genmato_core')->__('Critical');
        $result[Zend_Log::INFO] = Mage::helper('genmato_core')->__('Info');
        $result[Zend_Log::ALERT] = Mage::helper('genmato_core')->__('Alert');
        $result[Zend_Log::DEBUG] = Mage::helper('genmato_core')->__('Debug');
        $result[Zend_Log::EMERG] = Mage::helper('genmato_core')->__('Emergency');
        $result[Zend_Log::ERR] = Mage::helper('genmato_core')->__('Error');
        $result[Zend_Log::NOTICE] = Mage::helper('genmato_core')->__('Notice');
        $result[Zend_Log::WARN] = Mage::helper('genmato_core')->__('Warning');

        return $result;
    }

    public function toOptionArray()
    {
        $result = array();
        foreach ($this->toOptionHash() as $value => $label) {
            $result[] = array('value'=>$value, 'label'=>$label);
        }
        return $result;
    }
}