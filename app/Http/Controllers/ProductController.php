<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Product\ProductCreateValidation;
use App\Http\Requests\Admin\Product\ProductUpdateValidation;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Вывод всех продуктов(По 15 штук, для пользователя)
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(15);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Вызов шаблона для создания продукта
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $breadcrumbs = [
            ['routeName' => 'welcome', 'name' => 'Главная страница'],
            ['name' => 'Создание нового товара'],
        ];
        $request->session()->flashInput([]);
        return view('admin.product.createOrUpdate' , compact('breadcrumbs'));
    }

    /**
     * Создание продукта
     *
     * @param ProductCreateValidation $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductCreateValidation $request)
    {
        $validate = $request->validated();
        unset($validate['photo_file']);
        # public/sdfsdfsdfsd.jpg
        $photo = $request->file('photo_file')->store('public');
        # Explode => / => public/sdfsdfsdfsd.jpg => ['public', 'sdfsdfsdfsd.jpg']
        $validate['photo'] = explode('/',$photo)[1];

        Product::create($validate);
        return back()->with(['success' => true]);
    }

    /**
     * Показ одного продукта(подробно, для пользователя)
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $breadcrumbs = [
            ['routeName' => 'welcome', 'name' => 'Главная страница'],
            ['routeName' => 'admin.product.index', 'name' => 'Все продукты'],
            ['name' => $product->name],
        ];
        return view('admin.product.show', compact('product','breadcrumbs'));
    }

    /**
     * Вызов шаблона для редактирования продукта
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit( Request $request, Product $product)
    {
        $breadcrumbs = [
            ['routeName' => 'welcome', 'name' => 'Главная страница'],
            ['routeName' => 'admin.product.index', 'name' => 'Все продукты'],
            ['routeName' => 'admin.product.show','params' => ['product' => $product->id], 'name' => $product->name],
            ['name' => $product->name . ' | Редактирование'],
        ];
        $request->session()->flashInput($product->toArray());
        return view('admin.product.createOrUpdate', compact('product','breadcrumbs'));
    }

    /**
     * Редактирование продукта
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(ProductUpdateValidation $request, Product $product)
    {
        $validate = $request->validated();
        unset($validate['photo_file']);
        if ($request->hasFile('photo_file')){
            # public/sdfsdfsdfsd.jpg
            $photo = $request->file('photo_file')->store('public');
            # Explode => / => public/sdfsdfsdfsd.jpg => ['public', 'sdfsdfsdfsd.jpg']
            $validate['photo'] = explode('/',$photo)[1];
        }
        $product->update($validate);
        return back()->with(['success' => true]);
    }

    /**
     * Удаление продукта
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index');
    }

    /**
     * Вывод всех продуктов на главный шаблон(по 25 штук, для пользоватлея)
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexMain(){
        $products = Product::simplePaginate(25);
        return view('users.product.main', compact('products'));
    }

    /**
     * Показ одного продукта(подробно, для админа)
     *
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function firstProduct(Product $product){
        $breadcrumbs = [
            ['routeName' => 'welcome', 'name' => 'Главная страница'],
            ['name' => $product->name]
        ];
        return view('users.product.first' , compact('product', 'breadcrumbs'));
    }
}
