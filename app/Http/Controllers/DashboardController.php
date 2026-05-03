<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\Warehouse;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers  = Supplier::count();
        $totalWarehouses = Warehouse::count();

        // Products where total stock < minimum_stock
        $lowStockProducts = Product::with(['category', 'stocks'])
            ->where('is_active', true)
            ->get()
            ->filter(fn (Product $product) => $product->isLowStock())
            ->take(10);

        // Latest 10 stock movements
        $recentMovements = StockMovement::with(['product', 'warehouse', 'creator'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalWarehouses',
            'lowStockProducts',
            'recentMovements',
        ));
    }
}
