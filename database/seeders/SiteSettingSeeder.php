<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting; // Импортируем модель SiteSetting

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Данные для настроек сайта
        $settings = [
            // --- Footer Contacts ---
            [
                'key' => 'footer_phone',
                'value' => '+996 (700) 123-456',
                'description' => 'Телефон компании в футере',
                'type' => 'tel',
            ],
            [
                'key' => 'footer_email',
                'value' => 'info@novatravel.kg',
                'description' => 'Email компании в футере',
                'type' => 'email',
            ],
            [
                'key' => 'footer_address',
                'value' => 'Кыргызстан, г. Бишкек, ул. Ибраимова, 103',
                'description' => 'Адрес компании в футере',
                'type' => 'text',
            ],

            // --- Footer Social Links ---
            [
                'key' => 'footer_facebook_url',
                'value' => 'https://facebook.com/novatravel',
                'description' => 'URL Facebook для футера',
                'type' => 'url',
            ],
            [
                'key' => 'footer_instagram_url',
                'value' => 'https://instagram.com/novatravel',
                'description' => 'URL Instagram для футера',
                'type' => 'url',
            ],
            [
                'key' => 'footer_twitter_url',
                'value' => 'https://twitter.com/novatravel',
                'description' => 'URL Twitter для футера',
                'type' => 'url',
            ],
            [
                'key' => 'footer_youtube_url',
                'value' => 'https://youtube.com/novatravel',
                'description' => 'URL YouTube для футера',
                'type' => 'url',
            ],

            // --- Footer Help Links ---
            [
                'key' => 'footer_delivery_url',
                'value' => '#',
                'description' => 'URL для страницы "Доставка и оплата" в футере',
                'type' => 'url',
            ],
            [
                'key' => 'footer_return_url',
                'value' => '#',
                'description' => 'URL для страницы "Возврат товара" в футере',
                'type' => 'url',
            ],
            [
                'key' => 'footer_faq_url',
                'value' => '#',
                'description' => 'URL для страницы "Вопросы и ответы" в футере',
                'type' => 'url',
            ],

            // --- Footer Policy Links ---
            [
                'key' => 'footer_privacy_policy_url',
                'value' => '#',
                'description' => 'URL для страницы "Политика конфиденциальности" в футере',
                'type' => 'url',
            ],
            [
                'key' => 'footer_terms_url',
                'value' => '#',
                'description' => 'URL для страницы "Условия использования" в футере',
                'type' => 'url',
            ],

            // --- Home Page Content ---
            [
                'key' => 'home_hero_title',
                'value' => 'Откройте для себя мир с Nova Travel',
                'description' => 'Заголовок Hero-секции на главной странице',
                'type' => 'text',
            ],
            [
                'key' => 'home_hero_subtitle',
                'value' => 'Ваше незабываемое приключение начинается здесь, в самом сердце Кыргызстана.',
                'description' => 'Подзаголовок Hero-секции на главной странице',
                'type' => 'text',
            ],
            [
                'key' => 'home_hero_image',
                'value' => 'https://images.unsplash.com/photo-1501785888041-af3ba6f60688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'description' => 'Фоновое изображение Hero-секции на главной странице',
                'type' => 'image', // Новый тип
            ],
            [
                'key' => 'home_about_us_short',
                'value' => 'Nova Travel - ваш надежный партнер в мире путешествий. Мы предлагаем уникальные туры по Кыргызстану и всему миру, а также эксклюзивные сувениры, которые станут прекрасным напоминанием о ваших приключениях. Наша миссия - сделать каждое ваше путешествие незабываемым и комфортным.',
                'description' => 'Краткое описание "О нас" на главной странице',
                'type' => 'textarea',
            ],
            [
                'key' => 'home_featured_tours_title',
                'value' => 'Популярные туры',
                'description' => 'Заголовок секции популярных туров на главной странице',
                'type' => 'text',
            ],
            [
                'key' => 'home_featured_tours_subtitle',
                'value' => 'Откройте для себя наши самые востребованные направления и приключения',
                'description' => 'Подзаголовок секции популярных туров на главной странице',
                'type' => 'text',
            ],
            [
                'key' => 'home_featured_souvenirs_title',
                'value' => 'Популярные сувениры',
                'description' => 'Заголовок секции популярных сувениров на главной странице',
                'type' => 'text',
            ],
            [
                'key' => 'home_featured_souvenirs_subtitle',
                'value' => 'Найдите уникальные сувениры, чтобы сохранить воспоминания о путешествиях',
                'description' => 'Подзаголовок секции популярных сувениров на главной странице',
                'type' => 'text',
            ],
            [
                'key' => 'home_why_choose_us_title',
                'value' => 'Почему выбирают Nova Travel',
                'description' => 'Заголовок секции "Почему выбирают нас" на главной странице',
                'type' => 'text',
            ],
            [
                'key' => 'home_why_choose_us_subtitle',
                'value' => 'Мы предлагаем уникальные преимущества, которые делают наши услуги особенными',
                'type' => 'text',
            ],
            // Home - Why Choose Us points
            [
                'key' => 'home_why_choose_us_1_icon',
                'value' => 'fas fa-map-signs',
                'description' => 'Иконка 1 пункта "Почему выбирают нас" на главной',
                'type' => 'text',
            ],
            [
                'key' => 'home_why_choose_us_1_title',
                'value' => 'Индивидуальные маршруты',
                'description' => 'Заголовок 1 пункта "Почему выбирают нас" на главной',
                'type' => 'text',
            ],
            [
                'key' => 'home_why_choose_us_1_description',
                'value' => 'Мы создаем туры, идеально соответствующие вашим пожеланиям и интересам.',
                'description' => 'Описание 1 пункта "Почему выбирают нас" на главной',
                'type' => 'textarea',
            ],
            [
                'key' => 'home_why_choose_us_2_icon',
                'value' => 'fas fa-headset',
                'description' => 'Иконка 2 пункта "Почему выбирают нас" на главной',
                'type' => 'text',
            ],
            [
                'key' => 'home_why_choose_us_2_title',
                'value' => 'Поддержка 24/7',
                'description' => 'Заголовок 2 пункта "Почему выбирают нас" на главной',
                'type' => 'text',
            ],
            [
                'key' => 'home_why_choose_us_2_description',
                'value' => 'Наши менеджеры всегда на связи, чтобы помочь вам в любой ситуации.',
                'description' => 'Описание 2 пункта "Почему выбирают нас" на главной',
                'type' => 'textarea',
            ],
            [
                'key' => 'home_why_choose_us_3_icon',
                'value' => 'fas fa-handshake',
                'description' => 'Иконка 3 пункта "Почему выбирают нас" на главной',
                'type' => 'text',
            ],
            [
                'key' => 'home_why_choose_us_3_title',
                'value' => 'Надежность и опыт',
                'description' => 'Заголовок 3 пункта "Почему выбирают нас" на главной',
                'type' => 'text',
            ],
            [
                'key' => 'home_why_choose_us_3_description',
                'value' => 'Более 10 лет на рынке туризма, тысячи довольных клиентов.',
                'description' => 'Описание 3 пункта "Почему выбирают нас" на главной',
                'type' => 'textarea',
            ],

            // Home - Testimonials
            [
                'key' => 'home_testimonials_title',
                'value' => 'Что говорят наши клиенты',
                'description' => 'Заголовок секции отзывов на главной странице',
                'type' => 'text',
            ],
            [
                'key' => 'home_testimonials_subtitle',
                'value' => 'Отзывы о наших турах и сувенирах',
                'type' => 'text',
            ],

            // --- About Us Page Content ---
            [
                'key' => 'about_hero_title',
                'value' => 'О компании Nova Travel',
                'description' => 'Заголовок Hero-секции на странице "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'about_hero_subtitle',
                'value' => 'Ваш надежный партнер в мире незабываемых путешествий',
                'type' => 'text',
            ],
            [
                'key' => 'about_hero_image',
                'value' => 'https://images.unsplash.com/photo-1517760447192-bd1318029a70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'description' => 'Фоновое изображение Hero-секции на странице "О нас"',
                'type' => 'image',
            ],
            [
                'key' => 'about_our_story_title',
                'value' => 'Наша история и миссия',
                'description' => 'Заголовок секции "Наша история" на странице "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'about_us_full',
                'value' => 'Компания Nova Travel была основана в 2010 году в Кыргызстане с одной простой целью: сделать путешествия доступными, безопасными и незабываемыми для каждого. Мы верим, что каждое путешествие – это не просто смена обстановки, а возможность открыть для себя что-то новое, получить бесценный опыт и создать воспоминания на всю жизнь. За эти годы мы выросли из небольшого местного агентства в крупного туроператора, предлагающего широкий спектр услуг: от экзотических пляжных туров до захватывающих приключений в горах Кыргызстана, а также уникальные сувениры со всего мира. Мы гордимся нашей командой профессионалов, которые любят свое дело и готовы приложить все усилия, чтобы ваш отдых был идеальным. Наша миссия – вдохновлять людей на путешествия, предоставляя высококачественные услуги и индивидуальный подход к каждому клиенту. Мы стремимся превзойти ваши ожидания и сделать каждое путешествие с Nova Travel по-настоящему особенным.',
                'description' => 'Полное описание компании на странице "О нас"',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_our_story_image',
                'value' => 'https://images.unsplash.com/photo-1542037101-78939c148301?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'description' => 'Изображение для секции "Наша история" на странице "О нас"',
                'type' => 'image',
            ],
            [
                'key' => 'about_our_values_title',
                'value' => 'Наши ценности',
                'description' => 'Заголовок секции "Наши ценности" на странице "О нас"',
                'type' => 'text',
            ],
            // About - Our Values points
            [
                'key' => 'about_our_values_1_icon',
                'value' => 'fas fa-heart',
                'description' => 'Иконка 1 пункта "Наши ценности" на странице "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'about_our_values_1_title',
                'value' => 'Страсть к путешествиям',
                'description' => 'Заголовок 1 пункта "Наши ценности" на странице "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'about_our_values_1_description',
                'value' => 'Мы сами любим путешествовать и делимся этой страстью с нашими клиентами.',
                'description' => 'Описание 1 пункта "Наши ценности" на странице "О нас"',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_our_values_2_icon',
                'value' => 'fas fa-users',
                'description' => 'Иконка 2 пункта "Наши ценности" на странице "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'about_our_values_2_title',
                'value' => 'Клиентоориентированность',
                'description' => 'Заголовок 2 пункта "Наши ценности" на странице "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'about_our_values_2_description',
                'value' => 'Ваши пожелания и комфорт - наш главный приоритет.',
                'description' => 'Описание 2 пункта "Наши ценности" на странице "О нас"',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_our_values_3_icon',
                'value' => 'fas fa-leaf',
                'description' => 'Иконка 3 пункта "Наши ценности" на странице "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'about_our_values_3_title',
                'value' => 'Устойчивый туризм',
                'description' => 'Заголовок 3 пункта "Наши ценности" на странице "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'about_our_values_3_description',
                'value' => 'Мы заботимся о природе и культуре, поддерживая ответственный туризм.',
                'description' => 'Описание 3 пункта "Наши ценности" на странице "О нас"',
                'type' => 'textarea',
            ],
            // About - Team members (пример, можно расширить)
            [
                'key' => 'team_member_1_name',
                'value' => 'Айжан Садыкова',
                'description' => 'Имя члена команды 1',
                'type' => 'text',
            ],
            [
                'key' => 'team_member_1_role',
                'value' => 'Генеральный директор',
                'description' => 'Должность члена команды 1',
                'type' => 'text',
            ],
            [
                'key' => 'team_member_1_description',
                'value' => 'Визионер и основатель Nova Travel, с 15-летним опытом в туризме.',
                'description' => 'Описание члена команды 1',
                'type' => 'textarea',
            ],
            [
                'key' => 'team_member_1_image',
                'value' => 'https://placehold.co/150x150/f0e4dd/3b2c28?text=Фото',
                'description' => 'URL фото члена команды 1',
                'type' => 'image', // Изменено на image
            ],
            [
                'key' => 'team_member_2_name',
                'value' => 'Тимур Исаев',
                'description' => 'Имя члена команды 2',
                'type' => 'text',
            ],
            [
                'key' => 'team_member_2_role',
                'value' => 'Руководитель отдела продаж',
                'description' => 'Должность члена команды 2',
                'type' => 'text',
            ],
            [
                'key' => 'team_member_2_description',
                'value' => 'Эксперт по направлениям Азии и Европы, всегда найдет идеальный тур.',
                'description' => 'Описание члена команды 2',
                'type' => 'textarea',
            ],
            [
                'key' => 'team_member_2_image',
                'value' => 'https://placehold.co/150x150/f0e4dd/3b2c28?text=Фото',
                'description' => 'URL фото члена команды 2',
                'type' => 'image', // Изменено на image
            ],
            [
                'key' => 'team_member_3_name',
                'value' => 'Гульмира Осмонова',
                'description' => 'Имя члена команды 3',
                'type' => 'text',
            ],
            [
                'key' => 'team_member_3_role',
                'value' => 'Менеджер по работе с клиентами',
                'description' => 'Должность члена команды 3',
                'type' => 'text',
            ],
            [
                'key' => 'team_member_3_description',
                'value' => 'Обеспечивает безупречную поддержку и заботу о каждом путешественнике.',
                'description' => 'Описание члена команды 3',
                'type' => 'textarea',
            ],
            [
                'key' => 'team_member_3_image',
                'value' => 'https://placehold.co/150x150/f0e4dd/3b2c28?text=Фото',
                'description' => 'URL фото члена команды 3',
                'type' => 'image', // Изменено на image
            ],

            // --- Contact Page Content ---
            [
                'key' => 'contact_hero_title',
                'value' => 'Свяжитесь с нами',
                'description' => 'Заголовок Hero-секции на странице контактов',
                'type' => 'text',
            ],
            [
                'key' => 'contact_hero_subtitle',
                'value' => 'Мы всегда готовы ответить на ваши вопросы и помочь спланировать идеальное путешествие.',
                'type' => 'text',
            ],
            [
                'key' => 'contact_hero_image',
                'value' => 'https://images.unsplash.com/photo-1528747045269-390fe33c19f2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'description' => 'Фоновое изображение Hero-секции на странице контактов',
                'type' => 'image',
            ],
            [
                'key' => 'contact_details_title',
                'value' => 'Наши контакты',
                'description' => 'Заголовок секции с контактными данными',
                'type' => 'text',
            ],
            [
                'key' => 'contact_form_title',
                'value' => 'Отправьте нам сообщение',
                'description' => 'Заголовок формы обратной связи',
                'type' => 'text',
            ],
            [
                'key' => 'contact_working_hours_title',
                'value' => 'Часы работы:',
                'description' => 'Заголовок для часов работы на странице контактов',
                'type' => 'text',
            ],
            [
                'key' => 'contact_working_hours_text_mon_fri',
                'value' => 'Пн-Пт: 9:00 - 18:00',
                'description' => 'Часы работы Пн-Пт на странице контактов',
                'type' => 'text',
            ],
            [
                'key' => 'contact_working_hours_text_sat',
                'value' => 'Сб: 10:00 - 15:00',
                'description' => 'Часы работы Сб на странице контактов',
                'type' => 'text',
            ],
            [
                'key' => 'contact_working_hours_text_sun',
                'value' => 'Вс: Выходной',
                'description' => 'Часы работы Вс на странице контактов',
                'type' => 'text',
            ],
            [
                'key' => 'contact_map_embed_url',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2923.636657805193!2d74.6033994157813!3d42.87699317915509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x389eb79667f5b355%3A0x6b8c8d8c8d8c8d8c!2z0YPQu9C40YbQsCDQkdC40YDQtdC60LDRgNC-0LLQsCwgMTAz!5e0!3m2!1sru!2skg!4v1678890000000!5m2=1sru!2skg',
                'description' => 'URL для встраиваемой карты Google Maps на странице контактов',
                'type' => 'url',
            ],

            // --- Tours Page Content ---
            [
                'key' => 'tours_hero_title',
                'value' => 'Наши туры',
                'description' => 'Заголовок Hero-секции на странице туров',
                'type' => 'text',
            ],
            [
                'key' => 'tours_hero_subtitle',
                'value' => 'Найдите идеальное путешествие среди более чем 200 туров по всему миру',
                'type' => 'text',
            ],
            [
                'key' => 'tours_hero_image',
                'value' => 'https://images.unsplash.com/photo-1433838552652-f9a46b332c40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'description' => 'Фоновое изображение Hero-секции на странице туров',
                'type' => 'image',
            ],
            [
                'key' => 'tours_help_title',
                'value' => 'Нужна помощь?',
                'description' => 'Заголовок секции "Нужна помощь?" на странице туров',
                'type' => 'text',
            ],
            [
                'key' => 'tours_help_description',
                'value' => 'Наши эксперты по путешествиям помогут вам выбрать идеальный тур.',
                'description' => 'Описание секции "Нужна помощь?" на странице туров',
                'type' => 'textarea',
            ],
            [
                'key' => 'tours_why_choose_us_title',
                'value' => 'Почему выбирают наши туры',
                'description' => 'Заголовок секции "Почему выбирают наши туры" на странице туров',
                'type' => 'text',
            ],
            [
                'key' => 'tours_why_choose_us_subtitle',
                'value' => 'Мы предлагаем уникальные преимущества, которые делают наши туры особенными',
                'type' => 'text',
            ],
            // Tours - Why Choose Us points
            [
                'key' => 'tours_why_choose_us_1_icon',
                'value' => 'fas fa-shield-alt',
                'description' => 'Иконка 1 пункта "Почему выбирают наши туры"',
                'type' => 'text',
            ],
            [
                'key' => 'tours_why_choose_us_1_title',
                'value' => 'Безопасность',
                'description' => 'Заголовок 1 пункта "Почему выбирают наши туры"',
                'type' => 'text',
            ],
            [
                'key' => 'tours_why_choose_us_1_description',
                'value' => 'Все наши партнеры проверены, отели имеют высокие стандарты безопасности, а гиды проходят специальную подготовку.',
                'description' => 'Описание 1 пункта "Почему выбирают наши туры"',
                'type' => 'textarea',
            ],
            [
                'key' => 'tours_why_choose_us_2_icon',
                'value' => 'fas fa-wallet',
                'description' => 'Иконка 2 пункта "Почему выбирают наши туры"',
                'type' => 'text',
            ],
            [
                'key' => 'tours_why_choose_us_2_title',
                'value' => 'Гарантия лучшей цены',
                'description' => 'Заголовок 2 пункта "Почему выбирают наши туры"',
                'type' => 'text',
            ],
            [
                'key' => 'tours_why_choose_us_2_description',
                'value' => 'Мы гарантируем лучшие цены на рынке. Если найдете такой же тур дешевле - вернем разницу!',
                'description' => 'Описание 2 пункта "Почему выбирают наши туры"',
                'type' => 'textarea',
            ],
            [
                'key' => 'tours_why_choose_us_3_icon',
                'value' => 'fas fa-star',
                'description' => 'Иконка 3 пункта "Почему выбирают наши туры"',
                'type' => 'text',
            ],
            [
                'key' => 'tours_why_choose_us_3_title',
                'value' => 'Эксклюзивные программы',
                'description' => 'Заголовок 3 пункта "Почему выбирают наши туры"',
                'type' => 'text',
            ],
            [
                'key' => 'tours_why_choose_us_3_description',
                'value' => 'Мы разрабатываем уникальные маршруты и экскурсии, которые вы не найдете у других туроператоров.',
                'description' => 'Описание 3 пункта "Почему выбирают наши туры"',
                'type' => 'textarea',
            ],
            [
                'key' => 'tours_related_title',
                'value' => 'Похожие туры',
                'description' => 'Заголовок секции "Похожие туры" на детальной странице тура',
                'type' => 'text',
            ],
            [
                'key' => 'tours_book_button_text',
                'value' => 'Забронировать тур',
                'description' => 'Текст кнопки "Забронировать тур" на детальной странице',
                'type' => 'text',
            ],

            // --- Souvenirs Page Content ---
            [
                'key' => 'souvenirs_hero_title',
                'value' => 'Сувениры из путешествий',
                'description' => 'Заголовок Hero-секции на странице сувениров',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_hero_subtitle',
                'value' => 'Частичка каждого уголка мира - в вашем доме',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_hero_image',
                'value' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
                'description' => 'Фоновое изображение Hero-секции на странице сувениров',
                'type' => 'image',
            ],
            [
                'key' => 'souvenirs_special_offer_title',
                'value' => 'Набор "Мировые столицы"',
                'description' => 'Заголовок специального предложения на странице сувениров',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_special_offer_description',
                'value' => 'Магниты 6 городов по цене 5!',
                'description' => 'Описание специального предложения на странице сувениров',
                'type' => 'textarea',
            ],
            [
                'key' => 'souvenirs_special_offer_button_text',
                'value' => 'Купить за 1 990 ₽',
                'description' => 'Текст кнопки специального предложения на странице сувениров',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_why_choose_us_title',
                'value' => 'Почему выбирают наши сувениры',
                'description' => 'Заголовок секции "Почему выбирают наши сувениры"',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_why_choose_us_subtitle',
                'value' => 'Каждый сувенир - это не просто вещь, а частичка впечатлений',
                'type' => 'text',
            ],
            // Souvenirs - Why Choose Us points
            [
                'key' => 'souvenirs_why_choose_us_1_icon',
                'value' => 'fas fa-globe-asia',
                'description' => 'Иконка 1 пункта "Почему выбирают наши сувениры"',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_why_choose_us_1_title',
                'value' => 'Аутентичность',
                'description' => 'Заголовок 1 пункта "Почему выбирают наши сувениры"',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_why_choose_us_1_description',
                'value' => 'Все сувениры привозятся непосредственно из стран происхождения и отражают их культуру.',
                'description' => 'Описание 1 пункта "Почему выбирают наши сувениры"',
                'type' => 'textarea',
            ],
            [
                'key' => 'souvenirs_why_choose_us_2_icon',
                'value' => 'fas fa-hands-helping',
                'description' => 'Иконка 2 пункта "Почему выбирают наши сувениры"',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_why_choose_us_2_title',
                'value' => 'Поддержка мастеров',
                'description' => 'Заголовок 2 пункта "Почему выбирают наши сувениры"',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_why_choose_us_2_description',
                'value' => 'Покупая наши сувениры, вы поддерживаете местных ремесленников и их традиции.',
                'description' => 'Описание 2 пункта "Почему выбирают наши сувениры"',
                'type' => 'textarea',
            ],
            [
                'key' => 'souvenirs_why_choose_us_3_icon',
                'value' => 'fas fa-gift',
                'description' => 'Иконка 3 пункта "Почему выбирают наши сувениры"',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_why_choose_us_3_title',
                'value' => 'Идеальный подарок',
                'description' => 'Заголовок 3 пункта "Почему выбирают наши сувениры"',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_why_choose_us_3_description',
                'value' => 'Мы предлагаем подарочную упаковку и открытку с рассказом о сувенире.',
                'description' => 'Описание 3 пункта "Почему выбирают наши сувениры"',
                'type' => 'textarea',
            ],
            [
                'key' => 'souvenirs_testimonials_title',
                'value' => 'Отзывы покупателей',
                'description' => 'Заголовок секции отзывов на странице сувениров',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_testimonials_subtitle',
                'value' => 'Что говорят наши клиенты о сувенирах из путешествий',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_related_title',
                'value' => 'Похожие сувениры',
                'description' => 'Заголовок секции "Похожие сувениры" на детальной странице сувенира',
                'type' => 'text',
            ],
            [
                'key' => 'souvenirs_add_to_cart_button_text',
                'value' => 'Добавить в корзину',
                'description' => 'Текст кнопки "Добавить в корзину" на детальной странице сувенира',
                'type' => 'text',
            ],

            // --- SEO Settings (уже были, но для полноты) ---
            [
                'key' => 'seo_home_title',
                'value' => 'Nova Travel - Туры по Кыргызстану и Миру, Сувениры',
                'description' => 'SEO Title для Главной страницы',
                'type' => 'text',
            ],
            [
                'key' => 'seo_home_description',
                'value' => 'Откройте для себя незабываемые туры по Кыргызстану и всему миру с Nova Travel. Лучшие предложения, уникальные маршруты и сувениры.',
                'description' => 'SEO Description для Главной страницы',
                'type' => 'textarea',
            ],
            [
                'key' => 'seo_tours_title',
                'value' => 'Наши туры - Nova Travel',
                'description' => 'SEO Title для страницы Туров',
                'type' => 'text',
            ],
            [
                'key' => 'seo_tours_description',
                'value' => 'Найдите идеальный тур среди сотен предложений от Nova Travel. Экскурсионные, пляжные, горнолыжные туры и многое другое.',
                'description' => 'SEO Description для страницы Туров',
                'type' => 'textarea',
            ],
            [
                'key' => 'seo_souvenirs_title',
                'value' => 'Сувениры из путешествий - Nova Travel',
                'description' => 'SEO Title для страницы Сувениров',
                'type' => 'text',
            ],
            [
                'key' => 'seo_souvenirs_description',
                'value' => 'Уникальные сувениры со всего мира от Nova Travel. Магниты, кружки, одежда и украшения для ваших воспоминаний.',
                'description' => 'SEO Description для страницы Сувениров',
                'type' => 'textarea',
            ],
            [
                'key' => 'seo_about_title',
                'value' => 'О компании Nova Travel - Ваш надежный туроператор',
                'description' => 'SEO Title для страницы "О нас"',
                'type' => 'text',
            ],
            [
                'key' => 'seo_about_description',
                'value' => 'Узнайте больше о Nova Travel: наша история, миссия и ценности. Мы создаем незабываемые путешествия с 2010 года.',
                'description' => 'SEO Description для страницы "О нас"',
                'type' => 'textarea',
            ],
            [
                'key' => 'seo_contact_title',
                'value' => 'Контакты Nova Travel - Свяжитесь с нами',
                'description' => 'SEO Title для страницы Контактов',
                'type' => 'text',
            ],
            [
                'key' => 'seo_contact_description',
                'value' => 'Свяжитесь с Nova Travel по вопросам туров, сувениров или для получения консультации. Наши контакты и форма обратной связи.',
                'description' => 'SEO Description для страницы Контактов',
                'type' => 'textarea',
            ],
        ];

        foreach ($settings as $settingData) {
            SiteSetting::firstOrCreate(
                ['key' => $settingData['key']], // Ищем по ключу
                $settingData // Если не найдено, создаем с этими данными
            );
        }
    }
}

