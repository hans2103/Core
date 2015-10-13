<?php

class Genmato_Core_Model_Resource_Logging_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('genmato_core/logging');
    }
}