<?php

class Spranks_ConfigurableTierPrices_Test_Config_Main extends EcomDev_PHPUnit_Test_Case_Config
{

    /**
     * Check it the installed module has the correct module version
     */
    public function testModuleConfig()
    {
        $this->assertModuleVersionGreaterThanOrEquals($this->expected('module')->getVersion(), 'module is new enough');
        $this->assertModuleCodePool($this->expected('module')->getCodePool(), 'correct module code pool');
        $this->assertModuleIsActive('module is active');
    }

    /**
     * Check if the helper aliases are returning the correct class names
     */
    public function testHelperAliases()
    {
        $this->assertHelperAlias(
            'spranks_configurabletierprices/admin', 'Spranks_ConfigurableTierPrices_Helper_Admin',
            'correct helper alias'
        );
    }

    /**
     * Check if the helper aliases are returning the correct class names
     */
    public function testModelAliases()
    {
        $this->assertModelAlias(
            'spranks_configurabletierprices/observer', 'Spranks_ConfigurableTierPrices_Model_Observer',
            'correct model alias'
        );
    }

}
