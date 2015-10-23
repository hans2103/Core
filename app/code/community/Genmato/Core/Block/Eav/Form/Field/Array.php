<?php

class Genmato_Core_Block_Eav_Form_Field_Array extends Varien_Data_Form_Element_Abstract
{
    /** @var $_dataBlock Genmato_Core_Block_Eav_Form_Field_Array_Data */
    protected $_dataBlock;

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->_dataBlock = Mage::app()->getLayout()->createBlock('genmato_core/eav_form_field_array_data');
        $this->_dataBlock->addData($attributes);
    }

    public function getHtml()
    {
        $this->_dataBlock->setElement($this);
        $html = $this->_dataBlock->toHtml();
        $this->_dataBlock->setArrayRowsCache(null);
        return $html;
    }

    public function getHtmlAttributes()
    {
        return array();
    }

    /**
     * Enable or Disable the "Add After" buttons.
     *
     * @param $bValue boolean
     * @return $this
     */
    public function setAddAfter($bValue)
    {
        $this->_dataBlock->setAddAfter($bValue);
        return $this;
    }

    /**
     * Indicates whether or not the "Add After" buttons will be displayed.
     *
     * @return bool
     */
    public function getAddAfter()
    {
        return $this->_dataBlock->getAddAfter();
    }

    /**
     * Sets the label for the "Add" button.
     *
     * @param $vLabel string
     * @return $this
     */
    public function setAddButtonLabel($vLabel)
    {
        $this->_dataBlock->setAddButtonLabel($vLabel);
        return $this;
    }

    /**
     * Returns the label for the "Add" button.
     *
     * @return string
     */
    public function getAddButtonLabel()
    {
        return $this->_dataBlock->getAddButtonLabel();
    }

    /**
     * Add a column to array-grid
     *
     * @param string $name
     * @param array $params
     * @return $this
     */
    public function addColumn($name, $params)
    {
        $this->_dataBlock->addColumn($name, $params);
        return $this;
    }

    public function getAfterElementHtml()
    {
        if (parent::getAfterElementHtml() != '') {
            return Mage::app()->getLayout()->createBlock('core/template')
                ->setTemplate('genmato/core/eav/form/field/array/change.phtml')
                ->setElement($this)
                ->toHtml();
        }
        return '';
    }
}