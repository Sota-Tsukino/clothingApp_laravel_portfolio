@props(['status' => 'info'])

@php
    if(session('status') === 'info'){ $textColor = 'text-green-500';}
    if(session('status')  === 'alert'){$textColor = 'text-red-500';}
@endphp

@if(session('message'))
    <div class="{{ $textColor }} mb-4">
    {{ session('message' )}}
    </div>
@endif
