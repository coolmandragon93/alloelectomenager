@extends('layouts.admin')

@section('title', 'Article Search - ASWO API')

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
                    Article Search <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.aswo.index') }}">Aswo</a></li>
                    <li>Appliance Search</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    <!-- Page Content -->
    <div class="content">
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <h3 class="block-title">Description</h3>
            </div>
            <div class="block-content">
                <p>
                    This is the main search function. You receive a result list of articles for a certain keyword. Search parameter is a keyword or an article family id (about article families read command artikelgruppen also). Both commands can be used alone or together. Also you can search for replacement articles that are known for a certain article. 
                    The result is limited to 50 articles per page and maximum 200 to be displayed. We recommand to show a hint to the customer to use a more specific keyword if this limit is reached. <br>
                    <strong>Command:</strong> <code>artikelsuche</code>
                </p>
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th style="width: 120px;">Input Parameter</th>
                                <th style="width: 120px;">Translation</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>suchbg</td>
                                <td>keyword</td>
                                <td>
                                    Keyword to find appliances<br>
                                    EED will search in fields appliance number, identnumber, appliance name. <br>
                                    This value is required. 
                                </td>
                            </tr>
                            <tr>
                                <td>vgruppe</td>
                                <td></td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>anzahl</td>
                                <td>number</td>
                                <td>
                                    limit the number of results per page, default is 10, maximum is 25
                                </td>
                            </tr>
                            <!--<tr>
                                <td>seite</td>
                                <td>page</td>
                                <td>
                                    see command artikelsuche
                                </td>
                            </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Test</h3>
                    </div>
                    <div class="block-content">
                        <form id="article-search" class="form-horizontal" action="{{ route('admin.aswo.article_search') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="suchbg">suchbg (keyword)</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="suchbg" name="suchbg" placeholder="keyword" value="---">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="vgruppe">vgruppe (manufacturer) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="vgruppe" name="vgruppe" placeholder="vgruppe" value="5236500000">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="anzahl">anzahl (number) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="anzahl" name="anzahl" placeholder="number">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-xs-12" for="seite">seite (page) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="seite" name="seite" placeholder="page">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Examples & Remarks</h3>
                    </div>
                    <div class="block-content">
                        <p>
                            Put <code>---</code> in <strong>suchbg</strong> to display all results for a specific manufacturer
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="block block-themed" id="result" style="display: none;">
            <ul class="nav nav-tabs" data-toggle="tabs">
                <li class="active">
                    <a href="#results">Response</a>
                </li>
                <li class="">
                    <a href="#raw-results">Raw Results</a>
                </li>
            </ul>
            <div class="block-content tab-content">
                <div class="tab-pane active" id="results">
                    <strong class="text-danger">Error: Please check raw results</strong>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="extra charge which ASWO calculates for specific articles (without taxes)">
                                        extra charge price<br>
                                        <small class="text-muted">artikelaufschlag</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="unique ASWO articile ID, alphanumeric">
                                        article id<br>
                                        <small class="text-muted">artikelnummer</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="article description">
                                        article description<br>
                                        <small class="text-muted">artikelbezeichnung</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="article family name, alphanumeric and special characters">
                                        family name<br>
                                        <small class="text-muted">vgruppenname</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="unique ID of an article family, always 10digit numeric but with leading 0">
                                        family id<br>
                                        <small class="text-muted">vgruppenid</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="">
                                        <br>
                                        <small class="text-muted">artikelhersteller</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="estimated delivery time of the article">
                                        delivery time<br>
                                        <small class="text-muted">lieferzeit</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="numeric value, estimated number of days for delivery (with dropshipping)">
                                        number of days for delivery<br>
                                        <small class="text-muted">lieferzeit_in_tagen</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title='decision if this articel can be ordered {"J", "N}'>
                                        orderable<br>
                                        <small class="text-muted">bestellbar</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="your price at ASWO, without taxes, format 0,00">
                                        purchase price	<br>
                                        <small class="text-muted">ekpreis</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title='ecision if it at least one orderable replacement article is known {"J", "N"}, if yes they can be fetches by article search using parameter "vergleich"'>
                                        replacement article	<br>
                                        <small class="text-muted">ersatzartikel</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title='decision if the article has a picture {"J", "N"}'>
                                        picture<br>
                                        <small class="text-muted">bild</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="raw-results">
                    <pre class="pre-sh"><code class="result-data json"></code></pre>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection

@section("scripts")
    @parent
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
    <script type="text/javascript">
    $(function(){
        var form = $('#article-search');

        form.submit(function(){
            var formData = form.serialize();
            $.post(form.attr('action'), formData, function(data) {
                var cssClass = "";
                if(data.fehlernummer == 0) {
                    $('#results .text-danger').hide();
                    cssClass = "success";
                } else {
                    cssClass = "danger";
                    $('#results .text-danger').show();
                }
                // Set result div header class
                $("#result .block-header").addClass("bg-"+cssClass);
                // show result box
                $("#result").show();
                // Display raw data
                $(".result-data").text(JSON.stringify(data, null, 2));
                // Highlight result
                $('pre code').each(function(i, block) {
                    hljs.highlightBlock(block);
                });

                // Display usable results
                // foreach treffer
                $.each(data.treffer, function(index, value){
                    $('#results table tbody').append('<tr><td>'+value.artikelaufschlag+'</td><td>'+value.artikelnummer+'</td><td>'+value.artikelbezeichnung+'</td><td>'+value.vgruppenname+'</td><td>'+value.vgruppenid+'</td><td>'+value.artikelhersteller+'</td><td>'+value.lieferzeit+'</td><td>'+value.bestellbar+'</td><td>'+value.ekpreis+'</td><td>'+value.ersatzartikel+'</td><td>'+value.bild+'</td></tr>')
                });
            });
            return false;
        });
    });
    </script>
@endsection