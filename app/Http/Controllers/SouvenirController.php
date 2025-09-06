<?php

namespace App\Http\Controllers;

use App\Models\Souvenir;
use App\Models\SouvenirCategory;
use App\Models\SiteSetting; // Импортируем SiteSetting
use Illuminate\Http\Request;

class SouvenirController extends Controller
{
    public function index(Request $request)
    {
        $souvenirCategories = SouvenirCategory::withCount('souvenirs')->get();
        $query = Souvenir::where('is_active', true)->with('souvenirCategory');

        // Получаем объект настройки для Hero-изображения страницы сувениров
        $souvenirsHeroImageSetting = SiteSetting::where('key', 'souvenirs_hero_image')->first();


        if ($request->filled('category')) {
            $query->whereHas('souvenirCategory', function ($q) use ($request) {
                $q->where('name', $request->input('category'));
            });
        }

        if ($request->filled('price_from')) {
            $query->where(function($q) use ($request) {
                $q->where('discount_price', '>=', $request->input('price_from'))
                  ->orWhereNull('discount_price')
                  ->where('price', '>=', $request->input('price_from'));
            });
        }

        if ($request->filled('price_to')) {
            $query->where(function($q) use ($request) {
                $q->where('discount_price', '<=', $request->input('price_to'))
                  ->orWhereNull('discount_price')
                  ->where('price', '<=', $request->input('price_to'));
            });
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', (int)$request->input('rating'));
        }

        $sortBy = $request->input('sort_by', 'popularity');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'popularity':
            default:
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('rating', 'desc')
                      ->orderBy('created_at', 'desc');
                break;
        }

        $souvenirs = $query->paginate(6);

        return view('souvenirs.index', compact('souvenirs', 'souvenirCategories', 'souvenirsHeroImageSetting'));
    }

    public function show(Souvenir $souvenir)
    {
        $souvenir->load(['reviews' => function ($query) {
            $query->where('is_approved', true)->latest();
        }]);
        return view('souvenirs.show', compact('souvenir'));
    }
}

