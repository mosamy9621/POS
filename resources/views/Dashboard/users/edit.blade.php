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
                            <li class="breadcrumb-item active"><a>@lang('site.edit')</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h2> @lang('site.edit')</h2>

                </div>
                <div class="card-body">

                    <form action="{{route('dashboard.users.update',$user)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @error('name')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>

                        @enderror
                        <div class="form-group">
                            <label >@lang('site.name')</label>
                            <input class="form-control" type="text" name="name" value="{{$user->name}}">
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
                            <input class="form-control" type="email" name="email" value="{{($user->email)}}">
                        </div>
                        @error('password')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>
                        @enderror
                        @error('avatar')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>
                        @enderror

                        <div class="form-group">
                            <label for="avatar" >@lang('site.avatar')</label>
                            <input class="form-control" type="file" name="avatar" >
                        </div>
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
                                    $models=['users','categories','products','clients','orders'];
                                    $maps=['read','create','update','delete'];
                                @endphp
                                <ul class="nav nav-pills ml-auto p-2">
                                    @foreach($models as $index => $model)
                                        <li class="nav-item"><a class="nav-link {{$index == 0 ? 'active' : ''}}" href="#{{$model}}" data-toggle="tab">@lang('site.'.$model)</a></li>
                                    @endforeach
                                </ul>
                            </div><!-- /.card-header -->

                            <div class="card-body " >
                                <div class="tab-content" >
                            @foreach($models as $index => $model)
                                        <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="{{$model}}">
                                            @foreach($maps as $map )
                                            <div class="form-check mx-2">
                                                <label class="form-check-label" for="{{$map}}">
                                                    <input type="checkbox" class="form-check-input" id="{{$map}}" {{$user->hasPermission($map.'-'.$model) ? 'checked' :''}} name="permissions[]" value="{{$map}}-{{$model}}">
                                                    @lang('site.'.$map)</label>
                                            </div>
                                            @endforeach

                                        </div>

                            @endforeach
                                </div>

                            <!-- /.tab-content -->
                        <button type="submit" class="btn btn-success mt-2 " ><i class="fa fa-edit"></i>@lang('site.edit')</button>
                            </div><!-- /.card-body -->

                        </div>
                        <!-- tabs end -->
                    </form>

                </div>

            </div>
        </section>
    </div>
@endsection

