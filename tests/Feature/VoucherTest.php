<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    public function testCreateVoucher()
    {
        // ambil model Voucher
        $voucher = new Voucher();

        // atur voucher name-nya
        $voucher->name = "Sample Voucher";
        // atur voucher code-nya
        $voucher->voucher_code = "23414124214";
        $voucher->save(); // lalu simpan

        // hasilnya tidak boleh kosong 
        self::assertNotNull($voucher->id);
    }

    // UUID selain primary key
    public function testCreateVoucherUUID()
    {
        $voucher = new Voucher(); // ambil model voucher

        $voucher->name = "Sample Voucher"; // atur voucher name-nya
        $voucher->save(); // simpan

        // hasilnya tidak boleh kosong id nya dan voucher_code
        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);
    }

    // public function testSoftDelete()
    // {
    //     // $this->seed(VoucherSeeder::class);

    //     $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
    //     $voucher->delete();

    //     $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
    //     self::assertNull($voucher);

    //     $voucher = Voucher::withTrashed()->where('name', '=', 'Sample Voucher')->first();
    //     self::assertNotNull($voucher);
    // }

    // public function testLocalScope()
    // {
    //     $voucher = new Voucher();
    //     $voucher->name = "Sample Voucher";
    //     $voucher->is_active = true;
    //     $voucher->save();

    //     $total = Voucher::active()->count();
    //     self::assertEquals(1, $total);

    //     $total = Voucher::nonActive()->count();
    //     self::assertEquals(0, $total);
    // }
}
