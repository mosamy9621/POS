@extends('Dashboard.layouts.app')
@section('content')
    <div class="content-wrapper" >
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item "><a href="{{route('dashboard.index')}}">@lang('site.dashboard')</a></li>
                            <li class="breadcrumb-item "><a href="{{route('dashboard.categories.index')}}">@lang('site.categories')</a></li>
                            <li class="breadcrumb-item active"><a>@lang('site.create')</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h2> @lang('site.create')</h2>

                </div>
                <div class="card-body">

                    <form action="{{route('dashboard.categories.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @error('name')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>

                        @enderror
                        <div class="form-group">
                            <label >@lang('site.name')</label>
                            <input class="form-control" type="text" name="name" value="{{old('name')}}">
                        </div>

                        <button type="submit" class="btn btn-success" ><i class="fa fa-plus"></i> @lang('site.create')</button>
                    </form>

                </div>

            </div>
        </section>
    </div>
@endsection

