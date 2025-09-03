<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    // Test Query One to One
    public function testOneToOne()
    {
        // panggil seeder
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        // ambil customer model, ambil dari id ABIL
        $customer = Customer::find("ABIL");
        self::assertNotNull($customer); // pastikan customer ada

        // $wallet = Wallet::where("customer_id", $customer->id)->first();
        $wallet = $customer->wallet; // panggil atribute wallet, akan dapat 
        self::assertNotNull($wallet);

        // panggil amount 10000000
        self::assertEquals(1000000, $wallet->amount);
    }

    // one to one query
    public function testOneToOneQuery()
    {
        // model customer
        $customer = new Customer();
        $customer->id = "ABIL";
        $customer->name = "Abil";
        $customer->email = "abil@abl.com";
        $customer->save(); //simpan

        $wallet = new Wallet(); // model wallet
        $wallet->amount = 1000000; // isi amount 1 juta

        // jadi wallet() bisa lakukan CRUD
        $customer->wallet() // balikan adalah hashOne
            ->save($wallet); // insert data

        self::assertNotNull($wallet->customer_id);
    }

    // Has One Through
    public function testHasOneThrough()
    {
        // ambil seeder
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        // dari database customer, ambil Id ABIL
        $customer = Customer::find("ABIL");
        self::assertNotNull($customer); // tidak boleh null

        $virtualAccount = $customer->virtualAccount; // ambil secara langsung data virtualAccount dan join dengan table wallet 
        self::assertNotNull($virtualAccount); // gak boleh null va nya
        self::assertEquals("BCA", $virtualAccount->bank); // dari bank BCA
    }

    // Many to Many
    public function testManyToMany()
    {
        // ambil seeder
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        // ambil customer dari id EKO
        $customer = Customer::find("EKO");
        self::assertNotNull($customer); // gak boleh kosong

        $customer->likeProducts() // customer punya likePeoduct
            ->attach("1"); // attach() tambah relasi, jadi masukan id product

        // akan di relasi kan data 1 product
        $products = $customer->likeProducts;
        self::assertCount(1, $products);

        self::assertEquals("1", $products[0]->id);
    }

    // detach many to many
    public function testManyToManyDetach()
    {
        // ambil funtion
        $this->testManyToMany();

        // ambil customer dari id EKO
        $customer = Customer::find("EKO");
        $customer->likeProducts()
            ->detach("1"); // hapus id 1  

        // nilainya harus 0
        $products = $customer->likeProducts;
        self::assertCount(0, $products);
    }

    // Pivot attribute
    public function testPivotAttribute()
    {
        // ambil function
        $this->testManyToMany();

        // customer id EKO
        $customer = Customer::find("EKO");
        $products = $customer->likeProducts; // ambil data likeproduct

        // iterasi product
        foreach ($products as $product) {
            $pivot = $product->pivot; // dalam product ada vipot nya
            // hasilnya tidak boleh kosong untuk pivot, customer_id, product_id, created_at
            self::assertNotNull($pivot); // pivot, isinya semua kolom-kolom yang ada di intermediate table nya
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    // Intermediate Table Condition
    public function testPivotAttributeCondition()
    {
        // ambil function
        $this->testManyToMany();

        // customer id EKO
        $customer = Customer::find("EKO");
        $products = $customer->likeProductsLastWeek; // ambil data likeproductslastweek

        // iterasi product
        foreach ($products as $product) {
            // hasilnya tidak boleh kosong untuk pivot, customer_id, product_id, created_at
            $pivot = $product->pivot; // pivot, isinya semua kolom-kolom yang ada di intermediate table nya
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    // Pivot
    public function testPivotModel()
    {
        // ambil function
        $this->testManyToMany();

        // customer id EKO
        $customer = Customer::find("EKO");
        $products = $customer->likeProducts; // ambil semua data like product

        // iterasi product
        foreach ($products as $product) {
            $pivot = $product->pivot; // object Model Like
            // hasilnya tidak boleh kosong untuk pivot, customer_id, product_id, created_at, customer, product
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);

            self::assertNotNull($pivot->customer);

            self::assertNotNull($pivot->product);
        }
    }

    // Test One to One Polymorphic
    public function testOneToOnePolymorphic()
    {
        // ambil seeder
        $this->seed([CustomerSeeder::class, ImageSeeder::class]);

        // dd(\App\Models\Image::all());

        // ambil data product id 1
        $customer = Customer::find("EKO");
        self::assertNotNull($customer); // gal boleh null

        $image = $customer->image; // ambil semua data image
        self::assertNotNull($image); // gakboleh null

        // img url
        self::assertEquals("https://www.programmerzamannow.com/image/1.jpg", $image->url);
    }

    // public function testEager()
    // {
    //     $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

    //     $customer = Customer::with(["wallet", "image"])->find("EKO");
    //     self::assertNotNull($customer);
    // }

    // public function testEagerModel()
    // {
    //     $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

    //     $customer = Customer::find("EKO");
    //     self::assertNotNull($customer);
    // }
}
