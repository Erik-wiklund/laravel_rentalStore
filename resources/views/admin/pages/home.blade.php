@extends('layouts.dashboard')

@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--overview start-->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
                        <li><i class="fa fa-laptop"></i>Dashboard</li>
                    </ol>
                </div>
            </div>

            <div class="flash-message">
                @if (\Session::has('message'))
                    <p class="alert
            {{ Session::get('alert-class', 'alert-success') }}">
                        {{ Session::get('message') }}</p>
                @endif
            </div> <!-- end .flash-message -->

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box blue-bg">
                        <i class="fa fa-cloud-download"></i>
                        <div class="count">0</div>
                        <div class="title">Downloads</div>
                    </div>
                    <!--/.info-box-->
                </div>
                <!--/.col-->

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box brown-bg">
                        <i class="fa fa-users"></i>
                        <div class="count"></div>
                        <div class="title">Users</div>
                        <div style="font-size: 32px">{{ $users->count() }}</div>
                    </div>
                    <!--/.info-box-->
                </div>
                <!--/.col-->

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box dark-bg">
                        <i class="fa fa-comment"></i>
                        <div class="title">Messages</div>
                        <div style="font-size: 32px">{{ $contactMessages }}</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box darkgrey-bg">
                        <i class="fa fa-comment"></i>
                        <div class="title">Messages</div>
                        <div style="font-size: 32px">{{ $contactMessages }}</div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <!--main content end-->
@endsection
