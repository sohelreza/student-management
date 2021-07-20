<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Answer</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	
	
</head>

<body>
	
	@foreach($exam_answers as $answer)
	<img src="{{'cq_exam/'.$answer->image}}" width="100%" height="100%">
	@endforeach

</body>

</html>
