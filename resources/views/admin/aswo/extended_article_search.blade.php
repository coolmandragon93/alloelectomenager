@extends('layouts.admin')

@section('title', 'Extended Article Search - ASWO API')

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
                   Extended Article Search <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.aswo.index') }}">Aswo</a></li>
                    <li>Extended Article Search</li>
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
                    With this command you can the use the extended search function from the eShop which was live from 2004-2010. The search returns all article families that either contain the keyword itself or have any article in that contain the keyword. That means the user must select the familiy before he get the final result list what could be one step too much but on the other hand get very good results. For each article family also the complete tree is in the output. After the user has selected the family you should call a normal search using both parameters.  <br>
                    <strong>Command:</strong> <code>artikelsuche_neu</code>
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
                                <td></td>
                                <td>
                                    Search phrase (=keyword) (only numbers, letters and "-", "," and "." are allowed, all others including spaces will be ignored). <br />
                                    Only one keyword is allowed and it must have at least 3 characters. <br />
                                    For example: suchbg=SCART
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
                        <form id="extended_article_search" class="form-horizontal" action="{{ route('admin.aswo.extended_article_search') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="suchbg">suchbg</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="suchbg" name="suchbg" placeholder="suchbg" value="SCART">
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
                    <div class="table-responsive" >
                        <table class="table table-striped table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="unique ID of an article family, always 10digit numeric but with leading 0">
                                        family id<br>
                                        <small class="text-muted">vgruppenid</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="article family name, alphanumeric and special characters">
                                        family name<br>
                                        <small class="text-muted">vgruppenname</small>
                                    </th>
                                    <th colspan="2" class="text-center" data-toggle="tooltip" data-placement="top" title="array with a path for an article family, with sub- and maingroups">
                                        family path<br>
                                        <small class="text-muted">vgruppenbaum</small>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="unique ID of an article family, always 10digit numeric but with leading 0">
                                        family id<br>
                                        <small class="text-muted">vgruppenid</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="article family name, alphanumeric and special characters">
                                        family name<br>
                                        <small class="text-muted">vgruppenname</small>
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
        var form = $('#extended_article_search');
        console.log(form.attr('action'));
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
                $.each(data.vgruppentreffer, function(index, value){
                    $('#results table tbody').append('<tr><td>'+value.vgruppenid+'</td><td>'+value.vgruppenname+'</td><td>'+value.vgruppenbaum.vgruppenid+'</td><td>'+value.vgruppenbaum.vgruppenname+'</td></tr>')
                });
            });
            return false;
        });
    });
    </script>
@endsection


