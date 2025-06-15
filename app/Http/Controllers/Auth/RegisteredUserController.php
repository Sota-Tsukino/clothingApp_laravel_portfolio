<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\UserInitializationService;
use App\Models\Prefecture;
use App\Models\City;
use App\Services\UserService;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $prefectures = Prefecture::with('city')->get();//withの引数cityはmodelで定義したメソッド名？

        //blade側で下記で取得
        // foreach($prefectures as $prefecture) {
        //     dd($prefecture->city);
        // }

        return view('auth.register', compact('prefectures'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(UserService::getValidationRules(true));

        //存在しないprefecture_id、city_idがリクエストされたらエラーを返す
        if(!empty($request->prefecture_id) && !Prefecture::where('id', $request->prefecture_id)->exists()) {
            return redirect()
                ->route('register')
                ->with([
                    'message' => '存在しない都道府県が選択されました。',
                    'status' => 'alert',
                ]);
        }

        if(!empty($request->city_id) && !City::where('id', $request->city_id)->exists()) {
            return redirect()
                ->route('register')
                ->with([
                    'message' => '存在しない市区町村が選択されました。',
                    'status' => 'alert',
                ]);
        }

        $user = UserService::saveUser($request->all());
        event(new Registered($user));

        Auth::login($user);

        //体格補正値,許容値のデフォルト値作成
        app(UserInitializationService::class)->initialize(Auth::id());

        return redirect(RouteServiceProvider::HOME);
    }
}
