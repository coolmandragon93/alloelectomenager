@extends('layouts.admin')

@section('title', 'ASWO API')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    Aswo API <small>List of all the available commands</small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.aswo.index') }}">Aswo</a></li>
                    <li><a class="link-effect" href="{{ route('admin.aswo.index') }}">Index</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    <!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="list-group">
                    <a class="list-group-item" href="{{ route('admin.aswo.appliance_search') }}"><span class="badge">7.3.1.1</span>7.3.1.1 Appliance search</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.article_families_for_an_appliance') }}"><span class="badge">7.3.2</span>7.3.2 Article families for an appliance</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.article_for_appliance_search') }}"><span class="badge">7.3</span>7.3 Article-for-appliance search</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.articles_for_an_appliance') }}"><span class="badge">7.3.3</span>7.3.3 Articles for an appliance</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.article_detail_information') }}"><span class="badge">7.1.2</span>7.1.2 Article detail information</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.article_pictures_200') }}"><span class="badge">7.0.2</span>7.0.2 Article Pictures (until 200px)</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.article_pictures_800') }}"><span class="badge">7.0.3</span>7.0.3 Article Pictures (until 800px)</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.article_families') }}"><span class="badge">7.2</span>7.2 Article families</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.article_search') }}"><span class="badge">7.1</span>7.1 Article search</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.check_list_of_appliances_for_available_articles') }}"><span class="badge">7.3.5</span>7.3.5 Check list of appliances for available articles</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.extended_article_search') }}"><span class="badge">7.1.1</span>7.1.1 Extended article search</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.suggestlist') }}"><span class="badge">7.1.3</span>7.1.3 Suggestlist</a>
                    <a class="list-group-item" href="{{ route('admin.aswo.search_result_quick_check') }}"><span class="badge">7.3.4</span>7.3.4 Search result quick check</a>
                </div>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection