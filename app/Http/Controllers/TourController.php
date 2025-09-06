<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourType;
use App\Models\SiteSetting; // Импортируем SiteSetting
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $tourTypes = TourType::all();
        $query = Tour::where('is_active', true)->with('tourType');

        // Получаем объект настройки для Hero-изображения страницы туров
        $toursHeroImageSetting = SiteSetting::where('key', 'tours_hero_image')->first();


        if ($request->filled('tour_type')) {
            $query->whereHas('tourType', function ($q) use ($request) {
                $q->where('name', $request->input('tour_type'));
            });
        }

        if ($request->filled('duration')) {
            if ($request->input('duration') === '3-5') {
                $query->whereBetween('duration_days', [3, 5]);
            } elseif ($request->input('duration') === '7-10') {
                $query->whereBetween('duration_days', [7, 10]);
            } elseif ($request->input('duration') === '10-14') {
                $query->whereBetween('duration_days', [10, 14]);
            } elseif ($request->input('duration') === '14+') {
                $query->where('duration_days', '>=', 14);
            }
        }

        if ($request->filled('price_from')) {
            $query->where('price', '>=', $request->input('price_from'));
        }

        if ($request->filled('price_to')) {
            $query->where('price', '<=', $request->input('price_to'));
        }

        $sortBy = $request->input('sort_by', 'popularity');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
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

        $tours = $query->paginate(6);

        return view('tours.index', compact('tours', 'tourTypes', 'toursHeroImageSetting'));
    }

    public function show(Tour $tour)
    {
        $tour->load(['reviews' => function ($query) {
            $query->where('is_approved', true)->latest();
        }]);
        return view('tours.show', compact('tour'));
    }
}

