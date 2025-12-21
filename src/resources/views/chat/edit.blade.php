@extends('layouts.app')

@section('content')
    <div class="edit-wrapper">
        <h2>メッセージを編集</h2>

        <form action="{{ route('chat.update', $chatMessage->id) }}" method="POST">
            @csrf
            @method('PUT')

            <textarea name="message" rows="4">{{ old('message', $chatMessage->message) }}</textarea>

            @error('message')
                <p style="color:red;">{{ $message }}</p>
            @enderror

            <button type="submit">更新する</button>
        </form>

        <a href="{{ route('chat.index', $transaction->id) }}">戻る</a>
    </div>
@endsection
