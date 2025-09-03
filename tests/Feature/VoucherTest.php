<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
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

    // Soft Delete
    public function testSoftDelete()
    {
        // panggil seeder voucher
        $this->seed(VoucherSeeder::class);

        // data Voucher, dimana 'name' sama dengan 'sample voucher' 
        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        $voucher->delete(); // lakukan delete data

        // data Voucher, dimana 'name' sama dengan 'sample voucher' 
        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        self::assertNull($voucher); // hasilnya voucher tidak boleh kosong

        // data Voucher, withTrashed() mengambil seluruh data termasuk yang sudah di soft delete,
        // dimana 'name' sama dengan 'sample voucher' 
        $voucher = Voucher::withTrashed()->where('name', '=', 'Sample Voucher')->first();
        self::assertNotNull($voucher); // hasilnya vourcher tidak boleh kosong
    }

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
