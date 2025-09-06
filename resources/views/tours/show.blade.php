@extends('layouts.app') {{-- Расширяем наш базовый макет --}}

@section('title', $tour->title) {{-- Устанавливаем заголовок страницы как название тура --}}

@section('content')
    <section class="py-12 bg-cream">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            <nav class="text-sm text-gray-500 mb-8">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="text-brown-600 hover:underline">Главная</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('tours.index') }}" class="text-brown-600 hover:underline">Туры</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-gray-700">{{ $tour->title }}</span>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 lg:p-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    <!-- Tour Image -->
                    <div class="order-1 lg:order-1">
                        {{-- Исправлено: убран дублирующий 'tour-images/' --}}
                        <img src="{{ $tour->image_url ? asset('uploads/' . $tour->image_url) : 'https://placehold.co/800x600/f0e4dd/3b2c28?text=Нет+изображения' }}" alt="{{ $tour->title }}" class="w-full h-96 object-cover rounded-xl shadow-md">
                    </div>

                    <!-- Tour Details -->
                    <div class="order-2 lg:order-2">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $tour->title }}</h1>

                        <div class="flex items-center mb-4 text-gray-600">
                            @if($tour->rating)
                                <div class="flex items-center bg-brown-100 px-2 py-1 rounded">
                                    <i class="fas fa-star text-accent-gold text-sm mr-1"></i>
                                    <span class="text-brown-700 text-sm font-medium">{{ number_format($tour->rating, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="text-xl font-bold text-brown-600 mb-6">
                            @if($tour->is_discounted && $tour->discount_price)
                                <span class="block text-gray-500 text-base line-through">{{ number_format($tour->price, 0, '.', ' ') }} руб.</span>
                                <span>{{ number_format($tour->discount_price, 0, '.', ' ') }} руб.</span>
                            @else
                                <span>{{ number_format($tour->price, 0, '.', ' ') }} руб.</span>
                            @endif
                        </div>

                        <p class="text-gray-700 leading-relaxed mb-6">
                            {{ $tour->description }}
                        </p>

                        <ul class="space-y-3 text-gray-700 mb-8">
                            <li class="flex items-center">
                                <i class="fas fa-clock text-brown-600 mr-3"></i>
                                <span>Продолжительность: {{ $tour->duration_days }} дней / {{ $tour->duration_nights }} ночей</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-tag text-brown-600 mr-3"></i>
                                <span>Тип тура: {{ $tour->tourType->name }}</span>
                            </li>
                            @if($tour->is_featured)
                                <li class="flex items-center">
                                    <i class="fas fa-fire text-brown-600 mr-3"></i>
                                    <span>Хит продаж!</span>
                                </li>
                            @endif
                            @if($tour->is_discounted)
                                <li class="flex items-center">
                                    <i class="fas fa-percent text-brown-600 mr-3"></i>
                                    <span>Специальное предложение!</span>
                                </li>
                            @endif
                        </ul>

                        <button class="w-full bg-brown-600 hover:bg-brown-700 text-white px-8 py-4 rounded-full text-lg font-semibold transition duration-300 shadow-lg">
                            {{ getSetting('tours_book_button_text', 'Забронировать тур') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tour Reviews Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 text-center">Отзывы о туре</h2>

            @php
                $tourReviews = $tour->reviews()->where('is_approved', true)->latest()->get();
            @endphp

            @forelse($tourReviews as $review)
                <div class="bg-cream p-6 rounded-xl shadow-sm mb-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-gray-300 mr-4 flex items-center justify-center text-gray-600 text-xl font-bold">
                            {{ mb_substr($review->author_name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $review->author_name }}</h4>
                            <div class="flex text-accent-gold">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @for ($i = $review->rating; $i < 5; $i++)
                                    <i class="far fa-star text-gray-300"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">{{ $review->text }}</p>
                    <p class="text-sm text-gray-500 mt-3">Опубликовано: {{ $review->created_at->format('d.m.Y') }}</p>
                </div>
            @empty
                <div class="text-center py-8 text-gray-600">
                    <p>Пока нет отзывов для этого тура.</p>
                </div>
            @endforelse

            {{-- Форма для добавления отзыва --}}
            <div class="mt-12 bg-cream p-8 rounded-xl shadow-lg">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Оставить отзыв</h3>
                <form action="{{ route('contact.store') }}" method="POST"> {{-- Используем тот же контроллер для ContactRequest --}}
                    @csrf
                    <input type="hidden" name="type" value="review"> {{-- Тип запроса: отзыв --}}
                    <input type="hidden" name="reviewable_type" value="{{ \App\Models\Tour::class }}">
                    <input type="hidden" name="reviewable_id" value="{{ $tour->id }}">

                    <div class="mb-6">
                        <label for="review_author_name" class="block text-gray-700 text-sm font-bold mb-2">Ваше имя:</label>
                        <input type="text" name="name" id="review_author_name" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" required>
                    </div>

                    <div class="mb-6">
                        <label for="review_rating" class="block text-gray-700 text-sm font-bold mb-2">Ваша оценка:</label>
                        <select name="rating" id="review_rating" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" required>
                            <option value="5">5 звезд</option>
                            <option value="4">4 звезды</option>
                            <option value="3">3 звезды</option>
                            <option value="2">2 звезды</option>
                            <option value="1">1 звезда</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="review_text" class="block text-gray-700 text-sm font-bold mb-2">Ваш отзыв:</label>
                        <textarea name="message" id="review_text" rows="5" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" required></textarea>
                    </div>

                    <div class="flex items-center justify-center">
                        <button type="submit" class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline transition duration-300">
                            Отправить отзыв
                        </button>
                    </div>
                </form>
                <div id="reviewFormMessage" class="mt-4 text-center text-sm font-medium hidden"></div>
            </div>
        </div>
    </section>

    <!-- Related Tours Section (Опционально) -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 text-center">{{ getSetting('tours_related_title', 'Похожие туры') }}</h2>
            @php
                $relatedTours = \App\Models\Tour::where('is_active', true)
                                                ->where('id', '!=', $tour->id)
                                                ->where('tour_type_id', $tour->tour_type_id)
                                                ->limit(3)
                                                ->get();
            @endphp

            @forelse($relatedTours as $relatedTour)
                <div class="tour-card bg-cream rounded-xl overflow-hidden shadow-md transition duration-300 mb-6">
                    <div class="flex flex-col md:flex-row">
                        <div class="relative w-full md:w-1/3 card-image">
                            {{-- Исправлено: убран дублирующий 'tour-images/' --}}
                            <img src="{{ $relatedTour->image_url ? asset('uploads/' . $relatedTour->image_url) : 'https://placehold.co/800x480/f0e4dd/3b2c28?text=Нет+изображения' }}" alt="{{ $relatedTour->title }}" class="w-full h-48 object-cover">
                            @if($relatedTour->is_discounted)
                                <div class="absolute top-4 right-4 bg-brown-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    -{{ round((($relatedTour->price - $relatedTour->discount_price) / $relatedTour->price) * 100) }}%
                                </div>
                            @elseif($relatedTour->is_featured)
                                <div class="absolute top-4 right-4 bg-brown-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    Хит
                                </div>
                            @endif
                        </div>
                        <div class="p-6 w-full md:w-2/3">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-800">{{ $relatedTour->title }}</h3>
                                @if($relatedTour->rating)
                                    <div class="flex items-center bg-brown-100 px-2 py-1 rounded">
                                        <i class="fas fa-star text-accent-gold text-sm mr-1"></i>
                                        <span class="text-brown-700 text-sm font-medium">{{ number_format($relatedTour->rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <p class="text-gray-700 mb-4">{{ Str::limit($relatedTour->description, 150) }}</p>
                            <div class="flex justify-between items-center">
                                <div>
                                    @if($relatedTour->is_discounted && $relatedTour->discount_price)
                                        <span class="block text-gray-500 text-sm line-through">{{ number_format($relatedTour->price, 0, '.', ' ') }} руб.</span>
                                        <span class="text-xl font-bold text-brown-600">{{ number_format($relatedTour->discount_price, 0, '.', ' ') }} руб.</span>
                                    @else
                                        <span class="text-xl font-bold text-brown-600">{{ number_format($relatedTour->price, 0, '.', ' ') }} руб.</span>
                                    @endif
                                </div>
                                <a href="{{ route('tours.show', $relatedTour->id) }}" class="bg-brown-600 hover:bg-brown-700 text-white px-4 py-2 rounded-lg transition duration-300">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-600">
                        <p>Похожие туры не найдены.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
