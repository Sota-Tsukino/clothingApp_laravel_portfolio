<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Services\ImageService;
use App\Services\UserService;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = $request->only(['is_active', 'sort', 'keyword', 'pagination']);
        $filtered = array_filter($params, fn($v) => $v !== null && $v !== '');
        $users = !empty($filtered)
            ? UserService::searchUserByAdmin($params)
            : UserService::getAllUsers(true);

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'is_active' => 'required|integer|in:0,1',
        ]);

        // dd($request);
        $user = User::findOrFail($id);
        // if (!$user) {
        //     return back()
        //         ->with([
        //             'message' => 'ユーザーが見つかりません',
        //             'status' => 'alert'
        //         ]);
        // }

        $user->is_active = $user->is_active ? 0 : 1;
        $user->save();

        return redirect()
            ->route('admin.user.index')
            ->with([
                'message' => 'ユーザーステータスを更新しました。',
                'status' => 'info'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        User::findOrFail($id)->delete(); //ソフトデリート

        return redirect()
            ->route('admin.user.index')
            ->with([
                'message' => 'ユーザーを削除しました。',
                'status' => 'info'
            ]);
    }

    public function softDeletedUsersIndex(Request $request)
    {
        $params = $request->only(['sort', 'keyword', 'pagination']);
        $filtered = array_filter($params, fn($v) => $v !== null && $v !== '');

        $softDeletedUsers = !empty($filtered)
            ? UserService::searchUserByAdmin($params, true) // 第二引数 true を渡す
            : User::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate($request->input('pagination', 12))
            ->appends($request->all());

        return view('admin.user.softdeleted-index', compact('softDeletedUsers'));
    }

    public function destroySoftDeletedUser($id)
    {
        try {
            //ユーザーが登録した衣類アイテム画像（サーバー上）を削除
            ImageService::deleteAllUserImages($id);

            // ユーザー完全削除（子のレコードはリレーションで削除）
            User::onlyTrashed()->findOrFail($id)->forceDelete();
            return redirect()
                ->route('admin.softDeleted-user.index')
                ->with([
                    'message' => 'ユーザーを完全削除しました。',
                    'status' => 'info'
                ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with([
                'message' => 'ユーザーが見つかりませんでした。',
                'status' => 'error'
            ]);
        }
    }

    public function restoreUser($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore(); //この記述でOK？
        return redirect()
            ->route('admin.softDeleted-user.index')
            ->with([
                'message' => 'ユーザーを復元しました。',
                'status' => 'info'
            ]);
    }
}
