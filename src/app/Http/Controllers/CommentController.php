<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id)
    {

        $item = Item::findOrFail($item_id);
        auth()->user()->profile->comments()->create([
            'content' => $request->content,
            'item_id' => $item_id,
        ]);
        return redirect()->route('item.show', ['item_id' => $item->id]);
    }
}
