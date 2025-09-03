<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run(): void
    { {
            $image = new Image();
            $image->url = "https://www.programmerzamannow.com/image/1.jpg";
            $image->imageable_id = "EKO"; // id dari customer // kolom Polymorphic
            $image->imageable_type = Customer::class;  // pakai FQCN // kolom Polymorphic
            $image->save();
        } {
            $image = new Image();
            $image->url = "https://www.programmerzamannow.com/image/2.jpg";
            $image->imageable_id = "1"; // kolom Polymorphic
            $image->imageable_type = Product::class; // kolom Polymorphic
            $image->save();
        }
    }
}
