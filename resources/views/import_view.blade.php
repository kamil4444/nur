<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>JSON-Import</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar sticky-top navbar-light shadow mb-5" style="background-color: #c4e3fa;">
    <div class="container-fluid">
      <div class="form-group">
      <a href="{{ route("profile") }}" class="btn btn-outline-primary">Main page</a>
      
      <form action="{{ route("logout") }}" method="POST" class="d-flex">
      <div class="form-group">
           <button class="btn btn-outline-primary" type="submit">Logout</button>
        </div></div>
</form>
    </div>
  </nav>
  <div class="container bg-light shadow mt-3 p-4">
    <form method="POST" enctype="multipart/form-data" id="upload-file" action="{{ route('import') }}">
      @csrf
      <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <input type="file" name="file" placeholder="Choose file" id="file">
                  @error('file')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                  @enderror
                <button type="submit" class="btn btn-primary" id="submit">Submit</button>
            </div>
        </div>   
      </div>  
    </form>
    <div class="col-md-12 bg-light shadow mt-3 p-3 rounded-3">
      @if(empty($nurseries))
        Get file for watch result...
      @else
        {{ json_encode($nurseries,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES|  JSON_PRETTY_PRINT)   }}
      @endif
    </div>
  </div>
</body>
</html>