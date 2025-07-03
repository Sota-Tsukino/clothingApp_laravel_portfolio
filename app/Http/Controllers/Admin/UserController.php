<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = $request->only(['is_active', 'sort', 'pagination']);
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
        $query = User::onlyTrashed();

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        switch ($request->input('sort')) {
            case \Constant::SORT_ORDER['oldRegisteredItem']:
                $query->orderBy('deleted_at', 'asc');
                break;
            default:
                $query->orderBy('deleted_at', 'desc');
                break;
        }

        $perPage = $request->input('pagination', 12);

        $softDeletedUsers = $query->paginate($perPage)->appends($request->all());

        return view('admin.user.softdeleted-index', compact('softDeletedUsers'));
    }

    public function destroySoftDeletedUser($id)
    {
        try {
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
