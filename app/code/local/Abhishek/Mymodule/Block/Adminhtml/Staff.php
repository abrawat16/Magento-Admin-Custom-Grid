<?php
class Abhishek_Mymodule_Block_Adminhtml_Staff 
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();
        
        /**
         * The $_blockGroup property tells Magento which alias to use to
         * locate the blocks to be displayed within this grid container.
         * In our example this corresponds to Mymodule/Block/Adminhtml.
         */
        $this->_blockGroup = 'abhishek_mymodule_adminhtml';
        
        /**
         * $_controller is a bit of a confusing name for this property. This 
         * value in fact refers to the folder containing our Grid.php and 
         * Edit.php. In our example, Mymodule/Block/Adminhtml/staff, 
         * so we use 'staff'.
         */
        $this->_controller = 'staff';
        
        /**
         * The title of the page in the admin panel.
         */
        $this->_headerText = Mage::helper('abhishek_mymodule')
            ->__('Staff Directory');
    }
    
    public function getCreateUrl()
    {
        /**
         * When the Add button is clicked, this is where the user should
         * be redirected to. In our example, the method editAction of 
         * StaffController.php in Mymodule  module.
         */
        return $this->getUrl(
            'abhishek_mymodule_admin/staff/edit'
        );
    }
}