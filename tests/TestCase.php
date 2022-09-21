<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * 各テストケースの基盤となるクラス。
 *
 * @package Tests
 * @author  TinhNC <tinhhang22@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}