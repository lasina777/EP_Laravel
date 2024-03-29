<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;
use App\Http\Requests\User\EditUserValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Форма авторизации
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login (){
        return view('users.login');
    }

    /**
     * Получение данных с формы авторизации через POST запрос
     * @param LoginValidation $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginPost (LoginValidation $request){
        if (Auth::attempt($request->validated())){
            $request->session()->regenerate();
            return back()->with(['success' => 'true']);
        }
        return back() -> withErrors(['auth' => 'Логин или пароль не верный!']);
    }

    /**
     * Форма регистрации
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register (){
        return view('users.register');
    }

    /**
     * Получение данных с формы регистрации через POST запрос
     * @param RegisterValidation $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerPost (RegisterValidation $request){
        $requests = $request->validated();
        $requests['password'] = Hash::make($requests['password']);
        User::create($requests);
        return redirect()->route('login')->with(['register' => 'true']);
    }

    /**
     * Вызов шаблона с кабинетом
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cabinet(){
        return view('users.cabinet');
    }

    /**
     * Вызов шаблона для редактирования кабинета
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cabinetEdit(){
        return view('users.edit');
    }

    /**
     * Функция редактирования аккаунта
     *
     * @param EditUserValidation $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cabinetEditPost(EditUserValidation $request){

        $arr = $request->validated();
        if (!$arr['password']) unset($arr['password']);
        else $arr['password'] = Hash::make($arr['password']);
        $user = Auth::user();
        $user->update($arr);
        return back()->with(['success' => true]);
    }

    /**
     * Выход из аккаунта пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request){
        Auth::logout();
        $request->session()->regenerate();
        return redirect()->route('login');
    }

    /**
     * Вывод всех пользователей(для админа)
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(){

        $breadcrumbs = [
            ['routeName' => 'welcome', 'name' => 'Главная страница'],
            ['name' => 'Пользователи'],

        ];

        $users= User::all();

        return view('admin.users.users', compact('users', 'breadcrumbs'));
    }
}
