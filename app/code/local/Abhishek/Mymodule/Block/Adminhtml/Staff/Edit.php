<?php
class Abhishek_Mymodule_Block_Adminhtml_Staff_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'abhishek_mymodule_adminhtml';
        $this->_controller = 'staff';
        
        /**
         * The $_mode property tells Magento which folder to use to
         * locate the related form blocks to be displayed within this
         * form container. In our example this corresponds to 
         * Mymodule/Block/Adminhtml/staff/Edit/.
         */
        $this->_mode = 'edit';
        
        $newOrEdit = $this->getRequest()->getParam('id')
            ? $this->__('Edit') 
            : $this->__('New');
        $this->_headerText =  $newOrEdit . ' ' . $this->__('Staff');
    }
}