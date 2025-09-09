<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle($item_id)
    {
        $item = Item::findOrFail($item_id);
        $profile = auth()->user()->profile;

        if ($profile->favoriteItems()->where('item_id', $item->id)->exists()) {
            $profile->favoriteItems()->detach($item->id);
            $status = 'removed';
        } else {
            $profile->favoriteItems()->attach($item->id);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'count' => $item->favoriteBy()->count(),
        ]);
    }
}
