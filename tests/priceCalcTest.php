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
        $data_collection = $this->getTestData();
        $priceCalc = $this->SUT;

        foreach($data_collection as $data) {
            $ret = $priceCalc->dispatch($data[0]);
            $this->assertEquals($ret, $data[1], sprintf('%s  → %s', $data[0], $data[1]) );
            // echo sprintf('%s  → %s', $ret, $data[1]) . PHP_EOL;

            $priceCalc->clear();
        }
    }


    public function testParseData()
    {
        $priceCalc = $this->SUT;

        $priceCalc->ParseData('210:Cn,In,Iw,Ap,Iw');
        $ret = $priceCalc->getBaseFee();

        $this->assertEquals('210', $ret);
    }

    private function getTestData()
    {
        $data = [
            ["210:Cn,In,Iw,Ap,Iw", "170"],
            ["220:Cp,In", "110"],
            ["230:Cw,In,Iw", "240"],
            ["240:In,An,In", "240"],
            ["250:In,In,Aw,In", "260"],
            ["260:In,In,In,In,Ap", "260"],
            ["270:In,An,In,In,Ip", "410"],
            ["280:Aw,In,Iw,In", "210"],
            ["200:An", "200"],
            ["210:Iw", "60"],
            ["220:Ap", "0"],
            ["230:Cp", "0"],
            ["240:Cw", "60"],
            ["250:In", "130"],
            ["260:Cn", "130"],
            ["270:Ip", "0"],
            ["280:Aw", "140"],
            ["1480:In,An,In,In,In,Iw,Cp,Cw,In,Aw,In,In,Iw,Cn,Aw,Iw", "5920"],
            ["630:Aw,Cw,Iw,An,An", "1740"],
            ["340:Cn,Cn,Ip,Ap", "340"],
            ["240:Iw,Ap,In,Iw,Aw", "120"],
            ["800:Cw,An,Cn,Aw,Ap", "1800"],
            ["1210:An,Ip,In,Iw,An,Iw,Iw,An,Iw,Iw", "3630"],
            ["530:An,Cw,Cw", "810"],
            ["170:Aw,Iw,Ip", "90"],
            ["150:In,Ip,Ip,Iw,In,Iw,Iw,In,An,Iw,Aw,Cw,Iw,Cw,An,Cp,Iw", "580"],
            ["420:Cn,Cw,Cp", "320"],
            ["690:Cw,In,An,Cp,Cn,In", "1220"],
            ["590:Iw,Iw,Cn,Iw,Aw,In,In,Ip,Iw,Ip,Aw", "1200"],
            ["790:Cw,Cn,Cn", "1000"],
            ["1220:In,In,An,An,In,Iw,Iw,In,In,Ip,In,An,Iw", "4590"],
            ["570:Cw,Cn,Cp", "440"],
            ["310:Cn,Cw,An,An,Iw,Cp,Cw,Cn,Iw", "1100"],
            ["910:Aw,In,Iw,Iw,Iw,Iw,Iw,An,Cw,In", "2290"],
            ["460:Iw,Cw,Cw,Cn", "590"],
            ["240:Iw,Iw,In,Iw,In,In,Cn,In,An", "780"],
            ["1240:In,In,In,Ap,In,Cw,Iw,Iw,Iw,Aw,Cw", "2170"],
            ["1000:Iw,Ip,In,An,In,In,In,An,In,Iw,In,In,Iw,In,Iw,Iw,Iw,An", "5500"],
            ["180:In,Aw,Ip,Iw,In,Aw,In,Iw,Iw,In", "330"],
            ["440:In,Ip,Cp,Aw,Iw,In,An", "660"],
            ["1270:Ap,In,An,Ip,In,Ip,Ip", "1270"]
        ];

        return $data;
    }
}
