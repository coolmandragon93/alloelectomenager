@extends('layouts.admin')

@section('title', 'Appliance Search - ASWO API')

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
                    Appliance Search <small></small>
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
                    The customer enteres a keyword to find his appliance. Also the manufacturer can be specified. Both fields must match the beginning of the word. (SON finds SONY). <br>
                    <strong>Command:</strong> <code>geraetesuche</code>
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
                                <td>hersteller</td>
                                <td>manufacturer</td>
                                <td>
                                    Optionally the manufacturer can be set then only appliances from this manufacturer are listed
                                </td>
                            </tr>
                            <tr>
                                <td>anzahl</td>
                                <td>number</td>
                                <td>
                                    limit the number of results per page, default is 10, maximum is 25
                                </td>
                            </tr>
                            <tr>
                                <td>seite</td>
                                <td>page</td>
                                <td>
                                    see command artikelsuche
                                </td>
                            </tr>
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
                        <form id="appliance-search" class="form-horizontal" action="{{ route('admin.aswo.appliance_search') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="suchbg">suchbg (keyword)</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="suchbg" name="suchbg" placeholder="keyword" value="---">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="hersteller">hersteller (manufacturer) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="hersteller" name="hersteller" placeholder="manufacturer" value="LG">
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
                            <div class="form-group">
                                <label class="col-xs-12" for="seite">seite (page) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="seite" name="seite" placeholder="page">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
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
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="unique ASWO ID of an appliance, alphanumeric, must be used as reference to fetch details for this appliance">
                                        appliance id<br>
                                        <small class="text-muted">geraeteid</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="appliance number, alphanumeric (e.g. '12912189'), alphanumeric">
                                        appliance number<br>
                                        <small class="text-muted">geraetennummer</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="appliance identnumber (e.g. '1099212898712'), alphanumeric">
                                        appliance identnumber<br>
                                        <small class="text-muted">geraeteidentnumber</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="appliance name, alphanumeric (e.g. 'LAVAMAT'), alphanumeric">
                                        appliance name<br>
                                        <small class="text-muted">geraetename</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="appliance manufacturer, alphanumeric (e.g. 'AEG'), alphanumeric">
                                        appliance manufacturer<br>
                                        <small class="text-muted">geraetehersteller</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="appliance type (like 'vacuum cleaner'), alphanumeric">
                                        appliance type<br>
                                        <small class="text-muted">geraeteart</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="unique ID for an appliance type, alphanumeric">
                                        appliance hits<br>
                                        <small class="text-muted">geraeteartenid</small>
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
        var form = $('#appliance-search');

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
                    $('#results table tbody').append('<tr><td>'+value.geraeteid+'</td><td>'+value.geraetennummer+'</td><td>'+value.geraeteidentnumber+'</td><td>'+value.geraetename+'</td><td>'+value.geraetehersteller+'</td><td>'+value.geraeteart+'</td><td>'+value.geraeteartenid+'</td></tr>')
                });
            });
            return false;
        });
    });
    </script>
@endsection