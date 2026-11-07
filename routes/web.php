<?php

use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\DemoLoginController;
use App\Http\Controllers\Web\DemoRequestController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LocaleController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\RfqBoardController;
use App\Http\Controllers\Web\SitemapController;
use App\Http\Controllers\Web\SupplierDirectoryController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', function () {
    $path = public_path('robots.txt');
    abort_unless(is_file($path), 404);

    return response(file_get_contents($path), 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
    ]);
})->name('robots');

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');

Route::get('/', HomeController::class)->name('home');

Route::get('/features', [PageController::class, 'features'])->name('features');
Route::get('/modules', [PageController::class, 'modules'])->name('modules');
Route::get('/for-buyers', [PageController::class, 'forBuyers'])->name('for-buyers');
Route::get('/for-suppliers', [PageController::class, 'forSuppliers'])->name('for-suppliers');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how-it-works');
Route::get('/industries', [PageController::class, 'industries'])->name('industries');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/help', [PageController::class, 'help'])->name('help');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');

Route::get('/suppliers', [SupplierDirectoryController::class, 'index'])->name('suppliers.index');
Route::get('/suppliers/{slug}', [SupplierDirectoryController::class, 'show'])->name('suppliers.show');

Route::get('/rfqs', [RfqBoardController::class, 'index'])->name('rfqs.index');
Route::get('/rfqs/{slug}', [RfqBoardController::class, 'show'])->name('rfqs.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/demo-request', [DemoRequestController::class, 'create'])->name('demo.request');
Route::post('/demo-request', [DemoRequestController::class, 'store'])->name('demo.request.store');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::middleware('demo')->group(function () {
    Route::get('/try-demo', [DemoLoginController::class, 'index'])->name('demo.try');
    Route::post('/try-demo/{panel}', [DemoLoginController::class, 'login'])->name('demo.login');
});
