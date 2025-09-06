<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Souvenir;
use App\Models\Review;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Получаем все настройки сайта (для getSetting() в Blade)
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // Получаем объект настройки для Hero-изображения
        $homeHeroImageSetting = SiteSetting::where('key', 'home_hero_image')->first();

        // Получаем несколько популярных туров
        $featuredTours = Tour::where('is_active', true)
                            ->where('is_featured', true)
                            ->with('tourType')
                            ->orderBy('rating', 'desc')
                            ->limit(3)
                            ->get();

        // Получаем несколько популярных сувениров
        $featuredSouvenirs = Souvenir::where('is_active', true)
                                    ->where('is_featured', true)
                                    ->with('souvenirCategory')
                                    ->orderBy('rating', 'desc')
                                    ->limit(4)
                                    ->get();

        // Получаем последние 3 одобренных отзыва для отображения на главной
        $recentReviews = Review::where('is_approved', true)
                               ->latest()
                               ->take(3)
                               ->with('reviewable')
                               ->get();

        return view('home.index', compact('featuredTours', 'featuredSouvenirs', 'recentReviews', 'settings', 'homeHeroImageSetting'));
    }
}

