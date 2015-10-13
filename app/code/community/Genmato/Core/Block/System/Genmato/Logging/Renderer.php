<?php

class Genmato_Core_Block_System_Genmato_Logging_Renderer
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        return '<pre>'.$value.'</pre>';
    }
}