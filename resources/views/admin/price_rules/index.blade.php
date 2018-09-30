@extends('layouts.admin')

@section('title', 'Régles des prix')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    Admin <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Accueil</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    @include("includes.flash")

    <!-- Page Content -->
    <div class="content content-boxed">

    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">Price Rules</h3>
        </div>
        <div class="block-content">
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Lower</th>
                        <th>Upper</th>
                        <th>Margin</th>
                        <th>Action</th>
                    </tr>
                    @foreach($price_rules as $price_rule)
                    <tr>
                        <td>{{ $price_rule->lower }} €</td>
                        <td>{{ $price_rule->upper }} €</td>
                        <td>{{ $price_rule->margin }}</td>
                        <td>
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('admin.price_rules.edit', $price_rule->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                <a href="{{ route('admin.price_rules.destroy', $price_rule->id) }}" data-toggle="tooltip" title="Delete" class="btn btn-default delete"><i class="fa fa-times text-danger"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            {{ $price_rules->links() }}
        </div>
    </div>
</main>
<script type="text/javascript">
var deleteBtn = document.querySelectorAll('a.delete');

if(deleteBtn.length > 0){
    var total = deleteBtn.length;
    var x;

    for(x=0;x<total;x++){
        deleteBtn[x].addEventListener('click',function(e){
            e.preventDefault();

            if(window.confirm('Etes-vous sur de vouloir supprimer cette commande ?')){
                document.location.href = this.getAttribute('href');
            }
        })
    }        
}
</script>
@endsection
