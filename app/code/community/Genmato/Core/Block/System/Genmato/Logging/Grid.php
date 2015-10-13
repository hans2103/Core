<?php

class Genmato_Core_Block_System_Genmato_Logging_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('genmato_core_logging');
        $this->setUseAjax(true);
        $this->_controller = 'system_genmato_logging';
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setEmptyText(Mage::helper('genmato_core')->__('No records found!'));
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('genmato_core/logging')
            ->getCollection();

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn(
            'createdate',
            array(
                'header' => Mage::helper('genmato_core')->__('Date'),
                'width' => '150px',
                'index' => 'createdate',
            )
        );

        $this->addColumn(
            'level',
            array(
                'header' => Mage::helper('genmato_core')->__('Level'),
                'width' => '100px',
                'index' => 'level',
            )
        );
        $this->addColumn(
            'source',
            array(
                'header' => Mage::helper('genmato_core')->__('Source'),
                'width' => '100px',
                'index' => 'source',
            )
        );
        $this->addColumn(
            'reference',
            array(
                'header' => Mage::helper('genmato_core')->__('Reference'),
                'width' => '100px',
                'index' => 'reference',
            )
        );

        $this->addColumn(
            'message',
            array(
                'header' => Mage::helper('genmato_core')->__('Message'),
                'index' => 'message',
            )
        );

        $this->addColumn(
            'extra',
            array(
                'header' => Mage::helper('genmato_core')->__('Extra'),

                'index' => 'extra',
            )
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}