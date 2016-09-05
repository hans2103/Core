<?php

class Genmato_Core_Model_Logging extends Mage_Core_Model_Abstract
{
    const XML_LOG_CLEAN_DAYS    = 'genmato_core/logging/clean_period';

    protected function _construct()
    {
        $this->_init('genmato_core/logging');
    }

    public function getLogCleanTime()
    {
        return Mage::getStoreConfig(self::XML_LOG_CLEAN_DAYS) * 60 * 60 * 24;
    }

    public function clean()
    {
        $this->getResource()->clean($this);
    }
}