@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('brand::brands.brands')]))

    <li><a href="{{ route('admin.brands.index') }}">{{ trans('brand::brands.brands') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('brand::brands.brands')]) }}</li>
@endcomponent
@section('content')
    <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}" class="form-horizontal" id="brand-form">
        @csrf
        @method('PUT')
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <div class="tab-pane fade in active" id="general">
                    <h3 class="tab-content-title">{{ trans('brand::brands.general') }}</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">{{ trans('brand::brands.form.name') }}<span class="m-l-5 text-red">*</span></label>
                    <div class="col-md-9">
                        <input name="name" id="name" type="text" style="margin-bottom: 10px" class="form-control" value="{{ $brand->name }}">
                        @if ($errors->has('name'))
                            <div class="alert alert-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="is_active" class="col-md-3 control-label">{{ trans('brand::brands.form.status') }}</label>
                    <div class="col-md-9">
                        <div class="checkbox">
                            <input type="hidden" value="0" name="is_active">
                            <input type="checkbox" value="1" name="is_active" id="is_active" {{ $brand->is_active ? 'checked' : '' }}>
                            <label for="is_active">{{ trans('brand::brands.form.enable') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                <button type="submit" class="btn btn-primary" data-loading>{{ trans('Save') }}</button>
            </div>
        </div>
    </form>
@endsection

@include('brand::admin.brands.partials.shortcuts')

@push('globals')
    @vite([
        'modules/Brand/Resources/assets/admin/sass/app.scss',
        'modules/Brand/Resources/assets/admin/js/create.js',
        'modules/Variation/Resources/assets/admin/sass/main.scss',
        // 'modules/Option/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/js/main.js',
    ])
@endpush
