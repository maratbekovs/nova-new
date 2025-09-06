<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use App\Models\Review;
use App\Models\SiteSetting; // Импортируем SiteSetting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        // Получаем объект настройки для Hero-изображения страницы контактов
        $contactHeroImageSetting = SiteSetting::where('key', 'contact_hero_image')->first();

        return view('contact.index', compact('contactHeroImageSetting'));
    }

    /**
     * Store a new contact request or a review.
     */
    public function store(Request $request)
    {
        $type = $request->input('type', 'contact_form');

        // Валидация для общего контактного запроса или подписки
        if (in_array($type, ['contact_form', 'tour_inquiry', 'newsletter'])) {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:255',
                'message' => 'nullable|string',
                'type' => 'nullable|string|in:tour_inquiry,newsletter,contact_form',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            ContactRequest::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'message' => $request->input('message'),
                'type' => $type,
            ]);

            return response()->json(['success' => true, 'message' => 'Ваш запрос успешно отправлен!']);
        }
        // Валидация для отзыва
        elseif ($type === 'review') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'message' => 'required|string',
                'reviewable_type' => 'required|string',
                'reviewable_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            Review::create([
                'author_name' => $request->input('name'),
                'text' => $request->input('message'),
                'rating' => $request->input('rating'),
                'reviewable_type' => $request->input('reviewable_type'),
                'reviewable_id' => $request->input('reviewable_id'),
                'is_approved' => false,
            ]);

            return response()->json(['success' => true, 'message' => 'Ваш отзыв успешно отправлен на модерацию!']);
        }

        return response()->json(['success' => false, 'message' => 'Неизвестный тип запроса.'], 400);
    }
}

