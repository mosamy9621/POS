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
                            <li class="breadcrumb-item "><a href="{{route('dashboard.products.index')}}">@lang('site.products')</a></li>
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

                    <form action="{{route('dashboard.products.store')}}" method="POST" enctype="multipart/form-data">
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


                        @error('description')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>

                        @enderror
                        <div class="form-group">
                            <label >@lang('site.description')</label>
                            <textarea class="form-control" style="height: 100px; resize: none" type="text" name="description" value=""> {{old('description')}}</textarea>
                        </div>


                        @error('purchased_price')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>

                        @enderror
                        <div class="form-group">
                            <label >@lang('site.purchased_price')</label>
                            <input class="form-control" type="number" step="0.01" name="purchased_price" value="{{old('purchased_price')}}">
                        </div>

                        @error('selling_price')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>

                        @enderror
                        <div class="form-group">
                            <label >@lang('site.selling_price')</label>
                            <input class="form-control" type="number" step="0.01" name="selling_price" value="{{old('selling_price')}}">
                        </div>

                        @error('image')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>

                        @enderror
                        <div class="form-group">
                            <label >@lang('site.image')</label>
                            <input class="form-control" type="file" name="image" >
                        </div>

                        @error('category')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>

                        @enderror
                        <div class="form-group">
                            <label >@lang('site.category')</label>
                            @if($categories->count()>0)

                                <select name ="category" class="form-control select2bs4" style="width: 100%;     scroll-behavior: smooth;" >
                               @foreach($categories as $index=> $category)
                               <option value="{{$category->id}}"> {{$category->name}}</option>
                               @endforeach
                           </select>
                           @else
                                <p class="alert text-lg font-weight-bold alert-warning">@lang('site.no_category_found')</p>

                            @endif
                        </div>

                        @error('stock')
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> @lang('site.alert')!</h5>
                            <p>*{{$message}}</p>
                        </div>

                        @enderror
                        <div class="form-group">
                            <label >@lang('site.stock')</label>
                            <input class="form-control" type="number" name="stock" value="{{old('stock')}}">
                        </div>


                        <button type="submit" class="btn btn-success" ><i class="fa fa-plus"></i> @lang('site.create')</button>
                    </form>

                </div>

            </div>
        </section>
    </div>
@endsection

