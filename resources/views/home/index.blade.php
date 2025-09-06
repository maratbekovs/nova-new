@extends('layouts.app') {{-- Расширяем наш базовый макет --}}

@section('title', 'Главная') {{-- Устанавливаем заголовок страницы --}}

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-screen flex items-center justify-center text-white" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $homeHeroImageSetting && $homeHeroImageSetting->getFirstMediaUrl('value') ? $homeHeroImageSetting->getFirstMediaUrl('value') : 'https://placehold.co/1920x1080/f0e4dd/3b2c28?text=Нет+изображения' }}');">
        <div class="text-center px-4">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fadeInUp">{{ getSetting('home_hero_title', 'Откройте для себя мир с Nova Travel') }}</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto animate-fadeInUp delay-200">{{ getSetting('home_hero_subtitle', 'Ваше незабываемое приключение начинается здесь, в самом сердце Кыргызстана.') }}</p>
            <div class="space-x-4 animate-fadeInUp delay-400">
                <a href="{{ route('tours.index') }}" class="bg-brown-600 hover:bg-brown-700 text-white px-8 py-3 rounded-full text-lg font-semibold transition duration-300 shadow-lg">Наши туры</a>
                <a href="{{ route('contact') }}" class="bg-white hover:bg-gray-100 text-brown-600 px-8 py-3 rounded-full text-lg font-semibold transition duration-300 shadow-lg">Связаться с нами</a>
            </div>
        </div>
    </section>

    <!-- About Us Section (Краткая информация) -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">О Nova Travel</h2>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto mb-8">
                {{ getSetting('home_about_us_short', 'Nova Travel - ваш надежный партнер в мире путешествий. Мы предлагаем уникальные туры по Кыргызстану и всему миру, а также эксклюзивные сувениры, которые станут прекрасным напоминанием о ваших приключениях. Наша миссия - сделать каждое ваше путешествие незабываемым и комфортным.') }}
            </p>
            <a href="{{ route('about') }}" class="text-brown-600 hover:underline font-medium">Узнать больше о нас <i class="fas fa-arrow-right ml-2 text-sm"></i></a>
        </div>
    </section>

    <!-- Featured Tours Section -->
    <section class="py-16 bg-cream">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ getSetting('home_featured_tours_title', 'Популярные туры') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ getSetting('home_featured_tours_subtitle', 'Откройте для себя наши самые востребованные направления и приключения') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredTours as $tour)
                    <div class="tour-card bg-white rounded-xl overflow-hidden shadow-md transition duration-300">
                        <div class="relative card-image">
                            {{-- Исправлено: убран дублирующий 'tour-images/' --}}
                            <img src="{{ $tour->image_url ? asset('uploads/' . $tour->image_url) : 'https://placehold.co/800x480/f0e4dd/3b2c28?text=Нет+изображения' }}" alt="{{ $tour->title }}" class="w-full h-48 object-cover">
                            @if($tour->is_discounted)
                                <div class="absolute top-4 right-4 bg-brown-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    -{{ round((($tour->price - $tour->discount_price) / $tour->price) * 100) }}%
                                </div>
                            @elseif($tour->is_featured)
                                <div class="absolute top-4 right-4 bg-brown-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    Хит
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-800">{{ $tour->title }}</h3>
                                @if($tour->rating)
                                    <div class="flex items-center bg-brown-100 px-2 py-1 rounded">
                                        <i class="fas fa-star text-accent-gold text-sm mr-1"></i>
                                        <span class="text-brown-700 text-sm font-medium">{{ number_format($tour->rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <p class="text-gray-700 mb-4">{{ Str::limit($tour->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <div>
                                    @if($tour->is_discounted && $tour->discount_price)
                                        <span class="block text-gray-500 text-sm line-through">{{ number_format($tour->price, 0, '.', ' ') }} руб.</span>
                                        <span class="text-xl font-bold text-brown-600">{{ number_format($tour->discount_price, 0, '.', ' ') }} руб.</span>
                                    @else
                                        <span class="text-xl font-bold text-brown-600">{{ number_format($tour->price, 0, '.', ' ') }} руб.</span>
                                    @endif
                                </div>
                                <a href="{{ route('tours.show', $tour->id) }}" class="bg-brown-600 hover:bg-brown-700 text-white px-4 py-2 rounded-lg transition duration-300">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-600">
                        <p class="text-2xl font-semibold mb-4">Популярные туры пока не добавлены.</p>
                        <p>Добавьте туры и отметьте их как "Хит продаж" в админ-панели.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('tours.index') }}" class="bg-brown-600 hover:bg-brown-700 text-white px-8 py-3 rounded-full text-lg font-semibold transition duration-300 shadow-lg">Посмотреть все туры</a>
            </div>
        </div>
    </section>

    <!-- Featured Souvenirs Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ getSetting('home_featured_souvenirs_title', 'Популярные сувениры') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ getSetting('home_featured_souvenirs_subtitle', 'Найдите уникальные сувениры, чтобы сохранить воспоминания о путешествиях') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @forelse($featuredSouvenirs as $souvenir)
                    <div class="product-card bg-white rounded-xl overflow-hidden shadow-md transition duration-300">
                        <div class="relative product-image">
                            {{-- Исправлено: убран дублирующий 'souvenir-images/' --}}
                            <img src="{{ $souvenir->image_url ? asset('uploads/' . $souvenir->image_url) : 'https://placehold.co/800x480/f0e4dd/3b2c28?text=Нет+изображения' }}" alt="{{ $souvenir->title }}" class="w-full h-48 object-cover">
                            @if($souvenir->is_discounted)
                                <div class="absolute top-4 right-4 bg-brown-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    -{{ round((($souvenir->price - $souvenir->discount_price) / $souvenir->price) * 100) }}%
                                </div>
                            @elseif($souvenir->is_featured)
                                <div class="absolute top-4 right-4 bg-brown-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    Хит
                                </div>
                            @elseif($souvenir->is_new)
                                <div class="absolute top-4 right-4 bg-brown-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    Новинка
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-800">{{ $souvenir->title }}</h3>
                                @if($souvenir->rating)
                                    <div class="flex items-center bg-brown-100 px-2 py-1 rounded">
                                        <i class="fas fa-star text-accent-gold text-sm mr-1"></i>
                                        <span class="text-brown-700 text-sm font-medium">{{ number_format($souvenir->rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <div>
                                    @if($souvenir->is_discounted && $souvenir->discount_price)
                                        <span class="block text-gray-500 text-sm line-through">{{ number_format($souvenir->price, 0, '.', ' ') }} руб.</span>
                                        <span class="text-xl font-bold text-brown-600">{{ number_format($souvenir->discount_price, 0, '.', ' ') }} руб.</span>
                                    @else
                                        <span class="text-xl font-bold text-brown-600">{{ number_format($souvenir->price, 0, '.', ' ') }} руб.</span>
                                    @endif
                                </div>
                                <button class="add-to-cart bg-brown-600 hover:bg-brown-700 text-white px-4 py-2 rounded-lg transition duration-300"
                                        data-id="{{ $souvenir->id }}"
                                        data-name="{{ $souvenir->title }}"
                                        data-price="{{ $souvenir->is_discounted && $souvenir->discount_price ? $souvenir->discount_price : $souvenir->price }}">
                                    В корзину
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-600">
                        <p class="text-2xl font-semibold mb-4">Популярные сувениры пока не добавлены.</p>
                        <p>Добавьте сувениры и отметьте их как "Хит продаж" в админ-панели.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('souvenirs.index') }}" class="bg-brown-600 hover:bg-brown-700 text-white px-8 py-3 rounded-full text-lg font-semibold transition duration-300 shadow-lg">Посмотреть все сувениры</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 bg-cream">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ getSetting('home_why_choose_us_title', 'Почему выбирают Nova Travel') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ getSetting('home_why_choose_us_subtitle', 'Мы предлагаем уникальные преимущества, которые делают наши услуги особенными') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('home_why_choose_us_1_icon', 'fas fa-map-signs') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('home_why_choose_us_1_title', 'Индивидуальные маршруты') }}</h3>
                    <p class="text-gray-600">{{ getSetting('home_why_choose_us_1_description', 'Мы создаем туры, идеально соответствующие вашим пожеланиям и интересам.') }}</p>
                </div>

                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('home_why_choose_us_2_icon', 'fas fa-headset') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('home_why_choose_us_2_title', 'Поддержка 24/7') }}</h3>
                    <p class="text-gray-600">{{ getSetting('home_why_choose_us_2_description', 'Наши менеджеры всегда на связи, чтобы помочь вам в любой ситуации.') }}</p>
                </div>

                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('home_why_choose_us_3_icon', 'fas fa-handshake') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('home_why_choose_us_3_title', 'Надежность и опыт') }}</h3>
                    <p class="text-gray-600">{{ getSetting('home_why_choose_us_3_description', 'Более 10 лет на рынке туризма, тысячи довольных клиентов.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section (Отзывы) -->
    <section class="py-16 bg-brown-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ getSetting('home_testimonials_title', 'Что говорят наши клиенты') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ getSetting('home_testimonials_subtitle', 'Отзывы о наших турах и сувенирах') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($recentReviews as $review)
                    <div class="bg-white p-6 rounded-xl shadow-sm">
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
                        <p class="text-gray-600">"{{ Str::limit($review->text, 150) }}"</p>
                        @if($review->reviewable)
                            <p class="text-sm text-gray-500 mt-2">
                                О:
                                @if($review->reviewable_type === \App\Models\Tour::class)
                                    <a href="{{ route('tours.show', $review->reviewable->id) }}" class="hover:underline">{{ $review->reviewable->title }}</a> (Тур)
                                @elseif($review->reviewable_type === \App\Models\Souvenir::class)
                                    <a href="{{ route('souvenirs.show', $review->reviewable->id) }}" class="hover:underline">{{ $review->reviewable->title }}</a> (Сувенир)
                                @endif
                            </p>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-600">
                        <p>Пока нет отзывов.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action / Newsletter -->
    <section class="py-16 bg-brown-600 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Готовы к приключениям?</h2>
                <p class="text-xl mb-8 opacity-90">Подпишитесь на нашу рассылку, чтобы получать эксклюзивные предложения и новости о новых турах!</p>

                <form action="{{ route('contact.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="Ваш email" class="flex-grow px-6 py-3 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-brown-500" required>
                    <input type="hidden" name="type" value="newsletter">
                    <button type="submit" class="bg-white hover:bg-gray-100 text-brown-600 px-8 py-3 rounded-full font-medium transition duration-300">
                        Подписаться
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
