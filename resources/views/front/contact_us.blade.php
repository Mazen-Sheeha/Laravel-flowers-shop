@extends('front.layouts.app')
@section('title')
    SARI'S FLORAL | Contact
@endsection
@section('style')
    <style>
        .remaining_chars {
            color: gray;
            font-size: 11px !important;
            align-self: flex-end;
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('messages.store') }}" method="post" class="app_form">
        @csrf
        <h1>Send us a message</h1>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea aria-describedby="charCount" name="message_content" id="message" cols="30" rows="10" required
                class="form-control">{{ old('message_content') }}</textarea>
            <p class="remaining_chars" id=" id="charCount"">100 / 100</p>
        </div>
        <div class="form-group">
            <button>Send</button>
        </div>
    </form>
@endsection
@section('script')
    <script>
        const remainingChars = document.querySelector(".remaining_chars");
        const textarea = document.querySelector("textarea");
        textarea.addEventListener('input', () => {
            const maxLength = 100;
            if (textarea.value.length > maxLength) {
                textarea.value = textarea.value.slice(0, maxLength);
            }
            remainingChars.innerText = `${maxLength - textarea.value.length} / ${maxLength}`;
        });
    </script>
@endsection
