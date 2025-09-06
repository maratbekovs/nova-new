<?php

namespace App\Http\Controllers;

use App\Models\Souvenir;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; // Для транзакций

class CartController extends Controller
{
    /**
     * Add an item to the cart session.
     */
    public function add(Request $request)
    {
        $souvenirId = $request->input('souvenir_id');
        $quantity = $request->input('quantity', 1);

        $souvenir = Souvenir::find($souvenirId);

        if (!$souvenir || !$souvenir->is_active) {
            return response()->json(['success' => false, 'message' => 'Сувенир не найден или недоступен.'], 404);
        }

        $cart = Session::get('cart', []);

        $price = $souvenir->is_discounted && $souvenir->discount_price ? $souvenir->discount_price : $souvenir->price;

        if (isset($cart[$souvenirId])) {
            $cart[$souvenirId]['quantity'] += $quantity;
        } else {
            $cart[$souvenirId] = [
                'id' => $souvenir->id,
                'name' => $souvenir->title,
                'price' => $price,
                'quantity' => $quantity,
                'image_url' => $souvenir->image_url, // Добавляем изображение
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Сувенир добавлен в корзину!',
            'cart' => $cart,
            'total_items' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    /**
     * Update item quantity in the cart session.
     */
    public function update(Request $request)
    {
        $souvenirId = $request->input('souvenir_id');
        $quantity = $request->input('quantity');

        $cart = Session::get('cart', []);

        if (isset($cart[$souvenirId])) {
            if ($quantity > 0) {
                $cart[$souvenirId]['quantity'] = $quantity;
                Session::put('cart', $cart);
                return response()->json([
                    'success' => true,
                    'message' => 'Количество обновлено.',
                    'cart' => $cart,
                    'total_items' => array_sum(array_column($cart, 'quantity'))
                ]);
            } else {
                return $this->remove($request); // Если количество 0 или меньше, удаляем
            }
        }

        return response()->json(['success' => false, 'message' => 'Сувенир не найден в корзине.'], 404);
    }

    /**
     * Remove an item from the cart session.
     */
    public function remove(Request $request)
    {
        $souvenirId = $request->input('souvenir_id');
        $cart = Session::get('cart', []);

        if (isset($cart[$souvenirId])) {
            unset($cart[$souvenirId]);
            Session::put('cart', $cart);
            return response()->json([
                'success' => true,
                'message' => 'Сувенир удален из корзины.',
                'cart' => $cart,
                'total_items' => array_sum(array_column($cart, 'quantity'))
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Сувенир не найден в корзине.'], 404);
    }

    /**
     * Get current cart contents.
     */
    public function getCart()
    {
        $cart = Session::get('cart', []);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'cart' => array_values($cart), // Возвращаем как индексированный массив
            'total_price' => $totalPrice,
            'total_items' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    /**
     * Checkout process: save order to database.
     */
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Корзина пуста.'], 400);
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string|max:500',
        ]);

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        try {
            DB::beginTransaction(); // Начинаем транзакцию

            $order = Order::create([
                'customer_name' => $request->input('customer_name'),
                'customer_email' => $request->input('customer_email'),
                'customer_phone' => $request->input('customer_phone'),
                'shipping_address' => $request->input('shipping_address'),
                'total_amount' => $totalAmount,
                'status' => 'pending', // Начальный статус заказа
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'souvenir_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price_at_purchase' => $item['price'],
                ]);
            }

            DB::commit(); // Завершаем транзакцию

            Session::forget('cart'); // Очищаем корзину после успешного заказа

            return response()->json(['success' => true, 'message' => 'Ваш заказ успешно оформлен!', 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack(); // Откатываем транзакцию в случае ошибки
            // Log the error for debugging
            \Log::error('Order checkout failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Произошла ошибка при оформлении заказа. Пожалуйста, попробуйте еще раз.'], 500);
        }
    }

    /**
     * Clear the entire cart session.
     */
    public function clearCart()
    {
        Session::forget('cart');
        return response()->json(['success' => true, 'message' => 'Корзина очищена.']);
    }
}

