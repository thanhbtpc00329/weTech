<!DOCTYPE html>
<html>
<head>
	<title>fgdfg</title>
	<meta charset="utf-8">
</head>
<body>
	<form action="/api/post" method="POST" enctype="multipart/form-data">
		<div class="form-group col-md-12">
         <label>Content</label>
         <textarea name="txtContent" class="form-control " id="editor1"></textarea>
		</div> 		
        <input type="submit" name="save" value="SAVE">
	</form>
	<script src="/ckeditor/ckeditor.js"></script>
<script> CKEDITOR.replace('editor1'); </script>
</body>
</html>