<?php
/**
 * Copyright(c) 2015 SAN-AI KIKAKU.CO.,LTD. All rights Reserved.
 * http://www.iii-planing.com
 * Date: 15/06/17
 */

namespace TripleI\bus;


/**
 * http://nabetani.sakura.ne.jp/hena/ord9busfare/
 * Class priceCalc
 * @package TripleI\bus
 */
class priceCalc
{

    /**
     * データ
     * @var int
     */
    private $data;

    /**
     * 大人料金
     * @var int
     */
    private $base_fee;

    /**
     * 乗客
     * @var array
     */
    private $riders = [];


    public function dispatch($data)
    {
        $this->parseData($data);
        return $this->calc();
    }


    public function parseData($data)
    {
        $this->data = $data;
        $ret = explode(':', $data);
        $this->base_fee = $ret[0];

        $riders = $ret[1];
        $riders = explode(',', $riders);
        foreach ($riders as $rider) {
            $this->sortToArray($rider);
        }
    }

    private function sortToArray($rider)
    {
        $type = substr($rider, 0, 1);
        $class = substr($rider, 1);
        switch($type) {
            case 'A':
                $this->classToArray('A', $class);
                break;
            case 'C':
                $this->classToArray('C', $class);
                break;
            case 'I':
                $this->classToArray('I', $class);
                break;
        }
    }

    private function classToArray($type, $class)
    {
        switch($class) {
            case 'n': // 通常 割引なし
                $this->riders[$type]['n'][] = true;
                break;
            case 'w': // 福祉 1/2引き
                $this->riders[$type]['w'][] = true;
                break;
            case 'p': // パス
                $this->riders[$type]['p'][] = true;
                break;
        }
    }


    public function calc()
    {
        $adult_count = 0;
        $base_fee = $this->base_fee;
        $base_fee_half = round($base_fee / 2, -1);
        $base_fee_qtr = round($base_fee_half / 2, -1);

        $fee = 0;

        // 大人
        $A = @$this->riders['A'];
        if (@count($A['n']) > 0) {
            $adult_count = count($A['n']) * 2;
            $fee = $fee + $base_fee * count($A['n']);
        }
        if (@count($A['w']) > 0) {
            $adult_count = $adult_count + count($A['w']) * 2;
            $fee = $fee + $base_fee_half * count($A['w']);
        }
        if (@count($A['p']) > 0) {
            $adult_count = $adult_count + count($A['p']) * 2;
        }

        // 子供
        $C = @$this->riders['C'];
        if (@count($C['n']) > 0) {
            $fee = $fee + $base_fee_half * count($C['n']);
        }
        if (@count($C['w']) > 0) {
            $fee = $fee + $base_fee_qtr * count($C['w']);
        }

        /**
         * 幼児
         * 幼児はadult_counterがあればカンターの数だけ積算しない
         */
        $I = @$this->riders['I'];
        // 通常料金
        if (@count($I['n']) > 0) {

            while ($adult_count > 0 && count($I['n']) > 0) {
                array_pop($I['n']);
                $adult_count--;
            }

            $fee = $fee + $base_fee_half * count($I['n']);
        }

        // 福祉割引
        if (@count($I['w']) > 0) {
            while ($adult_count > 0 && count($I['w']) > 0) {
                array_pop($I['w']);
                $adult_count--;
            }

            $fee = $fee + $base_fee_qtr * count($I['w']);
        }

        return $fee;
    }

    public function clear()
    {
        unset($this->data, $this->riders);
    }



    public function getBaseFee()
    {
        return $this->base_fee;
    }
}