<?php

class Spranks_ConfigurableTierPrices_Test_Model_ObserverTest extends EcomDev_PHPUnit_Test_Case
{

    /**
     * Mock session singletons, set default store and fix session problems.
     */
    protected function setUp()
    {
        parent::setUp();
        // mock core session
        $mockCoreSession = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock('singleton', 'core/session', $mockCoreSession);

        // mock checkout session
        $mockCheckoutSession = $this->getModelMockBuilder('checkout/session')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock('singleton', 'checkout/session', $mockCheckoutSession);

        $this->app()->setCurrentStore('default');
        // somehow needed to avoid exceptions of type "Cannot send session cookie - headers already sent by"
        @session_start();
    }

    /**
     * Revert to admin store and fix session problems.
     */
    protected function tearDown()
    {
        // somehow needed to avoid exceptions of type "Failed to write session data"
        @session_destroy();
        $this->setCurrentStore('admin');
    }

    /**
     * @test
     * @loadFixture createProducts
     * @doNotIndexAll
     */
    public function testProduct1Pricing()
    {
        $product = Mage::getModel('catalog/product')->load(1);
        $this->assertEquals(20.0, $product->getFinalPrice(1), 'test normal price');
        $this->assertEventDispatched('catalog_product_get_final_price');
    }

    /**
     * @test
     * @loadFixture createProducts
     * @doNotIndexAll
     */
    public function testProduct1TierPricing()
    {
        $product = Mage::getModel('catalog/product')->load(1);
        $this->assertEquals(18.0, $product->getFinalPrice(2), 'test tier price');
        $this->assertEventDispatched('catalog_product_get_final_price');
    }

    /**
     * @test
     * @loadFixture createProducts
     * @doNotIndexAll
     * @singleton checkout/cart
     */
    public function testProduct1CartPricing()
    {
        $cart = Mage::getSingleton('checkout/cart');
        $cart->init();
        $cart->addProduct(
            1, array(
                'super_attribute' => array(
                    92 => 3
                ),
                'qty' => 1
            )
        );
        $cart->save();
        $cart->getQuote()->collectTotals();
        $this->assertEquals(20, $cart->getQuote()->getGrandTotal(), 'test normal price in cart');
    }

    /**
     * @test
     * @loadFixture createProducts
     * @doNotIndexAll
     * @singleton checkout/cart
     */
    public function testProduct1CartTierPricing()
    {
        $cart = Mage::getSingleton('checkout/cart');
        $cart->init();
        $cart->addProduct(1, array(
            'super_attribute' => array(
                92 => 3
            ),
            'qty' => 1
        ));
        $cart->addProduct(1, array(
            'super_attribute' => array(
                92 => 4
            ),
            'qty' => 1
        ));
        $cart->save();
        $cart->getQuote()->collectTotals();
        $this->assertEquals(36, $cart->getQuote()->getGrandTotal(), 'test tier price in cart');
    }

    /**
     * @test
     * @loadFixture createProducts
     * @doNotIndexAll
     */
    public function testProduct1AdminPricing()
    {
        // TODO implement test
    }

    /**
     * @test
     * @loadFixture createProducts
     * @doNotIndexAll
     */
    public function testProduct1AdminTierPricing()
    {
        // TODO implement test
    }

}
