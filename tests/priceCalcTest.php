<?php
/**
 * Copyright(c) 2015 SAN-AI KIKAKU.CO.,LTD. All rights Reserved.
 * http://www.iii-planing.com
 * Date: 15/06/17
 */

namespace TripleI\bus;


class priceCalcTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var priceCalc
     */
    protected $SUT;

    protected function setUp()
    {
        parent::setUp();
        $this->SUT = new priceCalc();
    }


    public function testDispatch()
    {

    }


    public function testParseData()
    {
        $priceCalc = $this->SUT;

        $priceCalc->ParseData('210:Cn,In,Iw,Ap,Iw');
        $ret = $priceCalc->getBasicFee();

        $this->assertEquals('210', $ret);
    }
}