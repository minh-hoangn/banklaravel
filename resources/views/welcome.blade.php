<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>



    <div class="container">
        <h1>Bank transaction</h1>
    <form action="{{ Route('event') }}" method="post">
        @csrf
        <div class="form-group row">
          <label for="destination" class="col-sm-2 col-form-label">Destination</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" name="destination" id="destination" placeholder="Destination" min="0" max="9999">
          </div>
        </div>
        <div class="form-group row">
            <label for="origin" class="col-sm-2 col-form-label">Origin</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="origin" id="origin" placeholder="Origin" min="0" max="9999">
            </div>
          </div>
        <div class="form-group row">
          <label for="amount" class="col-sm-2 col-form-label">Amount</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" name="amount"  id="amount" placeholder="Amount" min="0" max="9999">
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

      <form action="" method="get">
        @csrf
        <div class="col-sm-10">
            <input type="text" class="form-control" id="search" placeholder="Search" >
            <button type="submit" class="btn btn-primary col-sm-2">Search</button>
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

            @foreach($result as $key => $value)
            <tr>
                <th scope="row">{{ ++$key }}</th>
                <td>{{ $value->id }}</td>
                <td>{{ $value->balance }}</td>
            </tr>

            @endforeach



        </tbody>
      </table>
    </div>

</body>
</html>
