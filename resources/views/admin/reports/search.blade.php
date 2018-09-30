@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

<?php 

Date::setLocale('fr');

?>


<!-- Main Container -->
<main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    Search Reports <small></small>
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

    <!-- Page Content -->
    <div class="content content-boxed">
    <!-- All ref -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">Liste des références recherché</h3>
        </div>

        <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 100px;">ID</th>
                        <th class="hidden-xs text-center">Référence produit</th>
                        <th>Marque</th>
                        <th>Résultat de recherche</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td class="text-center">
                            {{$item['search_reports']->id}}
                        </td>
                        <td class="hidden-xs text-center">{{$item['search_reports']->ref}}</td>
                        <td>
                           {{$item['search_reports']->marque}}
                        </td>
                        <td>
                         <span class="over"> 
                          <a href="https://alloelectromenager.com/recherche?serial={{$item['search_reports']->ref}}&manufacturer={{$item['search_reports']->marque}}" target="_blank" > <span style="display: none"> {{$item['search_reports']->validate}} </span>Résultat</a>
                          </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
           

        </div>
    </div>
    <!-- END All Orders -->

    </div>
    <!-- END Page Content -->
</main>



<!-- END Main Container -->
@endsection
