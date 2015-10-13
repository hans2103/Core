<?php

class Genmato_Core_Model_Resource_Logging extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('genmato_core/logging', 'entity_id');
    }
}