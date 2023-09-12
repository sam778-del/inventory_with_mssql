<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\{
    HomeController,
    InventoryController,
    ListaController,
    DocumentiController,
    DocumentiddrController,
    DocumentiddvController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


require __DIR__ . '/auth.php';
Route::get('/check/connection', function() {
    return User::limit(10)->get();
});

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(["auth"]);

// inventory section
Route::resource('inventory', InventoryController::class);
Route::get("/get-inventory", [InventoryController::class, "datatables"])
        ->middleware('auth')
        ->name("inventory.datatables");
Route::post("/get-inventory-barcode", [InventoryController::class, "getDataByBarcode"])
        ->middleware('auth')
        ->name("inventory.barcode_data");
Route::post("/check-if-exist", [InventoryController::class, "checkIfExists"])
        ->middleware("auth")
        ->name("inventory.check_if_exists");
Route::post("/update-if-exist", [InventoryController::class, 'updateIfExists'])
        ->middleware("auth")
        ->name('inventory.update_if_exists');

Route::resource('lista', ListaController::class);
Route::get("/get-lista", [ListaController::class, "datatables"])
        ->middleware('auth')
        ->name("lista.datatables");
Route::get("/get-back", [ListaController::class, "backView"])
        ->middleware('auth')
        ->name("lista.back");

Route::resource("documenti", DocumentiController::class);
Route::get("/get-fatura", [DocumentiController::class, 'searchFatura'])
        ->middleware('auth')
        ->name("fatura.search");

Route::resource("documenti_ddr", DocumentiddrController::class);
Route::get("/get-fatura-ddr", [DocumentiddrController::class, 'searchFatura'])
        ->middleware('auth')
        ->name("fatura.search.ddr");

Route::resource("documenti_ddv", DocumentiddvController::class);
Route::get("/get-fatura-ddv", [DocumentiddvController::class, 'searchFatura'])
        ->middleware('auth')
        ->name("fatura.search.ddv");
