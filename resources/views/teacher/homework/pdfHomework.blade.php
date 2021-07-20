<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Homework</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	
	
</head>

<body>
	
	@foreach($homework->images as $image)
	<img src="{{'homework/'.$image->homework_image}}" width="100%">
	@endforeach
	
	

</body>

</html>
