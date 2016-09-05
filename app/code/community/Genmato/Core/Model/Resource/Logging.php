<?php

class Genmato_Core_Model_Resource_Logging extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('genmato_core/logging', 'entity_id');
    }

    public function clean(Genmato_Core_Model_Logging $object)
    {
        $writeAdapter = $this->_getWriteAdapter();
        $cleanTime = $object->getLogCleanTime();

        $timeLimit = $this->formatDate(Mage::getModel('core/date')->gmtTimestamp() - $cleanTime);

        $condition = array('createdate < ?' => $timeLimit);

        $writeAdapter->delete($this->getTable('genmato_core/logging'), $condition);

        return $this;
    }

}