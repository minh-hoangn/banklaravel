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
    <form>
        <div class="form-group row">
          <label for="accountId" class="col-sm-2 col-form-label">Account ID</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="accountId" placeholder="Account ID" min="0" max="9999">
          </div>
        </div>
        <div class="form-group row">
          <label for="amount" class="col-sm-2 col-form-label">Amount</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="amount" placeholder="Amount" min="0" max="9999">
          </div>
        </div>
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Type</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type1" value="option1" checked>
                <label class="form-check-label" for="type1">
                  Deposit
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type2" value="option2">
                <label class="form-check-label" for="type2">
                  Withdraw
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type3" value="option3">
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


        <div class="form-group row">
                <button type="submit" class="btn btn-primary col-sm-2">Search</button>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="search" placeholder="Search" >
            </div>
        </div>


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
