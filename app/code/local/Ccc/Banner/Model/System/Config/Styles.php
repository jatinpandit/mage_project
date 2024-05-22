<?php

class Ccc_Banner_Model_System_Config_Styles
{
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label' => 'Disabled'),
            array('value' => 1, 'label' => 'Enabled')
        );
    }
}