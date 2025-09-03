<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testOneToMany()
    {
        // ambil seeder
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // ambil id nya 1
        $product = Product::find("1");
        // dd($product);
        self::assertNotNull($product); // gak boleh kosong

        $category = $product->category; // ambil semua data product
        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id); // harus FOOD cateroty id nya
    }

    // Has One of Many
    public function testHasOneOfMany()
    {
        // ambil seeder
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD"); // model category ambil data berdasarkan id FOOD
        self::assertNotNull($category);

        // langsung panggil product paling murah
        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct); // gak boleh kosong
        self::assertEquals("1", $cheapestProduct->id); // datanya harus 1, dari cheapestProduct id 

        // langsung panggil product paling mahal
        $mostExpensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpensiveProduct); // gak boleh kosong
        self::assertEquals("2", $mostExpensiveProduct->id); // pastikan datanya ke 2
    }

    // Test One to One Polymorphic
    public function testOneToOnePolymorphic()
    {
        // ambil seeder
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        // ambil data product id 1
        $product = Product::find("1");
        self::assertNotNull($product); // gak boleh null

        $image = $product->image; // ambil semua data image
        self::assertNotNull($image); // gak boleh null

        // image url
        self::assertEquals("https://www.programmerzamannow.com/image/2.jpg", $image->url);
    }

    // public function testOneToManyPolymorphic()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

    //     $product = Product::find("1");
    //     self::assertNotNull($product);

    //     $comments = $product->comments;
    //     foreach ($comments as $comment) {
    //         self::assertEquals("product", $comment->commentable_type);
    //         self::assertEquals($product->id, $comment->commentable_id);
    //     }
    // }

    // public function testOneOfManyPolymorphic()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

    //     $product = Product::find("1");
    //     self::assertNotNull($product);

    //     $comment = $product->latestComment;
    //     self::assertNotNull($comment);

    //     $comment = $product->oldestComment;
    //     self::assertNotNull($comment);
    // }

    // public function testManyToManyPolymorphic()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, TagSeeder::class]);

    //     $product = Product::find("1");
    //     $tags = $product->tags;
    //     self::assertNotNull($tags);
    //     self::assertCount(1, $tags);

    //     foreach ($tags as $tag) {
    //         self::assertNotNull($tag->id);
    //         self::assertNotNull($tag->name);

    //         $vouchers = $tag->vouchers;
    //         self::assertNotNull($vouchers);
    //         self::assertCount(1, $vouchers);
    //     }
    // }

    // public function testEloquentCollection()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class]);

    //     // 2 products, 1, 2
    //     $products = Product::query()->get();

    //     // WHERE id IN (1, 2)
    //     $products = $products->toQuery()->where('price', 200)->get();

    //     self::assertNotNull($products);
    //     self::assertEquals("2", $products[0]->id);
    // }

    // public function testSerialization()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class]);

    //     $products = Product::query()->get();
    //     self::assertCount(2, $products);

    //     $json = $products->toJson(JSON_PRETTY_PRINT);
    //     Log::info($json);
    // }

    // public function testSerializationRelation()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

    //     $products = Product::query()->get();
    //     $products->load(["category", "image"]);
    //     self::assertCount(2, $products);

    //     $json = $products->toJson(JSON_PRETTY_PRINT);
    //     Log::info($json);
    // }
}
