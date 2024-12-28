@extends('layouts.dashboard')

@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><i class="fa fa-edit"></i>Edit TV-Show</h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="/dashboard/home">Home</a></li>
                        <li><i class="fa fa-question"></i>TV-Show</li>
                        <li><i class="fa fa-plus"></i>Edit</li>
                    </ol>
                </div>
            </div>

            <!-- edit-profile -->
            <div id="edit-profile" class="tab-pane">
                <section class="panel">
                    <div class="panel-body bio-graph-info">
                        @if (\Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">
                                {{ Session::get('message') }}
                            </p>
                        @endif

                        <form class="form-horizontal" method="POST"
                            action="{{ route('tvshow.update', ['tvshowId' => $tvshow->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="form-group">
                                <label class="col-lg-2 control-label">TV-Show Title</label>
                                <div class="col-lg-10">
                                    <input name="title" class="form-control" value="{{ $tvshow->name }}" />
                                </div>
                            </div>
                            @error('title')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label class="col-lg-2 control-label">TV-Show Image</label>
                                <div class="col-lg-10">
                                    <input type="file" name="image" class="form-control" />
                                    <div style="margin-top: 5px;">Current image:
                                        @if (!empty($tvshow->image))
                                            <img src="{{ asset('images/' . $tvshow->image) }}" alt="TV-Show Image"
                                                style="max-width: 150px;">
                                        @else
                                            No Image
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @error('image')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label class="col-lg-2 control-label">TV-Show Featured</label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="featured" value="1"
                                        {{ $tvshow->featured ? 'checked' : '' }} />
                                </div>
                            </div>
                            @error('featured')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label class="col-lg-2 control-label">TV-Show Order</label>
                                <div class="col-lg-10">
                                    <input type="number" name="order" class="form-control"
                                        value="{{ $tvshow->order }}" />
                                </div>
                            </div>
                            @error('order')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label class="col-lg-2 control-label">TV-Show Description</label>
                                <div class="col-lg-10">
                                    <textarea name="desc" id="editor1" class="form-control" cols="30" rows="5">{{ $tvshow->description }}</textarea>
                                </div>
                            </div>
                            @error('desc')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                    <a href="{{ route('tvshows') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </section>
    </section>
    <!--main content end-->
@endsection
