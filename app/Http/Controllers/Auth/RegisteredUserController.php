<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\UserInitializationService;
use App\Models\Prefecture;
use App\Models\City;
use Illuminate\Validation\Rule;


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
        // dd($request);
        $request->validate([
            'nickname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' =>  [' required',Rule::in(['male', 'female', 'prefer_not_to_say'])],
            'prefecture_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
        ]);

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

        $user = User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'prefecture_id' => $request->prefecture_id,
            'city_id' => $request->city_id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        //体格補正値,許容値のデフォルト値作成
        app(UserInitializationService::class)->initialize(Auth::id());

        return redirect(RouteServiceProvider::HOME);
    }
}
