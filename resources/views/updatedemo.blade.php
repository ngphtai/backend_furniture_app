<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload image</title>
</head>
<body style="margin-left: 500px; margin-top :150px ">

    <form  action="{{ route('updateMultiImage') }}" method="POST" enctype="multipart/form-data">@csrf
        <input type="file" name="file[]" id="" multiple>
        <button type="submit">Upload</button>
    </form>

</body>
</html>
