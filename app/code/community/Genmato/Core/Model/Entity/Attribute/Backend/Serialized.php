<?php

class Genmato_Core_Model_Entity_Attribute_Backend_Serialized extends Mage_Eav_Model_Entity_Attribute_Backend_Serialized
{
    /**
     * Serialize before saving
     * Unset array element with '__empty' key
     *
     * @param Varien_Object $object
     * @return Mage_Eav_Model_Entity_Attribute_Backend_Serialized
     */
    public function beforeSave($object)
    {
        $attrCode = $this->getAttribute()->getAttributeCode();
        if ($object->hasData($attrCode)) {
            $value = $object->getData($attrCode);
            if (is_array($value) && isset($value['__empty'])) {
                unset($value['__empty']);
            }
            $object->setData($attrCode, serialize($value));
        }

        return $this;
    }
}