<?php

class Genmato_Core_System_Genmato_LoggingController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()
            ->_addContent($this->getLayout()->createBlock('genmato_core/system_genmato_logging'))
            ->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('genmato_core/system_genmato_logging_grid')->toHtml()
        );
    }
}