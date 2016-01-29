<?php
class abhishek_mymodule_Model_Resource_Staff 
    extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        /**
         * Tell Magento the database name and primary key field to persist 
         * data to. Similar to the _construct() of our Model, Magento finds 
         * this data from config.xml by finding the <resourceModel/> node 
         * and locating children of <entities/>.
         * 
         * In this example:
         * - abhishek_mymodule is the Model alias
         * - staff is the entity referenced in config.xml
         * - staff_id is the name of the primary key column
         * 
         * As a result Magento will write data to the table 
         * 'abhishek_mymodule_staff' and any calls to 
         * $model->getId() will retrieve the data from the column 
         * named 'staff_id'.
         */
        $this->_init('abhishek_mymodule/staff', 'staff_id');
    }
}