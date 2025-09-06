@extends('layouts.app') {{-- Расширяем наш базовый макет --}}

@section('title', 'Контакты') {{-- Устанавливаем заголовок страницы --}}

@section('content')
    <!-- Contact Hero Section -->
    <section class="relative bg-cover bg-center h-64 md:h-80 flex items-center justify-center text-white" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $contactHeroImageSetting && $contactHeroImageSetting->getFirstMediaUrl('value') ? $contactHeroImageSetting->getFirstMediaUrl('value') : 'https://images.unsplash.com/photo-1528747045269-390fe33c19f2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80' }}');">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ getSetting('contact_hero_title', 'Свяжитесь с нами') }}</h1>
            <p class="text-xl md:text-2xl max-w-2xl mx-auto">{{ getSetting('contact_hero_subtitle', 'Мы всегда готовы ответить на ваши вопросы и помочь спланировать идеальное путешествие.') }}</p>
        </div>
    </section>

    <!-- Contact Details and Form Section -->
    <section class="py-16 bg-cream">
        <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Details -->
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8">{{ getSetting('contact_details_title', 'Наши контакты') }}</h2>
                <div class="space-y-6 text-lg text-gray-700">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-brown-600 text-2xl mr-4 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800">Адрес офиса:</h3>
                            <p>{{ getSetting('footer_address', 'Кыргызстан, г. Бишкек, ул. Ибраимова, 103') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-brown-600 text-2xl mr-4"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800">Телефон:</h3>
                            <p>{{ getSetting('footer_phone', '+996 (XXX) XXX-XXX') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-brown-600 text-2xl mr-4"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800">Email:</h3>
                            <p>{{ getSetting('footer_email', 'info@novatravel.kg') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-brown-600 text-2xl mr-4"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ getSetting('contact_working_hours_title', 'Часы работы:') }}</h3>
                            <p>{{ getSetting('contact_working_hours_text_mon_fri', 'Пн-Пт: 9:00 - 18:00') }}</p>
                            <p>{{ getSetting('contact_working_hours_text_sat', 'Сб: 10:00 - 15:00') }}</p>
                            <p>{{ getSetting('contact_working_hours_text_sun', 'Вс: Выходной') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Map (Google Maps Embed) -->
                <div class="mt-12 bg-white rounded-xl shadow-lg overflow-hidden">
                    <iframe
                        src="{{ getSetting('contact_map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2923.636657805193!2d74.6033994157813!3d42.87699317915509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x389eb79667f5b355%3A0x6b8c8d8c8d8c8d8c!2z0YPQu9C40YbQsCDQkdC40YDQtdC60LDRgNC-0LLQsCwgMTAz!5e0!3m2!1sru!2skg!4v1678890000000!5m2=1sru!2skg') }}"
                        width="100%"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8">{{ getSetting('contact_form_title', 'Отправьте нам сообщение') }}</h2>
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                        @csrf {{-- Токен CSRF для безопасности --}}
                        <input type="hidden" name="type" value="contact_form"> {{-- Скрытое поле для типа запроса --}}

                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Ваше имя:</label>
                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" placeholder="Иван Иванов" required>
                        </div>
                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Ваш Email:</label>
                            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" placeholder="ivan@example.com" required>
                        </div>
                        <div class="mb-6">
                            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Ваш телефон (опционально):</label>
                            <input type="tel" name="phone" id="phone" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" placeholder="+996 (XXX) XXX-XXX">
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Сообщение:</label>
                            <textarea name="message" id="message" rows="6" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" placeholder="Напишите ваше сообщение здесь..." required></textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline transition duration-300">
                                Отправить сообщение
                            </button>
                        </div>
                    </form>
                    <div id="formMessage" class="mt-4 text-center text-sm font-medium hidden"></div> {{-- Для сообщений об успехе/ошибке --}}
                </div>
            </div>
        </div>
    </section>
@endsection
