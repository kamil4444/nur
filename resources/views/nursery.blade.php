<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Żłobki</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar sticky-top navbar-light shadow mb-5" style="background-color: #c4e3fa;">
      <div>
        <a href="{{ route("profile") }}" class="btn btn-outline-primary">Main page</a>
        <a href="{{ route("export_to_JSON") }}" class="btn btn-outline-primary">Export to JSON</a>
        <a href="{{ route("export_to_XML") }}" class="btn btn-outline-primary">Export to XML</a>

        @if (session()->get('type')=='admin')
        <a href="{{ route("import_view") }}" class="btn btn-outline-primary">Import [JSON / XML]</a>
        @endif
      </div>
      <form action="{{ route("logout") }}" method="POST" class="d-flex">
      <div class="form-group">
           <button class="btn btn-outline-primary" type="submit">Logout</button>
        </div>
</form>
      <form action="{{ route("search") }}" method="GET" class="d-flex">
        <div class="form-group">
          <input class="form-control me-2" type="text" placeholder="Type to search..." name="search" aria-label="Search">
         </div>
        <div class="form-group">
           <button class="btn btn-outline-primary" type="submit">Search</button>
        </div>
      </form>
    </div>
  </nav>
  <div class="d-flex justify-content-between shadow p-3 mb-5 bg-light rounded ">
    <form action="{{ route('sortowaniepocenie') }}" method="get">
    <button class="btn btn-outline-primary" type="submit">Sortuj po cenie</button>
  
  <input class="form-control me-5" type="number" name="min" placeholder="min" aria-label="Search">
  <input class="form-control me-5" type="number" name="max" placeholder="max" aria-label="Search">
  
</form> 
</div>
  <div class="container bg-light shadow mt-5 p-5">
    @foreach ($nurseries as $nursery)
    <div class="d-flex justify-content-between shadow p-3 mb-5 bg-light rounded ">
      <div class="text-wrap w-75">
        <p><a href="{{ route('show', $nursery->id) }}" class="text-decoration-none text-dark"><span class="fs-4">{{ $nursery->name }}</span></a></p>
        <p>{{ $nursery->institution_localization }}</p>
        <p>
          @if (Str::contains($nursery->webpage,'https://') || Str::contains($nursery->webpage,'http://'))
          <a href="{{ $nursery->webpage }}">{{ $nursery->webpage }}</a>
          @elseif ($nursery->webpage != '')
          <a href="{{ 'https://' . $nursery->webpage }}">{{ 'https://' . $nursery->webpage }}</a>
          @else 
          Brak informacji
          @endif
          </p>
      </div>
      <div>
        @if($nursery->places_amount==$nursery->amount_of_registrations_children)
          <p class="pe-5 text-danger"><span class="fs-4 fw-bold">{{ $nursery->amount_of_registrations_children}}</span> / <span class="fs-4">{{ $nursery->places_amount }}</span></p>
        @elseif ($nursery->amount_of_registrations_children=='')
        <p class="pe-5 text-seccess"><span class="fs-4 fw-bold">?</span> / <span class="fs-4">{{ $nursery->places_amount }}</span></p>
        @else
          <p class="pe-5 text-success"><span class="fs-4 fw-bold">{{ $nursery->amount_of_registrations_children}}</span> / <span class="fs-4">{{ $nursery->places_amount }}</span></p>
        @endif
        @if ($nursery->monthly_payment==null && $nursery->hourly_payment==null)
        <p class="mt-5 fs-4 fw-bold">Brak danych</p>
        @elseif ($nursery->monthly_payment==null)
        <p class="mt-5 fs-4 fw-bold">{{ $nursery->hourly_payment }} /h</p>
        @else 
        <p class="mt-5 fs-4 fw-bold">{{ $nursery->monthly_payment }}</p>
        @endif
      </div>
    </div>
    @endforeach

    <div class="d-flex pagination-lg justify-content-right mt-4">
    {!! $nurseries->links() !!}
    </div>
  </div>
</body>
</html>