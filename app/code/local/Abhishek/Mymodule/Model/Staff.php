<?php
class  Abhishek_Mymodule_Model_Staff 
    extends Mage_Core_Model_Abstract
{
    const VISIBILITY_HIDDEN = '1';
    const VISIBILITY_DIRECTORY = '0';
    
    protected function _construct()
    {
        /**
         * This tells Magento where the related Resource Model can be found.
         * 
         * For a Resource Model, Magento will use the standard Model alias,
         * in this case 'abhishek_mymodule' and look in 
         * config.xml for a child node <resourceModel/>. This will be the
         * location Magento will look for a Model when 
         * Mage::getResourceModel() is called. In our case:
         * Abhishek_Mymodule_Model_Resource
         */
        $this->_init('abhishek_mymodule/staff');
    }
    
    /**
     * This method is used in grid and form for populating dropdown.
     */
    public function getAvailableVisibilies()
    {
        return array(
          
                self::VISIBILITY_HIDDEN 
                => Mage::helper('abhishek_mymodule')
                       ->__('Yes'),
                self::VISIBILITY_DIRECTORY
                => Mage::helper('abhishek_mymodule')
                       ->__('No'),
        );
    }
    
    protected function _beforeSave()
    {
        parent::_beforeSave();
        
        /**
         * Perform some actions just before a Staff is saved.
         */
        $this->_updateTimestamps();
        $this->_prepareUrlKey();
        
        return $this;
    }
    
    protected function _updateTimestamps()
    {
        $timestamp = now();
        
        /**
         * Set the last updated timestamp.
         */
        $this->setUpdatedAt($timestamp);
        
        /**
         * If we have a staff new object, set the created timestamp.
         */
        if ($this->isObjectNew()) {
            $this->setCreatedAt($timestamp);
        }
        
        return $this;
    }
    
    protected function _prepareUrlKey()
    {
        /**
         * In this method you might consider ensuring
         * the URL Key entered is unique and contains
         * only alphanumeric characters.
         */
        
        return $this;
    }
}