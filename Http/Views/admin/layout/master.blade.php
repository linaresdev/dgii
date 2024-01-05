<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
@section("css")
	<link href="{{__url('{cdn}/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{__url('{cdn}/css/materialdesignicons.min.css')}}" rel="stylesheet">
	<link href="{{__url('{cdn}/css/layout.ui.css')}}" rel="stylesheet">
@show
</head>
<body role="lighter">
    @includeIF("dgii::admin.layout.partial.navbar")
    
    @yield("body", "Content Body")

@section("js")
	<script src="{{__url('{cdn}/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{__url('{cdn}/js/jquery-371.min.js')}}"></script>
	<script src="{{__url('{cdn}/js/layout.ui.js')}}"></script>
@show
</body>
</html>