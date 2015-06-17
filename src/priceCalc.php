<?php
/**
 * Copyright(c) 2015 SAN-AI KIKAKU.CO.,LTD. All rights Reserved.
 * http://www.iii-planing.com
 * Date: 15/06/17
 */

namespace TripleI\bus;


class priceCalc {

    /**
     * 大人料金
     * @var int
     */
    private $basic_fee;

    /**
     * 乗客
     * @var array
     */
    private $riders = [];

    /**
     * 大人・定期券あり
     * @var array
     */
    private $Aps = [];

    /**
     * 子供・通常
     * @var array
     */
    private $Cns = [];

    /**
     * 幼児・通常
     * @var array
     */
    private $lns = [];

    /**
     * 幼児・福祉割引
     * @var array
     */
    private $lws = [];


    public function dispatch($data)
    {

    }


    public function parseData($data)
    {
        $ret = explode(':', $data);
        $this->basic_fee = $ret[0];

        $riders = $ret[1];
        $this->riders = explode(',', $riders);

    }


    public function getBasicFee()
    {
        return $this->basic_fee;
    }
}