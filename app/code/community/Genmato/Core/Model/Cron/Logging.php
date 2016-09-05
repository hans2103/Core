<?php

class Genmato_Core_Model_Cron_Logging
{
    public function run()
    {
        Mage::getModel('genmato_core/logging')->clean();
    }
}