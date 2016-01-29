<?php
class Abhishek_Mymodule_Adminhtml_StaffController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * Instantiate our grid container block and add to the page content.
     * When accessing this admin index page we will see a grid of all
     * staffs currently available in our Magento instance, along with
     * a button to add a new one if we wish.
     */

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
        $this->getLayout()->createBlock('abhishek_mymodule_adminhtml/staff_grid')->toHtml()
        );
 
    }
  
    public function indexAction()
    {
        // instantiate the grid container
        $staffBlock = $this->getLayout()
            ->createBlock('abhishek_mymodule_adminhtml/staff');
        
        // add the grid container as the only item on this page
        $this->loadLayout()
            ->_addContent($staffBlock)
            ->renderLayout();
    }
    
    /**
     * This action handles both viewing and editing of existing staffs.
     */
    public function editAction()
    {
        /**
         * retrieving existing staff data if an ID was specified,
         * if not we will have an empty staff entity ready to be populated.
         */
        $staff = Mage::getModel('abhishek_mymodule/staff');
        if ($staffId = $this->getRequest()->getParam('id', false)) {
            $staff->load($staffId);

            if ($staff->getId() < 1) {
                $this->_getSession()->addError(
                    $this->__('This Staff member is no longer exists.')
                );
                return $this->_redirect(
                    'abhishek_mymodule_admin/staff/index'
                );
            }
        }
        
        // process $_POST data if the form was submitted
        if ($postData = $this->getRequest()->getPost('staffData')) {
            try {
                $staff->addData($postData);
                $staff->save();
                
                $this->_getSession()->addSuccess(
                    $this->__('The staff has been saved.')
                );
                
                // redirect to remove $_POST data from the request
                return $this->_redirect(
                    'abhishek_mymodule_admin/staff/edit', 
                    array('id' => $staff->getId())
                );
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
            
            /**
             * if we get to here then something went wrong. Continue to
             * render the page as before, the difference being this time 
             * the submitted $_POST data is available.
             */
        }
        
        // make the current staff object available to blocks
        Mage::register('current_staff', $staff);
        
        // instantiate the form container
        $staffEditBlock = $this->getLayout()->createBlock(
            'abhishek_mymodule_adminhtml/staff_edit'
        );
        
        // add the form container as the only item on this page
        $this->loadLayout()
            ->_addContent($staffEditBlock)
            ->renderLayout();
    }
    
    public function deleteAction()
    {
        $staff = Mage::getModel('abhishek_mymodule/staff');

        if ($staffId = $this->getRequest()->getParam('id', false)) {
            $staff->load($staffId);
        }
        
        if ($staff->getId() < 1) {
            $this->_getSession()->addError(
                $this->__('This Staff member is no longer exists.')
            );
            return $this->_redirect(
                'abhishek_mymodule_admin/staff/index'
            );
        }
        
        try {
            $staff->delete();
            
            $this->_getSession()->addSuccess(
                $this->__('The Staff member has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'abhishek_mymodule_admin/staff/index'
        );
    }
 


        public function massDeleteAction()
        {
            $taxIds = $this->getRequest()->getParam('staff_id');      // $this->getMassactionBlock()->setFormFieldName('tax_id'); from Mage_Adminhtml_Block_Tax_Rate_Grid
            if(!is_array($taxIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tax')->__('Please select tax(es).'));
            } else {
            try {
            $rateModel = Mage::getModel('abhishek_mymodule/staff');
            foreach ($taxIds as $taxId) {
            $rateModel->load($taxId)->delete();
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(
            Mage::helper('tax')->__(
            'Total of %d record(s) were deleted.', count($taxIds)
            )
            );
            } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            }
             
            $this->_redirect('*/*/index');
        }

    
    
    /**
     * Thanks to Ben for pointing out this method was missing. Without 
     * this method the ACL rules configured in adminhtml.xml are ignored.
     */
    protected function _isAllowed()
    {
        /**
         * we include this switch to demonstrate that you can add action 
         * level restrictions in your ACL rules. The isAllowed() method will
         * use the ACL rule we have configured in our adminhtml.xml file:
         * - acl 
         * - - resources
         * - - - admin
         * - - - - children
         * - - - - - Abhishek_Mymodule
         * - - - - - - children
         * - - - - - - - staff
         * 
         * eg. you could add more rules inside staff for edit and delete.
         */
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
                // intentionally no break
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('abhishek_mymodule/staff');
                break;
        }
        
        return $isAllowed;
    }
}