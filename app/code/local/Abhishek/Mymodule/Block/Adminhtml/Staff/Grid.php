<?php
class Abhishek_Mymodule_Block_Adminhtml_Staff_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{

     protected function _construct()
    {
            $this->setId('staffGrid');
            $this->setDefaultSort('staff_id'); 
            $this->setSaveParametersInSession(false);
            $this->setUseAjax(true);
    }

    public function getGridUrl()
    { 
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
 

    protected function _prepareCollection()
    {
        /**
         * Tell Magento which Collection to use for displaying in the grid.
         */
        $collection = Mage::getResourceModel(
            'abhishek_mymodule/staff_collection'
        );
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }
    
    public function getRowUrl($row)
    {
        /**
         * When a grid row is clicked, this is where the user should
         * be redirected to. In our example, the method editAction of 
         * staffController.php in Mymodule module.
         */
        return $this->getUrl(
            'abhishek_mymodule_admin/staff/edit', 
            array(
                'id' => $row->getId()
            )
        );
    }

    protected function _prepareColumns()
    {
        /**
         * Here we define which columns we want to be displayed in the grid.
         */
        $this->addColumn('staff_id', array(
            'header' => $this->_getHelper()->__('ID'),
            'type' => 'number',
            'index' => 'staff_id',
        ));
         
        $this->addColumn('name', array(
            'header' => $this->_getHelper()->__('Name'),
            'type' => 'text',
            'index' => 'name',
        ));
        
        $this->addColumn('lastname', array(
            'header' => $this->_getHelper()->__('Code'),
            'type' => 'text',
            'index' => 'code',
        ));
        
        $staffSingleton = Mage::getSingleton(
            'abhishek_mymodule/staff'
        );
        $this->addColumn('visibility', array(
            'header' => $this->_getHelper()->__('Show'),
            'type' => 'options',
            'index' => 'visibility',
            'options' => $staffSingleton->getAvailableVisibilies()
        ));


         $this->addColumn('created_at', array(
            'header' => $this->_getHelper()->__('Created'),
            'type' => 'datetime',
            'index' => 'created_at',
        ));
        
        $this->addColumn('updated_at', array(
            'header' => $this->_getHelper()->__('Updated'),
            'type' => 'datetime',
            'index' => 'updated_at',
        ));
        
        /**
         * Finally we add an action column with an edit link.
         */
        $this->addColumn('action', array(
            'header' => $this->_getHelper()->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'actions' => array(
                array(
                    'caption' => $this->_getHelper()->__('Edit'),
                    'url' => array(
                        'base' => 'abhishek_mymodule_admin'
                                  . '/staff/edit',
                    ),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'staff_id',
        ));
        
        return parent::_prepareColumns();
    }
    

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('staff_id');
        $this->getMassactionBlock()->setFormFieldName('staff_id');
 
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('abhishek_mymodule')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('abhishek_mymodule')->__('Are you sure?')
        ));
  
        return $this;
    }
 

    protected function _getHelper()
    {
        return Mage::helper('abhishek_mymodule');
    }
}