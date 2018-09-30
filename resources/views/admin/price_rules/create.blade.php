@extends('layouts.admin')

@section('title', 'Admin - Crée Price Rules')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.price_rules.index') }}">Regle des prix</a></li>
                    <li>Modifié la regle des prix</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    <!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Modifier</h3>
                    </div>
                    <div class="block-content">
                        <form id="appliance-search" class="form-horizontal" action="{{ route('admin.price_rules.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="lower">Lower</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="number" id="lower" name="lower" placeholder="Lower" value="" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="upper">Upper</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="number" id="upper" name="upper" placeholder="Lower" value="" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="margin">Margin</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="number" id="margin" name="margin" placeholder="Margin" value="" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Confirmer</button>
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
