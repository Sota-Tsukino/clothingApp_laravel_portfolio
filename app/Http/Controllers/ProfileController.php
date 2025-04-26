<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Prefecture;
use App\Models\City;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public function __construct() {
        $this->middleware('auth'); //必要？ web.phpでもこれを通している？
     }

    public function show(Request $request): View
    {
        //※App\Models\User.phpにリレーションを定義していること
        $user = User::with(['prefecture', 'city'])->findOrFail(Auth::id());
        // dd($user);
        return view('profile.show', compact('user'));
    }

    public function edit(Request $request): View
    {
        $user = User::with(['prefecture', 'city'])->findOrFail(Auth::id());
        $prefectures = Prefecture::all();

        //都道府県に該当する市区町村のみ取得
        $cities = City::where('prefecture_id', $user->prefecture_id)->get();

        // dd($user, $prefectures);

        return view('profile.edit', compact('user', 'prefectures', 'cities'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|string|email|max:20|unique:users,email,' . $request->user()->id,//unique:テーブル名、カラム名、除外するID
            'prefecture_id' => 'integer|nullable',
            'city_id' => 'integer|nullable',
        ]);

        $user = $request->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->prefecture_id = $request->prefecture_id;
        $user->city_id = $request->city_id;
        $user->save();

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.profile.show' : 'profile.show')
            ->with([//セッションにフラッシュデータとして保存  session('message') session('status')
                'message' => 'ユーザープロフィールを更新しました。',
                'status' => 'info'
            ]);

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
