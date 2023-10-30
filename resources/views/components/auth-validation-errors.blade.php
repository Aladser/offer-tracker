@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>

    @foreach ($errors->all() as $error)
        <p class='font-semibold'>{{ $error }}</p>
    @endforeach
    </div>
@endif
