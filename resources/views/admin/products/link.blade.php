@extends('layouts.admin')

@section('title', 'Get a product link')

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
                    Product link <small>get a direct link for a specific product</small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.products.index') }}">Products</a></li>
                    <li>Link</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    @include("includes.flash")

    <!-- Page Content -->
    <div class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="block">
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
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Get a link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="block result-block" style="display: none;">
                    <div class="block-content">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection

@section('scripts')
@parent

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });


    $("form").submit(function(e){
        var formData = {
            'artnr': $('#artnr').val(),
            'sperrgut': 1
        };

        $.post("{{ route('admin.products.get_link') }}", formData, function(data) {
          console.log(data);

          var html = "";

          if(data.error) {
            html = '<span class="text-danger">'+data.error+'</span>';
          } else {
            html = '<a href="'+data.link+'">'+data.link+'</a>'
          }

          console.log(html);

          $('.result-block .block-content p').empty().append(html);
          $('.result-block').show();
        });
        return false;
    });
</script>
@endsection