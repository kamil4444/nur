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
      <a href="{{ route("profile") }}" class="btn btn-outline-primary">Main page</a>
      </div>
      <form action="{{ route("logout") }}" method="POST" class="d-flex">
      <div class="form-group">
           <button class="btn btn-outline-primary" type="submit">Logout</button>
        </div>
</form>
    </div>
  </nav>
  <div class="container">
    <div class="d-flex justify-content-between shadow m-3 p-5 bg-light rounded">
      <div>
        <h3>{{$nursery["name"]}}</h3>
        <p>{{$nursery["open_hours"]}}</p>
        <div class="d-flex">
          <div class="bg-light shadow p-2 mt-4 me-4 rounded-3 w-50">
            <h5>Zniżki</h5>
           @if($nursery["sales"] != '')
            {{$nursery["sales"]}}
          @else
            Brak
          @endif
          </div>
          <div class="bg-light shadow p-2 mt-4 me-4 rounded-3 w-40">
            <h5>Dane kontaktowe</h5>
            @if(Str::contains($nursery["webpage"], 'https://') == 'true' || Str::contains($nursery["webpage"], 'http://') == 'true')
            <p>Strona: <a href="{{ strtolower($nursery['webpage']) }}">{{ strtolower($nursery["webpage"]) }}</a></p>
            @elseif ($nursery['webpage'] != '')
              <p>Strona: <a href="https://{{ strtolower($nursery['webpage']) }}">https://{{ strtolower($nursery['webpage']) }}</a></p>
            @else
              <p>Strona: brak</p>
            @endif
            <p>E-mail: {{$nursery["email"]}}</p>
            <p>Phone: {{$nursery["phone_num"]}}</p>
          </div>
        </div>
      </div>
      <div>
        @if($nursery["places_amount"]==$nursery["amount_of_registrations_children"])
          <p class="text-danger"><span class="fs-4 fw-bold">{{ $nursery["amount_of_registrations_children"]}}</span> / <span class="fs-4">{{ $nursery["places_amount"] }}</span></p>
          <p class="mt-5 fs-4 fw-bold">{{ $nursery["monthly_payment"] }}</p>
          <form method="POST" action="{{route('update', $nursery["id"])}}" id="form_id">
            @method('PUT')
            
            <button type="submit" id="update" class="btn btn-primary" onclick="clickUpdate()" disabled>Zarezerwuj</button>
            <button type="submit" id="cancel" class="btn btn-primary" onclick="clickCancel()" disabled>Anuluj</button>
          </form>
        @elseif($nursery["amount_of_registrations_children"]=='')
        <p class="text-success"><span class="fs-4 fw-bold">?</span> / <span class="fs-4">{{ $nursery["places_amount"] }}</span></p>
        @else
          <p class="text-success"><span class="fs-4 fw-bold">{{ $nursery["amount_of_registrations_children"]}}</span> / <span class="fs-4">{{ $nursery["places_amount"] }}</span></p>
          <p class="mt-5 fs-4 fw-bold">{{ $nursery["monthly_payment"] }}</p>
          <form method="POST" action="{{route('update', $nursery["id"])}}" id="form_id">
            @method('PUT')
            @if (session()->get('zarezerwuj')=='disabled')
            <button type="submit" id="update" name="submit" value="update" class="btn btn-primary" disabled>Zarezerwuj</button>
            <button type="submit" id="cancel" name="submit" value="cancel" class="btn btn-primary" >Anuluj</button>
            @else
            <button type="submit" id="update" name="submit" value="update" class="btn btn-primary" >Zarezerwuj</button>
            <button type="submit" id="cancel" name="submit" value="cancel" class="btn btn-primary" disabled>Anuluj</button>
            @endif
           </form>
        @endif
      </div>
    </div>
    <div class="shadow m-3 p-5 bg-light rounded table-responsive">
      <table class="table table-hover text-center">
        <thead>
          <tr>
            <th scope="col">Opłata miesięczna</th>
            <th scope="col">Opłata za 10+ godzin</th>
            <th scope="col">Opłata pogodzinna</th>
            <th scope="col">Opłata za posiłki miesięczna</th>
            <th scope="col">Opłata za posiłki pogodzinna</th>
          </tr>  
        </thead>
        <tbody>
          <tr>
            @if($nursery["monthly_payment"] != '')
              <td>{{$nursery["monthly_payment"]}}</td>
            @else
              <td>Brak</td>
            @endif
            @if($nursery["hourly_payment_for_out_of_10_hours"] != '')
              <td>{{$nursery["hourly_payment_for_out_of_10_hours"]}}</td>
            @else
              <td>Brak</td>
            @endif
            @if($nursery["hourly_payment"] != '')
              <td>{{$nursery["hourly_payment"]}}</td>
            @else
              <td>Brak</td>
            @endif
            @if($nursery["monthly_food_fee"] != '')
              <td>{{$nursery["monthly_food_fee"]}}</td>
            @else
              <td>Brak</td>
            @endif
            @if($nursery["hourly_food_fee"] != '')
              <td>{{$nursery["hourly_food_fee"]}}</td>
            @else
              <td>Brak</td>
            @endif
          </tr>
        </tbody>
      </table>    
    </div>
    <div class="d-flex justify-content-between shadow m-3 p-5 bg-light rounded">
      <div id="map" style="width:100%;height:400px;" value={{$nursery["institution_localization"]}}>
        {{$nursery["institution_localization"]}}
      </div>
    </div>
  </div>

  <script>
    function initMap() {
      const geocoder = new google.maps.Geocoder();
      let address = document.getElementById("map").getAttribute("value");
      let arr = address.split("%20");
      address = arr.join(" ");
      
      geocoder.geocode({ 'address': address }, (res, status) => {
        console.log(res, status)

        if (status == google.maps.GeocoderStatus.OK) 
        {
          const nursery_localization = { lat: parseFloat(JSON.stringify(res[0].geometry.location.lat())), lng: parseFloat(JSON.stringify(res[0].geometry.location.lng())) };
          
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 18,
            center: nursery_localization,
          });
          
          const marker = new google.maps.Marker({
            position: nursery_localization,
            map: map,
          });
        } 
      });
    }

    function clickUpdate()
    {
      document.getElementById("update").disabled = true;
      document.getElementById("cancel").disabled = false;
      document.getElementById("form_id").submit();
    }

    function clickCancel()
    {
      document.getElementById("update").disabled = false;
      document.getElementById("cancel").disabled = true;

      document.getElementById("form_id").submit();
    }

    window.initMap = initMap;
  </script>

  <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyChkys2O1NSfCKHBRS1MKvChEDMXhTagOk&callback=initMap" ></script>
</body>
</html>