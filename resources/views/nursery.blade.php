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
    <div class="container-fluid">
      <div>
        <a href="{{ route("export_to_JSON") }}" class="btn btn-outline-primary">Export to JSON</a>
        <a href="#" class="btn btn-outline-primary">Export to XML</a>
        <a href="#" class="btn btn-outline-primary">Import from JSON</a>
        <a href="#" class="btn btn-outline-primary">Import from XML</a>
      </div>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container bg-light shadow mt-5 p-5">
    @foreach ($nurseries as $nursery)
    <div class="d-flex justify-content-between shadow p-3 mb-5 bg-light rounded">
      <div class="text-wrap w-75">
        <p><span class="fs-4">{{ $nursery->name }}</span></p>
        <p>{{ $nursery->institution_localization }}</p>
        <p><a href="{{ $nursery->webpage }}">{{ $nursery->webpage }}</a></p>
      </div>
      <div>
        @if($nursery->places_amount==$nursery->amount_of_registrations_children)
          <p class="pe-5 text-danger"><span class="fs-4 fw-bold">{{ $nursery->places_amount }}</span> / <span class="fs-4">{{ $nursery->amount_of_registrations_children}}</span></p>
        @else
          <p class="pe-5 text-success"><span class="fs-4 fw-bold">{{ $nursery->places_amount }}</span> / <span class="fs-4">{{ $nursery->amount_of_registrations_children}}</span></p>
        @endif
        <p class="mt-5 fs-4 fw-bold">{{ $nursery->monthly_payment }}</p>
      </div>
    </div>
    @endforeach

    <div class="d-flex pagination-lg justify-content-center mt-4">
      {!! $nurseries->links() !!}
    </div>
  </div>
</body>
</html>