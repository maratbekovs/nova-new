@extends('layouts.app') {{-- Расширяем наш базовый макет --}}

@section('title', 'Наши туры') {{-- Устанавливаем заголовок страницы --}}

@section('content')
    <!-- Tours Hero Section -->
    <section class="tours-hero flex items-center justify-center text-white" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $toursHeroImageSetting && $toursHeroImageSetting->getFirstMediaUrl('value') ? $toursHeroImageSetting->getFirstMediaUrl('value') : 'https://images.unsplash.com/photo-1433838552652-f9a46b332c40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80' }}'); background-size: cover; background-position: center; height: 50vh;">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ getSetting('tours_hero_title', 'Наши туры') }}</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">{{ getSetting('tours_hero_subtitle', 'Найдите идеальное путешествие среди более чем 200 туров по всему миру') }}</p>
        </div>
    </section>

    <!-- Tours Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:w-1/4">
                    <form action="{{ route('tours.index') }}" method="GET"> {{-- Форма для фильтров --}}
                        <div class="bg-white p-6 rounded-xl filter-section mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Фильтры</h3>

                            <div class="mb-6">
                                <label for="tour_type" class="block text-gray-700 font-medium mb-2">Тип тура</label>
                                <select name="tour_type" id="tour_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600">
                                    <option value="">Все типы</option>
                                    @foreach($tourTypes as $type) {{-- Динамические типы туров --}}
                                        <option value="{{ $type->name }}" {{ request('tour_type') == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="duration" class="block text-gray-700 font-medium mb-2">Продолжительность</label>
                                <select name="duration" id="duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600">
                                    <option value="">Любая</option>
                                    <option value="3-5" {{ request('duration') == '3-5' ? 'selected' : '' }}>3-5 дней</option>
                                    <option value="7-10" {{ request('duration') == '7-10' ? 'selected' : '' }}>7-10 дней</option>
                                    <option value="10-14" {{ request('duration') == '10-14' ? 'selected' : '' }}>10-14 дней</option>
                                    <option value="14+" {{ request('duration') == '14+' ? 'selected' : '' }}>14+ дней</option>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Цена, руб.</label>
                                <div class="flex items-center space-x-4 mb-2">
                                    <input type="number" name="price_from" placeholder="От" class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600" value="{{ request('price_from') }}">
                                    <input type="number" name="price_to" placeholder="До" class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600" value="{{ request('price_to') }}">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-brown-600 hover:bg-brown-700 text-white py-3 rounded-lg font-medium transition duration-300 filter-button">
                                Применить фильтры
                            </button>
                        </div>
                    </form>

                    <div class="bg-white p-6 rounded-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">{{ getSetting('tours_help_title', 'Нужна помощь?') }}</h3>
                        <p class="text-gray-600 mb-4">{{ getSetting('tours_help_description', 'Наши эксперты по путешествиям помогут вам выбрать идеальный тур.') }}</p>
                        <a href="{{ route('contact') }}" class="w-full bg-transparent border-2 border-brown-600 text-brown-600 hover:bg-brown-600 hover:text-white py-2 rounded-lg font-medium transition duration-300 flex items-center justify-center">
                            <i class="fas fa-headset mr-2"></i> Онлайн-консультация
                        </a>
                    </div>
                </div>

                <!-- Tours List -->
                <div class="lg:w-3/4">
                    <div class="bg-white p-6 rounded-xl mb-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Все туры</h2>
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700">Сортировать:</span>
                                <select name="sort_by" id="sort_by" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600">
                                    <option value="popularity" {{ request('sort_by') == 'popularity' ? 'selected' : '' }}>По популярности</option>
                                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>По цене (сначала дешевые)</option>
                                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>По цене (сначала дорогие)</option>
                                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>По дате (сначала новые)</option>
                                    <option value="rating" {{ request('sort_by') == 'rating' ? 'selected' : '' }}>По рейтингу</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tour Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @forelse($tours as $tour)
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
                                <p class="text-2xl font-semibold mb-4">Туры не найдены.</p>
                                <p>Попробуйте изменить параметры фильтрации.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-8">
                        {{ $tours->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-cream">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ getSetting('tours_why_choose_us_title', 'Почему выбирают наши туры') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ getSetting('tours_why_choose_us_subtitle', 'Мы предлагаем уникальные преимущества, которые делают наши туры особенными') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('tours_why_choose_us_1_icon', 'fas fa-shield-alt') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('tours_why_choose_us_1_title', 'Безопасность') }}</h3>
                    <p class="text-gray-600">{{ getSetting('tours_why_choose_us_1_description', 'Все наши партнеры проверены, отели имеют высокие стандарты безопасности, а гиды проходят специальную подготовку.') }}</p>
                </div>

                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('tours_why_choose_us_2_icon', 'fas fa-wallet') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('tours_why_choose_us_2_title', 'Гарантия лучшей цены') }}</h3>
                    <p class="text-gray-600">{{ getSetting('tours_why_choose_us_2_description', 'Мы гарантируем лучшие цены на рынке. Если найдете такой же тур дешевле - вернем разницу!') }}</p>
                </div>

                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('tours_why_choose_us_3_icon', 'fas fa-star') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('tours_why_choose_us_3_title', 'Эксклюзивные программы') }}</h3>
                    <p class="text-gray-600">{{ getSetting('tours_why_choose_us_3_description', 'Мы разрабатываем уникальные маршруты и экскурсии, которые вы не найдете у других туроператоров.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-brown-600 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Не нашли подходящий тур?</h2>
                <p class="text-xl mb-8 opacity-90">Оставьте свои контакты, и мы подберем для вас идеальное путешествие с учетом всех ваших пожеланий</p>

                <form action="#" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                    @csrf
                    <input type="text" name="name" placeholder="Ваше имя" class="flex-grow px-6 py-3 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-brown-500" required>
                    <input type="email" name="email" placeholder="Ваш email" class="flex-grow px-6 py-3 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-brown-500" required>
                    <input type="tel" name="phone" placeholder="Ваш телефон (опционально)" class="flex-grow px-6 py-3 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-brown-500">
                </form>
                <div class="mt-4 max-w-xl mx-auto">
                    <button type="submit" class="w-full bg-white hover:bg-gray-100 text-brown-600 px-8 py-3 rounded-full font-medium transition duration-300">
                        Отправить запрос
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortBySelect = document.getElementById('sort_by');
        if (sortBySelect) {
            sortBySelect.addEventListener('change', function() {
                this.closest('form').submit();
            });
        }

        document.querySelectorAll('.tour-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });
        });

        const tourInquiryForm = document.querySelector('.newsletter form');
        if (tourInquiryForm) {
            tourInquiryForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('type', 'tour_inquiry');

                fetch('{{ route('contact.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Ваш запрос успешно отправлен! Мы свяжемся с вами в ближайшее время.');
                        tourInquiryForm.reset();
                    } else {
                        alert('Произошла ошибка при отправке запроса. Пожалуйста, попробуйте еще раз.');
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при отправке запроса. Пожалуйста, попробуйте еще раз.');
                });
            });
        }
    });
</script>
@endsection
