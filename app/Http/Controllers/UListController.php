<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UList;

class UListController extends Controller
{
    public function get_u_lists()
    {
        return UList::with(['good_name', 'source', 'uSubLists.source', 'uSubLists.good_name'])
            ->orderBy('number')
            ->get();
    }

    public function updateNumbers(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:u_lists,id',
            'items.*.number' => 'required|integer',
        ]);

        foreach ($validated['items'] as $item) {
            UList::where('id', $item['id'])->update(['number' => $item['number']]);
        }

        return response()->json(['status' => 'success']);
    }

    public function deleteUList($id)
    {
        $uList = UList::findOrFail($id);

        $uList->delete();

        return response()->json(['status' => 'success', 'message' => 'Элемент успешно удален']);
    }
}
