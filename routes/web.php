<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalInquiryController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/'.config('business.default_locale'));
});

Route::prefix('{locale}')
    ->whereIn('locale', ['id', 'en'])
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', HomeController::class)->name('home');
        Route::post('/rental-inquiry', RentalInquiryController::class)->name('rental-inquiry');
    });

Route::get('/sitemap.xml', function () {
    return response()
        ->view('pages.sitemap', ['urls' => \App\Support\Seo::sitemapUrls()])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// Nginx serves the static file in production; this route covers tests (PRD §21.2).
Route::get('/robots.txt', function () {
    return response(file_get_contents(public_path('robots.txt')))
        ->header('Content-Type', 'text/plain');
});

