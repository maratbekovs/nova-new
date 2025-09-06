<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\SouvenirController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController; // Импортируем CartController
use Illuminate\Support\Facades\DB;

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

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Маршруты для туров
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');

// Маршруты для сувениров
Route::get('/souvenirs', [SouvenirController::class, 'index'])->name('souvenirs.index');
Route::get('/souvenirs/{souvenir}', [SouvenirController::class, 'show'])->name('souvenirs.show');

// Маршруты для страницы "О нас"
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Маршруты для страницы "Контакты"
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Маршрут для обработки контактных запросов (формы на страницах туров, сувениров, главной и контактов)
Route::post('/contact-request', [ContactController::class, 'store'])->name('contact.store');

// Маршруты для Корзины
Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/get', [CartController::class, 'getCart'])->name('cart.get');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/clear', [CartController::class, 'clearCart'])->name('cart.clear'); // Для отладки
});

Route::get('/clear-sessions', function () {
    DB::table('sessions')->truncate();
    return 'Sessions cleared!';
});