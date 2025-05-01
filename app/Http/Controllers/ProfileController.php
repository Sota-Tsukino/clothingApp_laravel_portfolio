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
        $prefectures = Prefecture::with('city')->get();

        return view('profile.edit', compact('user', 'prefectures'));
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

        // dd($request);

        //存在しないprefecture_id、city_idがリクエストされたらエラーを返す
        if(!empty($request->prefecture_id) && !Prefecture::where('id', $request->prefecture_id)->exists()) {
            //この記述は正しい？ back()というのもみた事がある
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.profile.edit' : 'profile.edit')
                ->with([
                    'message' => '存在しない都道府県が選択されました。',
                    'status' => 'alert',
                ]);
        }

        if(!empty($request->city_id) && !City::where('id', $request->city_id)->exists()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.profile.edit' : 'profile.edit')
                ->with([
                    'message' => '存在しない市区町村が選択されました。',
                    'status' => 'alert',
                ]);
        }

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
