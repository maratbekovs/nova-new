@extends('layouts.app') {{-- Расширяем наш базовый макет --}}

@section('title', 'Сувениры из путешествий') {{-- Устанавливаем заголовок страницы --}}

@section('content')
    <!-- Souvenirs Hero Section -->
    <section class="souvenirs-hero flex items-center justify-center text-white" style="background-image: linear-gradient(rgba(93, 64, 55, 0.7), rgba(93, 64, 55, 0.7)), url('{{ $souvenirsHeroImageSetting && $souvenirsHeroImageSetting->getFirstMediaUrl('value') ? $souvenirsHeroImageSetting->getFirstMediaUrl('value') : 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80' }}'); background-size: cover; background-position: center; height: 50vh;">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ getSetting('souvenirs_hero_title', 'Сувениры из путешествий') }}</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">{{ getSetting('souvenirs_hero_subtitle', 'Частичка каждого уголка мира - в вашем доме') }}</p>
        </div>
    </section>

    <!-- Souvenirs Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:w-1/4">
                    <form action="{{ route('souvenirs.index') }}" method="GET"> {{-- Форма для фильтров --}}
                        <div class="bg-white p-6 rounded-xl filter-section mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Фильтры</h3>

                            <div class="mb-6">
                                <label for="category" class="block text-gray-700 font-medium mb-2">Категория</label>
                                <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600">
                                    <option value="">Все категории</option>
                                    @foreach($souvenirCategories as $cat)
                                        <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Цена, руб.</label>
                                <div class="flex items-center space-x-4 mb-2">
                                    <input type="number" name="price_from" placeholder="От" class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600" value="{{ request('price_from', 0) }}">
                                    <input type="number" name="price_to" placeholder="До" class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600" value="{{ request('price_to', 5000) }}">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Рейтинг</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="rating" value="5" class="rounded text-brown-600" {{ request('rating') == '5' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="rating" value="4" class="rounded text-brown-600" {{ request('rating') == '4' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-gray-300"></i>
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="rating" value="3" class="rounded text-brown-600" {{ request('rating') == '3' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-accent-gold"></i>
                                            <i class="fas fa-star text-gray-300"></i>
                                            <i class="fas fa-star text-gray-300"></i>
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="rating" value="" class="rounded text-brown-600" {{ !request('rating') ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Все рейтинги</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-brown-600 hover:bg-brown-700 text-white py-3 rounded-lg font-medium transition duration-300 filter-button">
                                Применить фильтры
                            </button>
                        </div>
                    </form>

                    <div class="bg-white p-6 rounded-xl mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Категории</h3>
                        <ul class="space-y-3">
                            @foreach($souvenirCategories as $cat)
                                <li class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <a href="{{ route('souvenirs.index', ['category' => $cat->name]) }}" class="text-gray-700 hover:text-brown-600">{{ $cat->name }}</a>
                                    <span class="bg-brown-100 text-brown-700 px-2 py-1 rounded-full text-xs">{{ $cat->souvenirs_count ?? 0 }}</span>
                                </li>
                            @endforeach
                            <li class="flex items-center justify-between py-2">
                                <a href="{{ route('souvenirs.index') }}" class="text-gray-700 hover:text-brown-600">Все категории</a>
                                <span class="bg-brown-100 text-brown-700 px-2 py-1 rounded-full text-xs">{{ \App\Models\Souvenir::where('is_active', true)->count() }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white p-6 rounded-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">{{ getSetting('souvenirs_special_offer_title', 'Специальное предложение') }}</h3>
                        <div class="border border-brown-600 rounded-lg p-4 text-center">
                            <p class="text-brown-700 font-medium mb-2">{{ getSetting('souvenirs_special_offer_description', 'Магниты 6 городов по цене 5!') }}</p>
                            <button class="bg-brown-600 hover:bg-brown-700 text-white px-4 py-2 rounded-lg text-sm">
                                {{ getSetting('souvenirs_special_offer_button_text', 'Купить за 1 990 ₽') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Souvenirs List -->
                <div class="lg:w-3/4">
                    <div class="bg-white p-6 rounded-xl mb-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Все сувениры</h2>
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700">Сортировать:</span>
                                <select name="sort_by" id="sort_by_souvenirs" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-600">
                                    <option value="popularity" {{ request('sort_by') == 'popularity' ? 'selected' : '' }}>По популярности</option>
                                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>По цене (сначала дешевые)</option>
                                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>По цене (сначала дорогие)</option>
                                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>По новизне</option>
                                    <option value="rating" {{ request('sort_by') == 'rating' ? 'selected' : '' }}>По рейтингу</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Categories (можно сделать динамическими, пока статика) -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Популярные категории</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="category-card bg-white rounded-xl overflow-hidden shadow-md" onclick="window.location='{{ route('souvenirs.index', ['category' => 'Магниты']) }}'">
                                <div class="h-32 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80')"></div>
                                <div class="p-4 text-center">
                                    <h4 class="font-medium text-gray-800">Магниты</h4>
                                </div>
                            </div>

                            <div class="category-card bg-white rounded-xl overflow-hidden shadow-md" onclick="window.location='{{ route('souvenirs.index', ['category' => 'Кружки']) }}'">
                                <div class="h-32 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80')"></div>
                                <div class="p-4 text-center">
                                    <h4 class="font-medium text-gray-800">Кружки</h4>
                                </div>
                            </div>

                            <div class="category-card bg-white rounded-xl overflow-hidden shadow-md" onclick="window.location='{{ route('souvenirs.index', ['category' => 'Футболки']) }}'">
                                <div class="h-32 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80')"></div>
                                <div class="p-4 text-center">
                                    <h4 class="font-medium text-gray-800">Футболки</h4>
                                </div>
                            </div>

                            <div class="category-card bg-white rounded-xl overflow-hidden shadow-md" onclick="window.location='{{ route('souvenirs.index', ['category' => 'Украшения']) }}'">
                                <div class="h-32 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1605100804763-247f67b3557e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80')"></div>
                                <div class="p-4 text-center">
                                    <h4 class="font-medium text-gray-800">Украшения</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @forelse($souvenirs as $souvenir) {{-- Цикл по сувенирам из базы данных --}}
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
                        @empty {{-- Если сувениров нет --}}
                            <div class="col-span-full text-center py-12 text-gray-600">
                                <p class="text-2xl font-semibold mb-4">Сувениры не найдены.</p>
                                <p>Попробуйте изменить параметры фильтрации.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-8">
                        {{ $souvenirs->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Our Souvenirs -->
    <section class="py-16 bg-cream">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ getSetting('souvenirs_why_choose_us_title', 'Почему выбирают наши сувениры') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ getSetting('souvenirs_why_choose_us_subtitle', 'Каждый сувенир - это не просто вещь, а частичка впечатлений') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('souvenirs_why_choose_us_1_icon', 'fas fa-globe-asia') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('souvenirs_why_choose_us_1_title', 'Аутентичность') }}</h3>
                    <p class="text-gray-600">{{ getSetting('souvenirs_why_choose_us_1_description', 'Все сувениры привозятся непосредственно из стран происхождения и отражают их культуру.') }}</p>
                </div>

                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('souvenirs_why_choose_us_2_icon', 'fas fa-hands-helping') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('souvenirs_why_choose_us_2_title', 'Поддержка мастеров') }}</h3>
                    <p class="text-gray-600">{{ getSetting('souvenirs_why_choose_us_2_description', 'Покупая наши сувениры, вы поддерживаете местных ремесленников и их традиции.') }}</p>
                </div>

                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('souvenirs_why_choose_us_3_icon', 'fas fa-gift') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('souvenirs_why_choose_us_3_title', 'Идеальный подарок') }}</h3>
                    <p class="text-gray-600">{{ getSetting('souvenirs_why_choose_us_3_description', 'Мы предлагаем подарочную упаковку и открытку с рассказом о сувенире.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials (Отзывы покупателей) -->
    <section class="py-16 bg-brown-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ getSetting('souvenirs_testimonials_title', 'Отзывы покупателей') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ getSetting('souvenirs_testimonials_subtitle', 'Что говорят наши клиенты о сувенирах из путешествий') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $souvenirReviews = \App\Models\Review::where('reviewable_type', \App\Models\Souvenir::class)
                                                            ->where('is_approved', true)
                                                            ->latest()
                                                            ->take(3)
                                                            ->get();
                @endphp

                @forelse($souvenirReviews as $review)
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
                        <p class="text-gray-600">"{{ $review->text }}"</p>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-600">
                        <p>Пока нет отзывов о сувенирах.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-brown-600 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Узнавайте о новых сувенирах первыми!</h2>
                <p class="text-xl mb-8 opacity-90">Подпишитесь на нашу рассылку и получайте эксклюзивные предложения</p>

                <form action="#" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="Ваш email" class="flex-grow px-6 py-3 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-brown-500" required>
                    <button type="submit" class="bg-white hover:bg-gray-100 text-brown-600 px-8 py-3 rounded-full font-medium transition duration-300">
                        Подписаться
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortBySouvenirsSelect = document.getElementById('sort_by_souvenirs');
        if (sortBySouvenirsSelect) {
            sortBySouvenirsSelect.addEventListener('change', function() {
                this.closest('form').submit();
            });
        }

        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });
        });

        const newsletterForm = document.querySelector('section.bg-brown-600 form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('type', 'newsletter');

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
                        alert('Вы успешно подписались на рассылку!');
                        newsletterForm.reset();
                    } else {
                        alert('Произошла ошибка при подписке. Пожалуйста, попробуйте еще раз.');
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при подписке. Пожалуйста, попробуйте еще раз.');
                });
            });
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const quantity = 1;
                addToCart(id, quantity);
            });
        });

        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const url = this.getAttribute('onclick').match(/window.location='(.*?)'/)[1];
                if (url) {
                    window.location.href = url;
                }
            });
        });
    });
</script>
@endsection
