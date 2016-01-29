<?php
class Abhishek_Mymodule_Block_Adminhtml_Staff_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        // instantiate a new form to display our staff for editing
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                'abhishek_mymodule_admin/staff/edit', 
                array(
                    '_current' => true,
                    'continue' => 0,
                )
            ),
            'method' => 'post',
        ));
        $form->setUseContainer(true);
        $this->setForm($form);
        
        // define a new fieldset, we only need one for our simple entity
        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Staff Details')
            )
        );
        
        $staffSingleton = Mage::getSingleton(
            'abhishek_mymodule/staff'
        );
        
        // add the fields we want to be editable
        $this->_addFieldsToFieldset($fieldset, array(
            'name' => array(
                'label' => $this->__('Name'),
                'input' => 'text',
                'required' => true,
            ),
            'code' => array(
                'label' => $this->__('Code'),
                'input' => 'text',
                'required' => true,
            ),
            'description' => array(
                'label' => $this->__('Description'),
                'input' => 'textarea',
                'required' => true,
            ),
            'visibility' => array(
                'label' => $this->__('Show'),
                'input' => 'select',
                'required' => true,
                'options' => $staffSingleton->getAvailableVisibilies(),
            ),
            
            /**
             * Note: we have not included created_at or updated_at,
             * we will handle those fields ourself in the Model before save.
             */
        ));

        return $this;
    }
    
    /**
     * This method makes life a little easier for us by pre-populating 
     * fields with $_POST data where applicable and wraps our post data in 
     * 'staffData' so we can easily separate all relevant information in
     * the controller. You can of course omit this method entirely and call
     * the $fieldset->addField() method directly.
     */
    protected function _addFieldsToFieldset(
        Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()
            ->getPost('staffData'));
        
        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }
            
            // wrap all fields with staffData group
            $_data['name'] = "staffData[$name]";
            
            // generally label and title always the same
            $_data['title'] = $_data['label'];
            
            // if no new value exists, use existing staff data
            if (!array_key_exists('value', $_data)) {
                $_data['value'] = $this->_getStaff()->getData($name);
            }
            
            // finally call vanilla functionality to add field
            $fieldset->addField($name, $_data['input'], $_data);
        }
        
        return $this;
    }
    
    /**
     * Retrieve the existing staff for pre-populating the form fields.
     * For a new staff entry this will return an empty staff object.
     */
    protected function _getStaff() 
    {
        if (!$this->hasData('staff')) {
            // this will have been set in the controller
            $staff = Mage::registry('current_staff');
            
            // just in case the controller does not register the staff
            if (!$staff instanceof 
                    Abhishek_Mymodule_Model_Staff) {
                $staff = Mage::getModel(
                    'abhishek_mymodule/staff'
                );
            }
            
            $this->setData('staff', $staff);
        }
        
        return $this->getData('staff');
    }
}