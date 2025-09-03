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
                'is_active' => true
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

    // Update
    public function testUpdate()
    {
        // ambil seeder class category 
        $this->seed(CategorySeeder::class);

        // harus find() terlebih dahulu!!!
        $category = Category::find("FOOD"); // pada model category, temukan id FOOD
        $category->name = "Food Updated"; // name nya

        $result = $category->update(); // hasilnya, update data category
        self::assertTrue($result); // harus true
    }

    // Select
    public function testSelect()
    {
        // untuk tambah 5 data 
        for ($i = 0; $i < 5; $i++) {
            $category = new Category(); // untuk table Category 
            $category->id = "ID $i"; // isi id nya
            $category->name = "Name $i"; // isi name nya
            // $category->is_active = true; 
            $category->save(); // simpan datanya
        }

        // lakukan query dari semua data description nya Null
        $categories = Category::whereNull("description")->get();

        // hasilnya harus ada 5 data categories
        self::assertEquals(0, $categories->count());

        // each, setiap category
        $categories->each(function ($category) {
            // pastikan tidak kosong/null, dari category description nya
            self::assertNull($category->description);

            // kita bisa melakukan operasi lainnya pada hasil select Model tersebut, misal melakukan update
            // tiap category kita update, menjadi "Updated"
            $category->description = "Updated";
            $category->update(); // lalu panggil update
        });
    }

    // Update Many
    public function testUpdateMany()
    {
        $categories = []; // variabel data array
        for ($i = 0; $i < 10; $i++) {
            // insert 10 data category
            $categories[] = [
                // dimana tiap datanya 
                "id" => "ID $i", // ada id
                "name" => "Name $i", // ada name
                'is_active' => true
            ];
        }

        // static method
        // method insert, dan masukan data categories yang kita insert
        $result = Category::insert($categories);
        self::assertTrue($result); // hasilnya harus true

        // model category yang null pada description, maka saya ingin update deskripsi menjadi tulisan "Updated"
        Category::whereNull("description")->update([
            "description" => "Updated"
        ]);

        // apakah description sudah berubah, kita lakukan query ke database 
        // dimana description adalah Updated
        $total = Category::where("description", "=", "Updated")
            ->count(); // dan pastikan jumlahnya
        self::assertEquals(10, $total); // adalah 10
    }

    // Delete
    public function testDelete()
    {
        // ambil seeder class category 
        $this->seed(CategorySeeder::class);

        // dari table category, temukan id "FOOD"
        $category = Category::find("FOOD");
        $result = $category->delete(); // hasilnya delete category id 'FOOD'
        self::assertTrue($result); // harus benar hasilnya

        $total = Category::count(); // total model category
        self::assertEquals(0, $total); // hasilnya sama dengan 0, dari total data 
    }

    // Delete Many
    public function testDeleteMany()
    {
        $categories = []; // variabel data array
        for ($i = 0; $i < 10; $i++) {
            // insert 10 data category
            $categories[] = [
                // dimana tiap datanya 
                "id" => "ID $i", // ada id
                "name" => "Name $i", // ada name
                'is_active' => true
            ];
        }

        // static method
        // method insert, dan masukan data categories yang kita insert
        $result = Category::insert($categories);
        self::assertTrue($result);

        $total = Category::count(); // total model category
        assertEquals(10, $total); // hasilnya sama dengan 10, dari total data 

        // model category yang null pada description, maka saya ingin delete semua.
        Category::whereNull("description")->delete();

        $total = Category::count(); // total model category
        assertEquals(0, $total); // hasilnya sama dengan 0, dari total data 
    }

    // Fillable Attributes
    public function testCreate()
    {
        // ini kita bisa ambil di request 
        $request = [
            // id => jadi key, akan jadi kolom
            // "food" => jadi value 
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category"
        ];

        // berikan model category dan request nya apa
        $category = new Category($request);
        $category->save(); // save data

        self::assertNotNull($category->id); // id tidak boleh kosong
    }

    // create method
    public function testCreateUsingQueryBuilder()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category"
        ];

        // $category = Category::query()->create($request);
        $category = Category::create($request); // create method, harus ada create untuk create data

        self::assertNotNull($category->id);
    }

    // update model
    public function testUpdateMass()
    {
        $this->seed(CategorySeeder::class);

        // dari request
        $request = [
            // ambil dari name dan description
            "name" => "Food Updated",
            "description" => "Food Category Updated"
        ];

        // data category, temukan dari id 'FOOD'
        $category = Category::find("FOOD");
        $category->fill($request); // fill(attribute) update model, mengisi requestnya
        $category->save(); // simpan data

        self::assertNotNull($category->id); // id tidak boleh kosong
    }

    // Global Scope
    public function testGlobalScope()
    {
        $category = new Category(); // ambil model category
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false; // isactive false
        $category->save(); // simpan data 

        // data categort temukan id 'FOOD'
        $category = Category::find("FOOD");
        self::assertNull($category); // tidak boleh null

        // model category, yang mematikan Global Scope, dari daftar Global Scope yang ingin kita hilangkan
        $category = Category::withoutGlobalScopes([IsActiveScope::class])->find("FOOD");
        self::assertNotNull($category);

        // jadi ada error/bug test gagara code ini!!!
    }

    // one to many
    public function testOneToMany()
    {
        // ambil seeder
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // ambil id FOOD
        $category = Category::find("FOOD");
        self::assertNotNull($category); // tidak kosong

        // $products = Product::where("category_id", $category->id)->get();
        $products = $category->products; // ambil semua data product

        self::assertNotNull($products); // gak boleh null
        self::assertCount(1, $products); // 2 data yg diharapkan
    }

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
