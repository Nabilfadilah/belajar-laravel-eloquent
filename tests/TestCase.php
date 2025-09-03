<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // overidde 
    protected function setUp(): void
    {
        parent::setUp();

        // selalu lakukan delete ketika awal database
        DB::delete("delete from categories");
        DB::delete("delete from vouchers");
        DB::delete("delete from comments");
        DB::delete("delete from wallets");
        DB::delete("delete from customers");
    }
}
