<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Prefecture;
use App\Models\City;
use App\Services\UserService;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request): View
    {
        //※App\Models\User.phpにリレーションを定義していること
        $user = User::with(['prefecture', 'city'])->findOrFail(Auth::id());

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
    public function update(Request $request): RedirectResponse
    {
        $request->validate(UserService::getValidationRules(false, Auth::id()));

        //存在しないprefecture_id、city_idがリクエストされたらエラーを返す
        if (!empty($request->prefecture_id) && !Prefecture::where('id', $request->prefecture_id)->exists()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.profile.edit' : 'profile.edit')
                ->with([
                    'message' => '存在しない都道府県が選択されました。',
                    'status' => 'alert',
                ]);
        }

        if (!empty($request->city_id) && !City::where('id', $request->city_id)->exists()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.profile.edit' : 'profile.edit')
                ->with([
                    'message' => '存在しない市区町村が選択されました。',
                    'status' => 'alert',
                ]);
        }

        try {
            $user = $request->user(); //ログインUser(model型)を取得
            UserService::saveUser($request->all(), $user);
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.profile.edit' : 'profile.edit')
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.profile.show' : 'profile.show')
            ->with([ //セッションにフラッシュデータとして保存  session('message') session('status')
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

    public function editPassword(Request $request): View
    {
        return view('profile.password-edit');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate(UserService::getUpdatePasswordRules());

        try {
            $user = $request->user(); //ログインUser(model型)を取得
            UserService::savePassword($request->input('new_password'), $user);
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.profile.edit-password' : 'profile.edit-password')
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.profile.show' : 'profile.show')
            ->with([
                'message' => 'パスワードを更新しました。',
                'status' => 'info'
            ]);
    }
}
