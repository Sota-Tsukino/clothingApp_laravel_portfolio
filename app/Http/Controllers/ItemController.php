<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SizeCheckerService;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\FittingToleranceService;
use App\Services\ItemService;
use Exception;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'item C index()';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $userId = Auth::id();
        $formData = ItemService::getFormData($userId);

        return view('item.create', [
            'categories' => $formData['categories'],
            'colors' => $formData['colors'],
            'brands' => $formData['brands'],
            'tags' => $formData['tags'],
            'seasons' => $formData['seasons'],
            'materials' => $formData['materials'],
            'bodyMeasurement' => $formData['bodyMeasurement'],
            'suitableSize' => $formData['suitableSize'],
            'fields' => $formData['fields'],
            'userTolerance' => $formData['userTolerance'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(ItemService::getValidationRules());

        try {
            $item = ItemService::saveItem($request->all());
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.create' : 'clothing-item.create')
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.show' : 'clothing-item.show', $item->id)
            ->with([
                'message' => '衣類アイテムを登録しました。',
                'status' => 'info'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $userId = Auth::id();
            $item = ItemService::getItemById($id);
            ItemService::isUserOwn($item, $userId);

            //サイズチェッカーに必要な情報を取得
            $userId = Auth::id();
            $bodyMeasurement = BodyMeasurementService::getLatestForUser($userId);
            $bodyCorrection = BodyCorrectionService::getForUser($userId);
            $suitableSize = SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection);
            $userTolerance = FittingToleranceService::getForUser($userId);
            $fields = SizeCheckerService::getFields();
        } catch (\Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'measurement.index')
                ->with([
                    'message' => $e->getMessage(),
                    'status' => 'alert'
                ]);
        }

        return view('item.show', [
            'item' => $item,
            'fields' => $fields,
            'suitableSize' => $suitableSize,
            'userTolerance' => $userTolerance,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userId = Auth::id();
        try {
            $formDataWithItem = ItemService::getFormDataWithItem($id, $userId);
        } catch (\Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'measurement.index')
                ->with([
                    'message' => $e->getMessage(),
                    'status' => 'alert'
                ]);
        }

        // dd($item->colors);

        return view('item.edit', [
            'categories' => $formDataWithItem['categories'],
            'colors' => $formDataWithItem['colors'],
            'brands' => $formDataWithItem['brands'],
            'tags' => $formDataWithItem['tags'],
            'seasons' => $formDataWithItem['seasons'],
            'materials' => $formDataWithItem['materials'],
            'item' => $formDataWithItem['item'],
            'bodyMeasurement' => $formDataWithItem['bodyMeasurement'],
            'suitableSize' => $formDataWithItem['suitableSize'],
            'fields' => $formDataWithItem['fields'],
            'userTolerance' => $formDataWithItem['userTolerance'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(ItemService::getValidationRules(true));
        $userId = Auth::id();

        try {
            $item = ItemService::getItemById($id);
            ItemService::isUserOwn($item, $userId);

            $item = ItemService::saveItem($request->all(), $item);

            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.show' : 'clothing-item.show', $item)
                ->with(['message' => '衣類アイテムを更新しました。', 'status' => 'info']);
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.edit' : 'clothing-item.edit', $id)
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
