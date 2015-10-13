<?php

class Genmato_Core_Block_System_Genmato_Logging extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'genmato_core';
        $this->_controller = 'system_genmato_logging';
        $this->_headerText = Mage::helper('genmato_core')->__('Genmato Extension Logging');
        $this->_removeButton('add');
    }
}