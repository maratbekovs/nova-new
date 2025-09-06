@extends('layouts.app') {{-- Расширяем наш базовый макет --}}

@section('title', 'О нас') {{-- Устанавливаем заголовок страницы --}}

@section('content')
    <!-- About Us Hero Section -->
    <section class="relative bg-cover bg-center h-64 md:h-80 flex items-center justify-center text-white" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $aboutHeroImageSetting && $aboutHeroImageSetting->getFirstMediaUrl('value') ? $aboutHeroImageSetting->getFirstMediaUrl('value') : 'https://images.unsplash.com/photo-1517760447192-bd1318029a70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80' }}');">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ getSetting('about_hero_title', 'О компании Nova Travel') }}</h1>
            <p class="text-xl md:text-2xl max-w-2xl mx-auto">{{ getSetting('about_hero_subtitle', 'Ваш надежный партнер в мире незабываемых путешествий') }}</p>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="lg:order-2">
                @php
                    $aboutOurStoryImageSetting = \App\Models\SiteSetting::where('key', 'about_our_story_image')->first();
                    $aboutOurStoryImageUrl = $aboutOurStoryImageSetting && $aboutOurStoryImageSetting->getFirstMediaUrl('value') ? $aboutOurStoryImageSetting->getFirstMediaUrl('value') : 'https://images.unsplash.com/photo-1542037101-78939c148301?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80';
                @endphp
                <img src="{{ $aboutOurStoryImageUrl }}" alt="Nova Travel Team" class="rounded-xl shadow-lg w-full h-auto">
            </div>
            <div class="lg:order-1">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">{{ getSetting('about_our_story_title', 'Наша история и миссия') }}</h2>
                <p class="text-lg text-gray-700 mb-4">
                    {{ getSetting('about_us_full', 'Компания Nova Travel была основана в 2010 году в Кыргызстане с одной простой целью: сделать путешествия доступными, безопасными и незабываемыми для каждого. Мы верим, что каждое путешествие – это не просто смена обстановки, а возможность открыть для себя что-то новое, получить бесценный опыт и создать воспоминания на всю жизнь. За эти годы мы выросли из небольшого местного агентства в крупного туроператора, предлагающего широкий спектр услуг: от экзотических пляжных туров до захватывающих приключений в горах Кыргызстана, а также уникальные сувениры со всего мира. Мы гордимся нашей командой профессионалов, которые любят свое дело и готовы приложить все усилия, чтобы ваш отдых был идеальным. Наша миссия – вдохновлять людей на путешествия, предоставляя высококачественные услуги и индивидуальный подход к каждому клиенту. Мы стремимся превзойти ваши ожидания и сделать каждое путешествие с Nova Travel по-настоящему особенным.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="py-16 bg-cream">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-12">{{ getSetting('about_our_values_title', 'Наши ценности') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('about_our_values_1_icon', 'fas fa-heart') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('about_our_values_1_title', 'Страсть к путешествиям') }}</h3>
                    <p class="text-gray-600">{{ getSetting('about_our_values_1_description', 'Мы сами любим путешествовать и делимся этой страстью с нашими клиентами.') }}</p>
                </div>
                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('about_our_values_2_icon', 'fas fa-users') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('about_our_values_2_title', 'Клиентоориентированность') }}</h3>
                    <p class="text-gray-600">{{ getSetting('about_our_values_2_description', 'Ваши пожелания и комфорт - наш главный приоритет.') }}</p>
                </div>
                <div class="bg-white p-8 rounded-xl text-center hover:shadow-xl transition duration-300">
                    <div class="bg-brown-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ getSetting('about_our_values_3_icon', 'fas fa-leaf') }} text-brown-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ getSetting('about_our_values_3_title', 'Устойчивый туризм') }}</h3>
                    <p class="text-gray-600">{{ getSetting('about_our_values_3_description', 'Мы заботимся о природе и культуре, поддерживая ответственный туризм.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section (Опционально, можно добавить реальных членов команды) -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-12">Наша команда</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @for ($i = 1; $i <= 3; $i++)
                    @php
                        $memberName = getSetting('team_member_' . $i . '_name');
                        $memberRole = getSetting('team_member_' . $i . '_role');
                        $memberDescription = getSetting('team_member_' . $i . '_description');
                        $memberImageSetting = \App\Models\SiteSetting::where('key', 'team_member_' . $i . '_image')->first();
                        $memberImageUrl = $memberImageSetting && $memberImageSetting->getFirstMediaUrl('value') ? $memberImageSetting->getFirstMediaUrl('value') : 'https://placehold.co/150x150/f0e4dd/3b2c28?text=Фото';
                    @endphp
                    @if($memberName)
                        <div class="bg-white p-6 rounded-xl shadow-md text-center">
                            <img src="{{ $memberImageUrl }}" alt="{{ $memberName }}" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $memberName }}</h3>
                            <p class="text-brown-600 font-medium mb-2">{{ $memberRole }}</p>
                            <p class="text-gray-600 text-sm">{{ $memberDescription }}</p>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 bg-brown-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Есть вопросы?</h2>
            <p class="text-xl mb-8 opacity-90">Мы всегда готовы помочь вам спланировать идеальное путешествие.</p>
            <a href="{{ route('contact') }}" class="bg-white hover:bg-gray-100 text-brown-600 px-8 py-3 rounded-full text-lg font-semibold transition duration-300 shadow-lg">Связаться с нами</a>
        </div>
    </section>
@endsection
