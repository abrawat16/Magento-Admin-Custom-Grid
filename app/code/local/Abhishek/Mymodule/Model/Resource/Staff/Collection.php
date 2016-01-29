<?php
class Abhishek_Mymodule_Model_Resource_Staff_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        
        /**
         * Tell Magento the Model and Resource Model to use for this 
         * Collection. Since both aliases are the same we can ommit
         * the second paramater if we wished.
         */
        $this->_init(
            'abhishek_mymodule/staff', 
            'abhishek_mymodule/staff'
        );
    }
}