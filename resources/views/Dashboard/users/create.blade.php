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
                            <li class="breadcrumb-item "><a href="{{route('dashboard.users.index')}}">@lang('site.users')</a></li>
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

                    <form action="{{route('dashboard.users.store')}}" method="POST" enctype="multipart/form-data">
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
                        @error('email')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>
                        @enderror

                        <div class="form-group">
                            <label >@lang('site.email')</label>
                            <input class="form-control" type="email" name="email" value="{{old('email')}}">
                        </div>
                        @error('avatar')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>
                        @enderror

                        <div class="form-group">
                            <label for="avatar" >@lang('site.avatar')</label>
                            <input class="form-control" type="file" name="avatar"  >
                        </div>
                        @error('password')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>
                        @enderror
                        <div class="form-group">
                            <label >@lang('site.password')</label>
                            <input class="form-control" type="password" name="password">
                        </div>
                        @error('password_confirmation')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>
                        @enderror
                        <div class="form-group">
                            <label >@lang('site.password_confirmation')</label>
                            <input class="form-control" type="password" name="password_confirmation">
                        </div>
                        <!-- tabs start -->
                        <div class="card">
                            <div class="card-header d-flex p-0">
                                <h3 class="card-title p-3">@lang('site.permissions')</h3>
                                @php
                                    $models=['users','categories','products','clients','orders']
                                @endphp
                                <ul class="nav nav-pills ml-auto p-2">
                                    @foreach($models as $index => $model)
                                    <li class="nav-item"><a class="nav-link {{$index == 0 ? 'active' : ''}}" href="#{{$model }}" data-toggle="tab">@lang('site.'.$model)</a></li>
                                     @endforeach
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content" >

                                    @foreach($models as $index => $model)
                                    <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="{{$model}}">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="read-{{$model}}" name="permissions[]" value="read-{{$model}}">
                                            <label class="form-check-label" for="read-{{$model}}">
                                            @lang('site.read')</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-{{$model}}" name="permissions[]" value="create-{{$model}}">
                                            <label class="form-check-label" for="create-{{$model}}">@lang('site.create')</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="edit-{{$model}}" name="permissions[]" value="update-{{$model}}">
                                            <label class="form-check-label" for="edit-{{$model}}">@lang('site.edit')</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="delete-{{$model}}" name="permissions[]" value="delete-{{$model}}">
                                            <label class="form-check-label" for="delete-{{$model}}">@lang('site.delete')</label>
                                        </div>


                                    </div>
                                    @endforeach

                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- tabs end -->
                        <button type="submit" class="btn btn-success" ><i class="fa fa-plus"></i> @lang('site.create')</button>
                    </form>

                </div>

            </div>
        </section>
    </div>
@endsection

