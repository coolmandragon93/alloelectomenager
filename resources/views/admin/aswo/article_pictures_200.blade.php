@extends('layouts.admin')

@section('title', 'Article Pictures (until 200px) - ASWO API')

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
                    Article Pictures (until 200px) <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.aswo.index') }}">Aswo</a></li>
                    <li>Article Pictures (until 200px)</li>
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
                    The commands artikelsuche and geraeteartikel return in field bild with value J/N (representing Yes and No) the information if ASWO offered a picture for this article. <br />
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
                                <td>artnr</td>
                                <td>article number</td>
                                <td>
                                    article number where you want the picture for
                                </td>
                            </tr>
                             <tr>
                                <td>resize</td>
                                <td></td>
                                <td>
                                    allowed values: 50 and 200, the longest picture size 
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
                        <form id="article_pictures_200" class="form-horizontal" action="{{ route('admin.aswo.article_pictures_200') }}" >
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="artnr">artnr (item) </label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="artnr" name="artnr" placeholder="artnr" value="4741920">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="resize">resize </label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="resize" name="resize" placeholder="resize" value="50">
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
            <!-- this table missing artikeldaten feild-->
            <div class="block-content tab-content">
                <div class="tab-pane active" id="results">
                    <strong class="text-danger">Error: Please check raw results</strong>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="error number of this eed request, if it is not 0 then the request will not be continued but errornumber will be filled with a German text">
                                        error number<br>
                                        <small class="text-muted">fehlernummer</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="">
                                        tempurl<br>
                                        <small class="text-muted">tempurl</small>
                                    </th>
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
        var form = $('#article_pictures_200');

        form.submit(function(e){
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
                $('#results table tbody').append('<tr><td>'+data['fehlernummer']+'</td><td>'+data['tempurl']+'</td></tr>');
            });
            return false;


            /*var eed_id = '<?php //echo env('EED_ID'); ?>';
            var cur_session_id = '<?php //echo session_id(); ?>';
            var artnr = $(this).find("input[name='artnr']").val();
            var resize = $(this).find("input[name='resize']").val();
            var url = 'https://shop.euras.com/thumb.php?eed=1&kdnr='+eed_id+'&sessionid='+cur_session_id+'&artnr='+artnr+'&resize='+resize;
            console.log(url);

            $('#results .text-danger').hide();
            $("#result .block-header").addClass("bg-success");
            $("#result").show();
            $('#results table tbody').append('<tr><td>0</td><td>'+url+'</td></tr>');

            e.preventDefault();
            return false;*/
        });

    });
    </script>
@endsection