<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        $products = Product::query()->homePage()->get();
        $categories = Category::query()->homePage()->get();
        $brands = Brand::query()->homePage()->get();

        return view('home', compact('products', 'categories', 'brands'));
    }
}
