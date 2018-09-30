@extends('layouts.admin')

@section('title', 'Add a new product')

@section('styles')
@parent
<style type="text/css">
    #result > .nav-tabs {
        background-color: #c9c9c9;
    }

    #results th {
        font-weight: normal;
        padding: 5px 10px;
        text-transform: uppercase;
        text-transform: none;
    }
</style>
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    Add a new product <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.products.index') }}">Products</a></li>
                    <li>New</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    @include("includes.flash")

    <!-- Page Content -->
    <div class="content">
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <h3 class="block-title">Description</h3>
            </div>
            <div class="block-content">
                <p>
                    Find a product using the form, and then add it.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Test</h3>
                    </div>
                    <div class="block-content">
                        <form class="form-horizontal" action="{{ route('admin.products.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group<?php if($errors->has('artnr')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="artnr">Aswo ID</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="artnr" name="artnr" placeholder="XXXXXXXXX" value="{{ old('artnr') }}">
                                </div>
                                @if ($errors->has('artnr'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('artnr') }}
                                    </div>
                                @endif
                            </div>
                            <input class="form-control" type="hidden" id="sperrgut" name="sperrgut" placeholder="bulky goods" value="1">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection