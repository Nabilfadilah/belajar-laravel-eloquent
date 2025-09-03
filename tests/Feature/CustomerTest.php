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

    // public function testOneToOneQuery()
    // {
    //     $customer = new Customer();
    //     $customer->id = "ABIL";
    //     $customer->name = "Abil";
    //     $customer->email = "abil@abl.com";
    //     $customer->save();

    //     $wallet = new Wallet();
    //     $wallet->amount = 1000000;

    //     $customer->wallet()->save($wallet);

    //     self::assertNotNull($wallet->customer_id);
    // }

    // public function testHasOneThrough()
    // {
    //     $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

    //     $customer = Customer::find("EKO");
    //     self::assertNotNull($customer);

    //     $virtualAccount = $customer->virtualAccount;
    //     self::assertNotNull($virtualAccount);
    //     self::assertEquals("BCA", $virtualAccount->bank);
    // }

    // public function testManyToMany()
    // {
    //     $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

    //     $customer = Customer::find("EKO");
    //     self::assertNotNull($customer);

    //     $customer->likeProducts()->attach("1");

    //     $products = $customer->likeProducts;
    //     self::assertCount(1, $products);

    //     self::assertEquals("1", $products[0]->id);
    // }

    // public function testManyToManyDetach()
    // {
    //     $this->testManyToMany();

    //     $customer = Customer::find("EKO");
    //     $customer->likeProducts()->detach("1");

    //     $products = $customer->likeProducts;
    //     self::assertCount(0, $products);
    // }

    // public function testPivotAttribute()
    // {
    //     $this->testManyToMany();

    //     $customer = Customer::find("EKO");
    //     $products = $customer->likeProducts;

    //     foreach ($products as $product) {
    //         $pivot = $product->pivot;
    //         self::assertNotNull($pivot);
    //         self::assertNotNull($pivot->customer_id);
    //         self::assertNotNull($pivot->product_id);
    //         self::assertNotNull($pivot->created_at);
    //     }
    // }

    // public function testPivotAttributeCondition()
    // {
    //     $this->testManyToMany();

    //     $customer = Customer::find("EKO");
    //     $products = $customer->likeProductsLastWeek;

    //     foreach ($products as $product) {
    //         $pivot = $product->pivot;
    //         self::assertNotNull($pivot);
    //         self::assertNotNull($pivot->customer_id);
    //         self::assertNotNull($pivot->product_id);
    //         self::assertNotNull($pivot->created_at);
    //     }
    // }

    // public function testPivotModel()
    // {
    //     $this->testManyToMany();

    //     $customer = Customer::find("EKO");
    //     $products = $customer->likeProducts;

    //     foreach ($products as $product) {
    //         $pivot = $product->pivot; // object Model Like
    //         self::assertNotNull($pivot);
    //         self::assertNotNull($pivot->customer_id);
    //         self::assertNotNull($pivot->product_id);
    //         self::assertNotNull($pivot->created_at);

    //         self::assertNotNull($pivot->customer);

    //         self::assertNotNull($pivot->product);
    //     }
    // }

    // public function testOneToOnePolymorphic()
    // {
    //     $this->seed([CustomerSeeder::class, ImageSeeder::class]);

    //     $customer = Customer::find("EKO");
    //     self::assertNotNull($customer);

    //     $image = $customer->image;
    //     self::assertNotNull($image);

    //     self::assertEquals("https://www.programmerzamannow.com/image/1.jpg", $image->url);
    // }

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
