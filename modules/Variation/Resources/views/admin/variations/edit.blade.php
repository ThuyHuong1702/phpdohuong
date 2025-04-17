@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('variation::variations.variation')]))
    @slot('subtitle', $variation->name)

    <li><a href="{{ route('admin.variations.index') }}">{{ trans('variation::variations.variations') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('variation::variations.variation')]) }}</li>
@endcomponent

@section('content')
    <div class="box">
        <div class="box-body">
            <div id="app">
                <form
                class="form"
                method="POST"
                action="{{ route('admin.variations.update', $variation->id) }}"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
            
                @include('variation::admin.variations.partials.general')
                @include('variation::admin.variations.partials.values')
                @include('variation::admin.variations.partials.submit')
            </form>
            </div>
        </div>
    </div>
@endsection

@include('variation::admin.variations.partials.scripts')

@push('globals')
    <script type="module">
     
        Ecommerce.data['variation'] = {!! $variation !!};
    </script>

    @vite([
        'modules/Variation/Resources/assets/admin/sass/main.scss',
        'modules/Variation/Resources/assets/admin/js/edit.js',
        'modules/Media/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/js/main.js',
    ])
@endpush
