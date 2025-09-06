<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting; // Импортируем SiteSetting
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Получаем объект настройки для Hero-изображения страницы "О нас"
        $aboutHeroImageSetting = SiteSetting::where('key', 'about_hero_image')->first();

        return view('about.index', compact('aboutHeroImageSetting'));
    }
}

