<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['prefecture', 'city'])->where('role', 'user')->get();
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
        User::findOrFail($id)->delete();

        return redirect()
        ->route('admin.user.index')
        ->with([
            'message' => 'ユーザーを削除しました。',
            'status' => 'info'
        ]);

    }
}
