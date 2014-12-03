<?php

class Spranks_ConfigurableTierPrices_Test_Model_ObserverTest extends EcomDev_PHPUnit_Test_Case
{

    /**
     * Mock customer session singleton and set default store.
     */
    protected function setUp()
    {
        parent::setUp();
        // Mock core session
        $mockCoreSession = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock('singleton', 'core/session', $mockCoreSession);

        // Mock checkout session
        $mockCheckoutSession = $this->getModelMockBuilder('checkout/session')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->replaceByMock('singleton', 'checkout/session', $mockCheckoutSession);

        $this->app()->setCurrentStore('default');
    }

    /**
     * Revert to admin store.
     */
    protected function tearDown()
    {
        @session_destroy();
        $this->setCurrentStore('admin');
    }

    /**
     * @test
     * @loadFixture createProducts
     */
    public function testProduct1Pricing()
    {
        $product = Mage::getModel('catalog/product')->load(1);
        $this->assertEquals(20.0, $product->getFinalPrice(1), 'test normal price');
        $this->assertEventDispatched('catalog_product_get_final_price');

        // load product again so that price is calculated again
        $product = Mage::getModel('catalog/product')->load(1);
        $this->assertEquals(18.0, $product->getFinalPrice(2), 'test tier price');
        $this->assertEventDispatched('catalog_product_get_final_price');
    }

    /**
     * @test
     * @loadFixture createProducts
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
        // TODO for some reason, the cart contents from the test testProduct1CartPricing are still available and not
        // TODO the new ones added above :-( If the test testProduct1CartPricing is removed, this test works flawlessly
        $this->assertEquals(36, $cart->getQuote()->getGrandTotal(), 'test tier price in cart');
    }

}
