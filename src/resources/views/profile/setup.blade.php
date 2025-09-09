@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/setup.css') }}">
@endsection

@section('content')
    <div class="profile-setup-form__content">
        <div class="profile-setup-form__heading">
            <h2 class="profile-setup-form__heading content__heading">プロフィール設定</h2>
        </div>
        <form class="form" action="{{ route('profile.setup') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-setup-form__inner">
                <div class="profile-setup-form__profile-image">
                    <img class="user-icon" id="preview"
                        src="{{ $profile && $profile->profile_image ? asset('storage/' . $profile->profile_image) : asset('storage/profile_image/kkrn_icon_user_4.png') }}"alt="プロフィール画像">

                    <div class="profile-image__area">
                        <label for="fileupload">画像を選択する</label>
                        <input class="profile-image__input" type="file" name="profile_image" id="fileupload">
                    </div>

                    <div class="profile-image__error-message">
                        @error('profile_image')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const fileInput = document.getElementById('fileupload');
                        const previewImage = document.getElementById('preview');

                        fileInput.addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file && file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    previewImage.src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    });
                </script>



                <div class="form__group-content">
                    <label class="form__group-content--label" for="name">ユーザー名</label>
                    <input class="form__group-content--input" type="text" id="name" name="name"
                        value="{{ old('name', optional($profile)->name) }}">

                    <div class="form__error-message">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form__group-content">
                    <label for="post_code">郵便番号</label>
                    <input class="form__group-content--input" type="text" id="post_code" name="post_code"
                        value="{{ old('post_code', optional($address)->post_code) }}">

                    <div class="form__error-message">
                        @error('post_code')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form__content-group">
                    <label for="address">住所</label>
                    <input class="form__group-content--input" type="text" id="address" name="address"
                        value="{{ old('address', optional($address)->address) }}">

                    <div class="form__error-message">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form__group-content">
                    <label for="building">建物名</label>
                    <input class="form__group-content--input" type="text" id="building" name="building"
                        value="{{ old('building', optional($address)->building) }}">
                </div>

                <input class="form-btn btn" type="submit" value="更新する">

            </div>
        </form>




    </div>
@endsection
