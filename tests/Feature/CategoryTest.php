<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class CategoryTest extends TestCase
{
    public function testInsert()
    {
        $category = new Category();

        $category->id = "GADGET"; // id
        $category->name = "Gadget"; // name
        $result = $category->save(); // simpan datanya

        // hasilnya simpan
        self::assertTrue($result);
    }

    // Insert Many
    public function testInsertMany()
    {
        $categories = []; // variabel dalam array
        for ($i = 0; $i < 10; $i++) {
            // insert 10 data category
            $categories[] = [
                // dimana tiap datanya 
                "id" => "ID $i", // ada id
                "name" => "Name $i", // ada name
                // 'is_active' => true
            ];
        }

        // static method
        // method insert, dan masukan data categories yang kita insert
        // $result = Category::query()->insert($categories); //
        $result = Category::insert($categories); // ini pake magic method, karena gak perlu pake 'query()'

        // harus true
        self::assertTrue($result);

        // hasil jumlah data yang di insert
        // $total = Category::query()->count();
        $total = Category::count(); // Category = model
        self::assertEquals(10, $total);
    }

    // Find
    public function testFind()
    {
        // ambil seeder class category 
        $this->seed(CategorySeeder::class);

        // $category = Category::query()->find("FOOD");
        $category = Category::find("FOOD"); // pada model category, temukan id FOOD

        self::assertNotNull($category); // tidak boleh kosong
        self::assertEquals("FOOD", $category->id); // hasilnya harus id FOOD dari teble category
        self::assertEquals("Food", $category->name); // namanya 
        self::assertEquals("Food Category", $category->description); // descripsinya
    }

    // public function testUpdate()
    // {
    //     $this->seed(CategorySeeder::class);

    //     $category = Category::find("FOOD");
    //     $category->name = "Food Updated";

    //     $result = $category->update();
    //     self::assertTrue($result);
    // }

    // public function testSelect()
    // {
    //     for ($i = 0; $i < 5; $i++) {
    //         $category = new Category();
    //         $category->id = "ID $i";
    //         $category->name = "Name $i";
    //         $category->is_active = true;
    //         $category->save();
    //     }

    //     $categories = Category::whereNull("description")->get();
    //     self::assertEquals(5, $categories->count());
    //     $categories->each(function ($category) {
    //         self::assertNull($category->description);

    //         $category->description = "Updated";
    //         $category->update();
    //     });
    // }

    // public function testUpdateMany()
    // {
    //     $categories = [];
    //     for ($i = 0; $i < 10; $i++) {
    //         $categories[] = [
    //             "id" => "ID $i",
    //             "name" => "Name $i",
    //             'is_active' => true
    //         ];
    //     }

    //     $result = Category::insert($categories);
    //     self::assertTrue($result);

    //     Category::whereNull("description")->update([
    //         "description" => "Updated"
    //     ]);
    //     $total = Category::where("description", "=", "Updated")->count();
    //     self::assertEquals(10, $total);
    // }

    // public function testDelete()
    // {
    //     $this->seed(CategorySeeder::class);

    //     $category = Category::find("FOOD");
    //     $result = $category->delete();
    //     self::assertTrue($result);

    //     $total = Category::count();
    //     self::assertEquals(0, $total);
    // }

    // public function testDeleteMany()
    // {
    //     $categories = [];
    //     for ($i = 0; $i < 10; $i++) {
    //         $categories[] = [
    //             "id" => "ID $i",
    //             "name" => "Name $i",
    //             'is_active' => true
    //         ];
    //     }

    //     $result = Category::insert($categories);
    //     self::assertTrue($result);

    //     $total = Category::count();
    //     assertEquals(10, $total);

    //     Category::whereNull("description")->delete();

    //     $total = Category::count();
    //     assertEquals(0, $total);
    // }

    // public function testCreate()
    // {
    //     $request = [
    //         "id" => "FOOD",
    //         "name" => "Food",
    //         "description" => "Food Category"
    //     ];

    //     $category = new Category($request);
    //     $category->save();

    //     self::assertNotNull($category->id);
    // }

    // public function testCreateUsingQueryBuilder()
    // {
    //     $request = [
    //         "id" => "FOOD",
    //         "name" => "Food",
    //         "description" => "Food Category"
    //     ];

    //     // $category = Category::query()->create($request);
    //     $category = Category::create($request);

    //     self::assertNotNull($category->id);
    // }

    // public function testUpdateMass()
    // {
    //     $this->seed(CategorySeeder::class);

    //     $request = [
    //         "name" => "Food Updated",
    //         "description" => "Food Category Updated"
    //     ];

    //     $category = Category::find("FOOD");
    //     $category->fill($request);
    //     $category->save();

    //     self::assertNotNull($category->id);
    // }

    // public function testGlobalScope()
    // {
    //     $category = new Category();
    //     $category->id = "FOOD";
    //     $category->name = "Food";
    //     $category->description = "Food Category";
    //     $category->is_active = false;
    //     $category->save();

    //     $category = Category::find("FOOD");
    //     self::assertNull($category);

    //     $category = Category::withoutGlobalScopes([IsActiveScope::class])->find("FOOD");
    //     self::assertNotNull($category);
    // }

    // public function testOneToMany()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class]);

    //     $category = Category::find("FOOD");
    //     self::assertNotNull($category);

    //     // $products = Product::where("category_id", $category->id)->get();
    //     $products = $category->products;

    //     self::assertNotNull($products);
    //     self::assertCount(2, $products);
    // }

    // public function testOneToManyQuery()
    // {
    //     $category = new Category();
    //     $category->id = "FOOD";
    //     $category->name = "Food";
    //     $category->description = "Food Category";
    //     $category->is_active = true;
    //     $category->save();

    //     $product = new Product();
    //     $product->id = "1";
    //     $product->name = "Product 1";
    //     $product->description = "Description 1";

    //     $category->products()->save($product);

    //     self::assertNotNull($product->category_id);
    // }

    // public function testRelationshipQuery()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class]);

    //     $category = Category::find("FOOD");
    //     $products = $category->products;
    //     self::assertCount(2, $products);

    //     $outOfStockProducts = $category->products()->where('stock', '<=', 0)->get();
    //     self::assertCount(2, $outOfStockProducts);
    // }

    // public function testHasManyThrough()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class, ReviewSeeder::class]);

    //     $category = Category::find("FOOD");
    //     self::assertNotNull($category);

    //     $reviews = $category->reviews;
    //     self::assertNotNull($reviews);
    //     self::assertCount(2, $reviews);

    // }

    // public function testQueryingRelations()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class]);

    //     $category = Category::find("FOOD");
    //     $products = $category->products()->where("price", "=", 200)->get();

    //     self::assertCount(1, $products);
    //     self::assertEquals("2", $products[0]->id);

    // }

    // public function testAggregatingRelations()
    // {
    //     $this->seed([CategorySeeder::class, ProductSeeder::class]);

    //     $category = Category::find("FOOD");
    //     $total = $category->products()->count();

    //     self::assertEquals(2, $total);

    //     $total = $category->products()->where('price', 200)->count();

    //     self::assertEquals(1, $total);

    // }

}
