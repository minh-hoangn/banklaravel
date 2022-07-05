<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


</head>
<body>
<style></style>


    <div class="container">
        <h1><a href="/balance">Bank transaction</a></h1>
        {{-- {@dd(Session::get('errorMsg')) --}}
        {{-- @dd($errorMsg) --}}
        {{-- @if ($errorMsg->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errorMsg }}</li>
            </ul>
        </div>
        @endif --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="/reset" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Reset</button>
                </div>
              </div>
        </form>
        <hr></hr>
    <form action="{{ Route('event') }}" method="post" name="balanceForm" id="balanceForm">
        @csrf
        <div class="form-group row">
          <label for="destination" class="col-sm-2 col-form-label">Destination</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" name="destination" id="destination" placeholder="Destination" min="1" max="99999999999999999999" disabled >
          </div>
        </div>
        <div class="form-group row">
            <label for="origin" class="col-sm-2 col-form-label">Origin</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="origin" id="origin" placeholder="Origin" min="1" max="99999999999999999999" disabled>
            </div>
          </div>
        <div class="form-group row">
          <label for="amount" class="col-sm-2 col-form-label">Amount</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" name="amount"  id="amount" placeholder="Amount" min="0" max="99999999999" disabled>
          </div>
        </div>
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Type</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="deposit" value="deposit" >
                <label class="form-check-label" for="type1">
                  Deposit
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="withdraw" value="withdraw">
                <label class="form-check-label" for="type2">
                  Withdraw
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="transfer" value="transfer">
                <label class="form-check-label" for="type3">
                  Transfer
                </label>
              </div>
            </div>
          </div>
        </fieldset>

        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
      <hr></hr>
      <form action="/balance" method="get">
        <div class="row">
            <div class="col-sm-10">
                <input type="text" class="form-control" name="account_id" id="account_id" placeholder="Search" >
            </div>
            <button type="submit" class="btn btn-primary col-sm-2">Search</button>
            @csrf
        </div>
      </form>


      <table class="table">
        <thead>
          <tr>
            <th scope="col">Account ID</th>
            <th scope="col">Balance</th>
          </tr>
        </thead>
        <tbody>
            @foreach($result as $key => $value)
                <tr>
                    <td>{{ $value->id}}</td>
                    <td>{{ $value->balance}}</td>
                </tr>
            @endforeach



        </tbody>
    </table>
    <div class="d-flex justify-content-center">
            {{ $result->links() }}
    </div>
    <div class="mb-5"></div>
    </div>

</body>
<script>
$("input:radio").click(function() {
//getting option clicked value
    if($(this).val() == "deposit") {
        //set input enable
        $("#destination").prop('disabled', false);
        $("#amount").prop('disabled', false);
        //set input required
        $("#destination").prop('required', true);
        $("#amount").prop('required', true);
        //set input disable
        $("#origin").prop('disabled', true);
    }
     if($(this).val() == "withdraw") {
        //set input enable
        $("#origin").prop('disabled', false);
        $("#amount").prop('disabled', false);
        //set input required
        $("#origin").prop('required', true);
        $("#amount").prop('required', true);
        //set input disable
        $("#destination").prop('disabled', true);
    }
     if($(this).val() == "transfer") {
        //set input enable
        $("#destination").prop('disabled', false);
        $("#origin").prop('disabled', false);
        $("#amount").prop('disabled', false);
        //set input required
        $("#destination").prop('required', true);
        $("#origin").prop('required', true);
        $("#amount").prop('required', true);
    }
  });
</script>
</html>
