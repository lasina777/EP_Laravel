<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Вызов шаблона с корзиной пользователя
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function basket(Request $request){
        $products = null;
        if ($request->session()->has('basket')){
            $productIds = $request->session()->get('basket');
            $productIds = array_keys($productIds);
            $products = Product::whereIn('id', $productIds)->get();
        }
        return view('users.order.basket' , compact('products'));
    }

    /**
     * Вывод продуктов пользоватлея в корзину
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function basketPost(Request $request){
        $basket = $request->input('productsIds');
        $basket = array_filter($basket, function ($item){
           return $item>=1;
        });
        $request->session()->put('basket', $basket);
        return back();
    }

    /**
     * Добавление в корзину продукта
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addBasket(Request $request){
        $basket = [];
        if($request->session()->has('basket'))
            $basket = $request->session()->get('basket');
        $basket[(int) $request->query('productId')] = 1;
        $request->session()->put('basket', $basket);
        return back();
    }

    /**
     * Создание заказа
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrder(Request $request){
        if (!$request->session()->has('basket')) return back()->with('errorCreate', true);
        $order = Order::create([
            'user_id' => Auth::id(),
            'address' => ($request->address ?? Auth::user()->address)
        ]);

        $basket = $request->session()->get('basket');
        $basket = array_filter($basket, function ($item){
            return $item>=1;
        });
        # Получение продуктов
        $productIds = array_keys($basket);
        $products = Product::whereIn('id', $productIds)->get();
        foreach ($products as $item){
            $order->items()->create([
                'product_id' => $item->id,
                'price' => $item->price,
                'count' => $basket[$item->id]
            ]);
        }
        $request->session()->forget('basket');
        return redirect()->route('welcome');
    }

    /**
     * Вызов шаблона с заказами пользователя или всеми(если это админ)
     *
     * @param $myOrder
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function orders($myOrder = 'my'){
        $orders = Order::select('*');
        if (Auth::user()->role == 'user'|| $myOrder =='my')
            $orders->where('user_id', Auth::id());

        $orderItems = $orders->get();
        return view('orders.view', ['orders' => $orderItems]);
    }

    /**
     * Функция для отмены заказов
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Order $order){
        if (Auth::user()->role == 'admin'){
            $order->status = 'Отклонен';
            $order->save();
            return back()->with('success', true);
        }
        else if(Auth::id() == $order->user_id){
            $order->status = 'Отклонен';
            $order->save();
            return back()->with('success', true);
        }
        return back()->with('success', false);
    }

    /**
     * Функция для завершения заказов
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completed(Order $order){
        $order->status = 'Завершен';
        $order->save();
        return back()->with('completed', true);
    }
}
