<!DOCTYPE html>
<html>
<head>
	<title>fgdfg</title>
	<meta charset="utf-8">
</head>
<body>
	<form action="" method="POST" enctype="multipart/form-data">
		<div class="form-group col-md-12">
         <label>Content</label>
         <textarea name="txtContent" class="form-control " id="editor1"></textarea>
		</div> 		
	</form>
	<script src="/ckeditor/ckeditor.js"></script>
	<script> CKEDITOR.replace( 'editor1', {
        filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
        filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
        filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
        filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
        filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
        filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
    } ); </script>
</body>
</html>