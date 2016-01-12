<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>A Star Search with PHP by Gabriel</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <h1 style="display: block;">Penerapan Algoritma Pencarian A-Star secara sederhana</h1>
    <hr style="display: block;">
    <p style="display: block;">Created by : Gabriel Fermy Aswinta - 15 22 30 15 &amp;copy; STIKOM Medan 2015</p>
    <div class="container-fluid" style="display: block;" data-pg-collapsed="">
        <img src="images\Romania.png" style="display: inline;">
    </div>

    <div class="container-fluid" style="display: block;">
        <div class="row" style="display: block;">
            <h2>Nilai Heuristic Tiap Kota</h2>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <table width = "100%" border="2px">
                        <thead>
                        <th style="padding: 20px; margin: 10px; width: auto;">
                            &nbsp;
                        </th>
                        @foreach($kota as $kot)
                            <th>{!! $kot->namaKota !!}</th>
                        @endforeach
                        </thead>
                        <tr align="center">
                            <td><b>Nilai H</b></td>
                            @foreach($kota as $kot)
                                <td>{!! $kot->hCost->hCost !!}</td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                </div>
            </div>

            <div class="col-xs-6" style="display: block;" data-pg-collapsed="">
                {!! Form::open([ 'route' => 'updateBiaya', 'method' => 'post', 'role'=>'form', 'class'=>'form-horizontal', 'style' =>'display: block;']) !!}
                @foreach($kota as $kot)
                    <div class="form-group" style="display: block;">
                        <label class="control-label col-sm-3" for="h{!! $kot->namaKota !!}" style="display: block;">{!! $kot->namaKota !!}</label>

                        <div class="col-sm-9">
                            <input name="h[{!! $kot->idKota !!}]" type="text" class="form-control" id="h{!! $kot->namaKota !!}" style="display: block;" value="{!! $kot->hCost->hCost !!}">
                        </div>
                    </div>
                @endforeach

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-block" style="display: inline-block;" name="updateBiaya" value="update">Update Biaya Heuristic</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-xs-6" style="display: block;"> </div>

        </div>
    </div>


    <div class="container" style="display: block;">
        <div class="row">
            <h2 style="display: block;">Rute Perjalanan</h2>
            <hr style="display: block;">
        </div>
        <div class="row pg-empty-placeholder">
            {!! Form::open(['route'=> 'findPath','method' => 'post','role'=>'form','class'=>'form-horizontal', 'style'=>'display: block;']) !!}
            <div class="form-group" style="display: block;">
                <label class="control-label   col-sm-3" for="asal">Kota Asal</label>

                <div class="col-sm-9">
                    <select id="asal" class="form-control" name="asal">
                        @foreach($kota as $kot)
                            <option value="{!! $kot->idKota !!}">{!! $kot->namaKota !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group" style="display: block;">
                <label class="control-label   col-sm-3" for="tujuan">Kota Tujuan</label>

                <div class="col-sm-9">
                    <select id="tujuan" class="form-control" name="tujuan">
                        @foreach($kota as $kot)
                            <option value="{!! $kot->idKota !!}">{!! $kot->namaKota !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-block" style="display: block;">Cari Rute Terpendek</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="container pg-empty-placeholder" style="display: block;">

    </div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
