<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getSetting('seo_' . request()->route()->getName() . '_title', 'Nova Travel - ' . ($__env->yieldContent('title') ?: 'Путешествия и Сувениры')) }}</title>
    <meta name="description" content="{{ getSetting('seo_' . request()->route()->getName() . '_description', 'Nova Travel - ваш надежный партнер в мире путешествий. Откройте для себя незабываемые приключения и уникальные сувениры.') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Убедитесь, что этот тег присутствует --}}
    <style>
        :root {
            --primary-brown: #ff8357;    /* цвет 1 — персиково-лососевый */
            --light-brown: #f0e4dd;      /* цвет 2 — теплый светлый беж */
            --dark-brown: #3b2c28;       /* цвет 3 — темный глубокий */

            --cream: var(--light-brown); /* используем цвет 2 */
            --white: var(--cream);        /* используем цвет 2 */
            --text-dark: var(--dark-brown); /* используем цвет 3 */
            --text-light: var(--cream);      /* используем цвет 2 */
            --accent-gold: var(--primary-brown); /* используем цвет 1 */
        }

        body {
            font-family: 'Inter', sans-serif; /* Используем Inter, если доступен, иначе sans-serif */
            background-color: var(--cream);
            color: var(--text-dark);
        }

        /* Общие стили для кнопок, карточек и т.д. */
        .bg-brown-600 { background-color: var(--primary-brown); }
        .bg-brown-700 { background-color: var(--dark-brown); }
        .bg-brown-100 { background-color: rgba(139, 69, 19, 0.1); }
        .text-brown-600 { color: var(--primary-brown); }
        .text-brown-700 { color: var(--dark-brown); }
        .border-brown-600 { border-color: var(--primary-brown); }
        .hover\:bg-brown-700:hover { background-color: var(--dark-brown); }
        .bg-brown-primary { background-color: var(--primary-brown); }
        .bg-brown-dark { background-color: var(--dark-brown); }
        .bg-accent-gold { background-color: var(--accent-gold); }
        .bg-cream { background-color: var(--cream); }
        .bg-brown-light { background-color: var(--light-brown); }
        .text-accent-gold { color: var(--accent-gold); }

        /* Анимации для уведомлений корзины */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        .animate-fadeIn { animation: fadeIn 0.3s ease forwards; }
        .animate-fadeOut { animation: fadeOut 0.3s ease forwards; }

        /* Стили для карточек туров/сувениров */
        .tour-card, .product-card, .category-card {
            transition: all 0.3s ease;
        }
        .tour-card:hover, .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .filter-section {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .pagination .active {
            background-color: var(--primary-brown);
            color: white;
        }
        .card-image, .product-image {
            overflow: hidden;
        }
        .card-image img, .product-image img {
            transition: transform 0.5s ease;
        }
        .tour-card:hover .card-image img, .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent-gold);
            color: var(--dark-brown);
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body class="font-sans">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-map-marked-alt text-3xl text-brown-600 mr-2"></i>
                <span class="text-2xl font-bold text-brown-600">Nova Travel</span>
            </div>

            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-gray-800 hover:text-brown-600 font-medium @if(request()->routeIs('home')) text-brown-600 @endif">Главная</a>
                <a href="{{ route('tours.index') }}" class="text-gray-800 hover:text-brown-600 font-medium @if(request()->routeIs('tours.index')) text-brown-600 @endif">Туры</a>
                <a href="{{ route('about') }}" class="text-gray-800 hover:text-brown-600 font-medium @if(request()->routeIs('about')) text-brown-600 @endif">О нас</a>
                <a href="{{ route('contact') }}" class="text-gray-800 hover:text-brown-600 font-medium @if(request()->routeIs('contact')) text-brown-600 @endif">Контакты</a>
                <a href="{{ route('souvenirs.index') }}" class="text-gray-800 hover:text-brown-600 font-medium @if(request()->routeIs('souvenirs.index')) text-brown-600 @endif">Сувениры</a>
            </nav>

            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button id="cartButton" class="text-brown-700 hover:text-brown-900">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                        <span id="cartBadge" class="cart-badge hidden">0</span>
                    </button>
                </div>
                <button class="md:hidden text-gray-800" id="mobileMenuToggle">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <button class="hidden md:block bg-brown-600 text-white px-6 py-2 rounded-full hover:bg-brown-700 transition duration-300">
                    Забронировать
                </button>
            </div>
        </div>
    </header>

    <!-- Cart Modal -->
    <div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-xl w-full max-w-md mx-4 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Корзина</h3>
                <button id="closeCart" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="cartItems" class="mb-6 max-h-64 overflow-y-auto">
                <div class="text-center py-8 text-gray-500" id="emptyCartMessage">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>Ваша корзина пуста</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-medium text-gray-700">Итого:</span>
                    <span id="cartTotal" class="font-bold text-xl text-brown-600">0 ₽</span>
                </div>
                <button id="checkoutButton" class="w-full bg-brown-600 hover:bg-brown-700 text-white py-3 rounded-lg font-medium transition duration-300">
                    Оформить заказ
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal (для оформления заказа) -->
    <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-xl w-full max-w-lg mx-4 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Оформление заказа</h3>
                <button id="closeCheckout" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="checkoutForm" class="space-y-4">
                @csrf
                <div>
                    <label for="customer_name" class="block text-gray-700 text-sm font-bold mb-2">Ваше имя:</label>
                    <input type="text" name="customer_name" id="customer_name" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" required>
                </div>
                <div>
                    <label for="customer_email" class="block text-gray-700 text-sm font-bold mb-2">Ваш Email:</label>
                    <input type="email" name="customer_email" id="customer_email" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600" required>
                </div>
                <div>
                    <label for="customer_phone" class="block text-gray-700 text-sm font-bold mb-2">Ваш телефон (опционально):</label>
                    <input type="tel" name="customer_phone" id="customer_phone" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600">
                </div>
                <div>
                    <label for="shipping_address" class="block text-gray-700 text-sm font-bold mb-2">Адрес доставки (опционально):</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-brown-600"></textarea>
                </div>
                <button type="submit" class="w-full bg-brown-600 hover:bg-brown-700 text-white py-3 rounded-lg font-medium transition duration-300">
                    Подтвердить заказ
                </button>
            </form>
            <div id="checkoutMessage" class="mt-4 text-center text-sm font-medium hidden"></div>
        </div>
    </div>

    <!-- Mobile Menu (простая заглушка) -->
    <div id="mobileMenu" class="fixed inset-0 bg-white z-40 hidden md:hidden flex-col items-center justify-center space-y-6 text-xl">
        <a href="{{ route('home') }}" class="text-gray-800 hover:text-brown-600 font-medium">Главная</a>
        <a href="{{ route('tours.index') }}" class="text-gray-800 hover:text-brown-600 font-medium">Туры</a>
        <a href="{{ route('about') }}" class="text-gray-800 hover:text-brown-600 font-medium">О нас</a>
        <a href="{{ route('contact') }}" class="text-gray-800 hover:text-brown-600 font-medium">Контакты</a>
        <a href="{{ route('souvenirs.index') }}" class="text-gray-800 hover:text-brown-600 font-medium">Сувениры</a>
        <button id="closeMobileMenu" class="absolute top-4 right-4 text-gray-800">
            <i class="fas fa-times text-3xl"></i>
        </button>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brown-dark text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12"> {{-- Изменено на 3 колонки --}}
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-map-marked-alt text-3xl text-accent-gold mr-2"></i>
                        <span class="text-2xl font-bold">Nova Travel</span>
                    </div>
                    <p class="text-gray-400 mb-4">Мы создаем незабываемые путешествия с 2010 года. Наша миссия - сделать ваш отдых идеальным.</p>
                    <div class="flex space-x-4">
                        <a href="{{ getSetting('footer_facebook_url', '#') }}" class="text-gray-400 hover:text-accent-gold text-xl" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ getSetting('footer_instagram_url', '#') }}" class="text-gray-400 hover:text-accent-gold text-xl" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="{{ getSetting('footer_twitter_url', '#') }}" class="text-gray-400 hover:text-accent-gold text-xl" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="{{ getSetting('footer_youtube_url', '#') }}" class="text-gray-400 hover:text-accent-gold text-xl" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Помощь</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ getSetting('footer_delivery_url', '#') }}" class="text-gray-400 hover:text-accent-gold">Доставка и оплата</a></li>
                        <li><a href="{{ getSetting('footer_return_url', '#') }}" class="text-gray-400 hover:text-accent-gold">Возврат товара</a></li>
                        <li><a href="{{ getSetting('footer_faq_url', '#') }}" class="text-gray-400 hover:text-accent-gold">Вопросы и ответы</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-accent-gold">Контакты</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Контакты</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-accent-gold mt-1 mr-3"></i>
                            <span class="text-gray-400">{{ getSetting('footer_address', 'Кыргызстан, г. Бишкек, ул. Ибраимова, 103') }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-accent-gold mr-3"></i>
                            <span class="text-gray-400">{{ getSetting('footer_phone', '+996 (XXX) XXX-XXX') }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-accent-gold mr-3"></i>
                            <span class="text-gray-400">{{ getSetting('footer_email', 'info@novatravel.kg') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-brown-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">© {{ date('Y') }} Nova Travel. Все права защищены.</p>
                <div class="flex space-x-6">
                    <li><a href="{{ getSetting('footer_privacy_policy_url', '#') }}" class="text-gray-400 hover:text-accent-gold">Политика конфиденциальности</a></li>
                    <li><a href="{{ getSetting('footer_terms_url', '#') }}" class="text-gray-400 hover:text-accent-gold">Условия использования</a></li>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Global cart variable (now managed by backend session)
        let cart = [];

        // DOM elements
        const cartButton = document.getElementById('cartButton');
        const cartModal = document.getElementById('cartModal');
        const closeCart = document.getElementById('closeCart');
        const cartItemsContainer = document.getElementById('cartItems'); // Changed ID to avoid conflict
        const cartTotal = document.getElementById('cartTotal');
        const cartBadge = document.getElementById('cartBadge');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const checkoutButton = document.getElementById('checkoutButton'); // Checkout button in cart modal

        const checkoutModal = document.getElementById('checkoutModal'); // New checkout modal
        const closeCheckout = document.getElementById('closeCheckout'); // Close button for checkout modal
        const checkoutForm = document.getElementById('checkoutForm'); // Checkout form
        const checkoutMessage = document.getElementById('checkoutMessage'); // Message area for checkout form

        // --- Helper Functions for AJAX ---
        async function sendRequest(url, method, data = {}) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

            const options = {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(data),
            };

            if (method === 'GET') {
                delete options.body;
            }

            try {
                const response = await fetch(url, options);
                return await response.json();
            } catch (error) {
                console.error('Network or parsing error:', error);
                return { success: false, message: 'Произошла ошибка сети или сервера.' };
            }
        }

        // --- Cart Management Functions ---

        // Fetches cart content from backend and updates UI
        async function fetchCart() {
            const data = await sendRequest('{{ route('cart.get') }}', 'GET');
            if (data.cart) {
                cart = data.cart;
                updateCartUI();
            }
        }

        // Updates cart UI based on global 'cart' array
        function updateCartUI() {
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            cartBadge.textContent = totalItems;

            if (totalItems > 0) {
                cartBadge.classList.remove('hidden');
            } else {
                cartBadge.classList.add('hidden');
            }

            if (cart.length === 0) {
                emptyCartMessage.classList.remove('hidden');
                cartItemsContainer.innerHTML = ''; // Clear previous items
                cartItemsContainer.appendChild(emptyCartMessage);
            } else {
                emptyCartMessage.classList.add('hidden');
                let itemsHTML = '';
                let totalPrice = 0;

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    totalPrice += itemTotal;

                    itemsHTML += `
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <div class="flex items-center">
                            ${item.image_url ? `<img src="${item.image_url}" alt="${item.name}" class="w-12 h-12 object-cover rounded-md mr-3">` : ''}
                            <div>
                                <p class="font-medium text-gray-800">${item.name}</p>
                                <div class="flex items-center mt-1">
                                    <button class="decrease-item text-gray-500 hover:text-brown-600" data-id="${item.id}">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="mx-2 text-gray-700">${item.quantity}</span>
                                    <button class="increase-item text-gray-500 hover:text-brown-600" data-id="${item.id}">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-800">${itemTotal.toLocaleString('ru-RU')} ₽</p>
                            <button class="remove-item text-red-500 hover:text-red-700 text-sm mt-1" data-id="${item.id}">
                                <i class="fas fa-trash-alt"></i> Удалить
                            </button>
                        </div>
                    </div>
                    `;
                });

                cartItemsContainer.innerHTML = itemsHTML;
                cartTotal.textContent = `${totalPrice.toLocaleString('ru-RU')} ₽`;

                // Re-attach event listeners for dynamically created elements
                attachCartItemListeners();
            }
        }

        // Attaches event listeners for +/-/remove buttons in cart modal
        function attachCartItemListeners() {
            cartItemsContainer.querySelectorAll('.decrease-item').forEach(button => {
                button.onclick = async () => {
                    const id = button.dataset.id;
                    const item = cart.find(i => i.id == id);
                    if (item && item.quantity > 1) {
                        await sendRequest('{{ route('cart.update') }}', 'POST', { souvenir_id: id, quantity: item.quantity - 1 });
                    } else {
                        await sendRequest('{{ route('cart.remove') }}', 'POST', { souvenir_id: id });
                    }
                    fetchCart(); // Re-fetch to update UI
                };
            });

            cartItemsContainer.querySelectorAll('.increase-item').forEach(button => {
                button.onclick = async () => {
                    const id = button.dataset.id;
                    const item = cart.find(i => i.id == id);
                    if (item) {
                        await sendRequest('{{ route('cart.update') }}', 'POST', { souvenir_id: id, quantity: item.quantity + 1 });
                        fetchCart(); // Re-fetch to update UI
                    }
                };
            });

            cartItemsContainer.querySelectorAll('.remove-item').forEach(button => {
                button.onclick = async () => {
                    const id = button.dataset.id;
                    await sendRequest('{{ route('cart.remove') }}', 'POST', { souvenir_id: id });
                    fetchCart(); // Re-fetch to update UI
                };
            });
        }

        // Adds item to cart via AJAX
        async function addToCart(souvenirId, quantity = 1) {
            const data = await sendRequest('{{ route('cart.add') }}', 'POST', { souvenir_id: souvenirId, quantity: quantity });
            if (data.success) {
                showNotification(data.message, 'success');
                fetchCart(); // Update cart UI after adding
            } else {
                showNotification(data.message, 'error');
            }
        }

        // --- UI Interactions ---

        // Shows a temporary notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fadeIn ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-3"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('animate-fadeOut');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        }

        // Toggle cart modal
        cartButton.addEventListener('click', () => {
            cartModal.classList.remove('hidden');
            cartModal.classList.add('flex');
            fetchCart(); // Fetch latest cart content when opening
        });

        closeCart.addEventListener('click', () => {
            cartModal.classList.add('hidden');
            cartModal.classList.remove('flex');
        });

        cartModal.addEventListener('click', (e) => {
            if (e.target === cartModal) {
                cartModal.classList.add('hidden');
                cartModal.classList.remove('flex');
            }
        });

        // Toggle checkout modal
        checkoutButton.addEventListener('click', () => {
            if (cart.length === 0) {
                showNotification('Ваша корзина пуста!', 'error');
                return;
            }
            cartModal.classList.add('hidden'); // Hide cart modal
            checkoutModal.classList.remove('hidden');
            checkoutModal.classList.add('flex');
        });

        closeCheckout.addEventListener('click', () => {
            checkoutModal.classList.add('hidden');
            checkoutModal.classList.remove('flex');
            checkoutMessage.classList.add('hidden'); // Clear message on close
            checkoutForm.reset(); // Reset form on close
        });

        checkoutModal.addEventListener('click', (e) => {
            if (e.target === checkoutModal) {
                checkoutModal.classList.add('hidden');
                checkoutModal.classList.remove('flex');
                checkoutMessage.classList.add('hidden');
                checkoutForm.reset();
            }
        });

        // Checkout form submission
        checkoutForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(checkoutForm);
            const data = Object.fromEntries(formData.entries()); // Convert FormData to plain object

            const result = await sendRequest('{{ route('cart.checkout') }}', 'POST', data);

            checkoutMessage.classList.remove('hidden', 'text-green-600', 'text-red-600');
            if (result.success) {
                checkoutMessage.textContent = result.message;
                checkoutMessage.classList.add('text-green-600');
                checkoutForm.reset();
                fetchCart(); // Update cart UI (should be empty)
                setTimeout(() => {
                    checkoutModal.classList.add('hidden');
                    checkoutModal.classList.remove('flex');
                }, 2000); // Close modal after 2 seconds
            } else {
                let errorMessage = result.message;
                if (result.errors) { // Display validation errors
                    errorMessage += '\n' + Object.values(result.errors).flat().join('\n');
                }
                checkoutMessage.textContent = errorMessage;
                checkoutMessage.classList.add('text-red-600');
            }
        });


        // Mobile menu
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMobileMenu = document.getElementById('closeMobileMenu');

        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('flex');
        });

        closeMobileMenu.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('flex');
        });

        // Initial cart load when page loads
        document.addEventListener('DOMContentLoaded', () => {
            fetchCart();
        });
    </script>
    @yield('scripts') {{-- For page-specific scripts --}}
</body>
</html>
