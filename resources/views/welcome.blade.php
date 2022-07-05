<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
</head>
<body>
<style></style>


    <div class="container">
        <h1><a href="/balance">Bank transaction</a></h1>
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
    <form action="{{ Route('event') }}" method="post">
        @csrf
        <div class="form-group row">
          <label for="destination" class="col-sm-2 col-form-label">Destination</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="destination" id="destination" placeholder="Destination" min="0" >
          </div>
        </div>
        <div class="form-group row">
            <label for="origin" class="col-sm-2 col-form-label">Origin</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="origin" id="origin" placeholder="Origin" min="0" >
            </div>
          </div>
        <div class="form-group row">
          <label for="amount" class="col-sm-2 col-form-label">Amount</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="amount"  id="amount" placeholder="Amount" min="0" >
          </div>
        </div>
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Type</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="deposit" value="deposit" checked>
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
            <th scope="col">#</th>
            <th scope="col">Account ID</th>
            <th scope="col">Balance</th>
          </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
            @endphp
            @foreach($result as $key => $value)
                <tr>
                    <th scope="row">{{ ++$key }}</th>
                    <td>{{ $value->id}}</td>
                    <td>{{ $value->balance}}</td>
                </tr>
            @endforeach



        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        <div class="col-auto">
            {{ $result->links() }}
        </div>

    </div>
    </div>

</body>
</html>
