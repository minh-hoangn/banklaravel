<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</head>

<body>
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
        @if (\Session::has('dataSuccess'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('dataSuccess') !!}</li>
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
        <!--  Tạo tài khoản  -->
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAccount">
            Create Account
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createAccount" tabindex="-1" aria-labelledby="createAccountLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAccountLabel">Create Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('event') }}" method="post" name="balanceForm1" id="balanceForm1">
                            @csrf
                            <div class="form-group row">
                                <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="amount" id="amount"
                                        placeholder="Amount" min="0" max="99999999999">
                                </div>
                            </div>
                            <input type="hidden" name="type" id="deposit" value="deposit">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!--  end Tạo tài khoản  -->
        <hr>
        </hr>
        {{--  <form action="{{ route('event') }}" method="post" name="balanceForm" id="balanceForm">
            @csrf
            <div class="form-group row">
                <label for="destination" class="col-sm-2 col-form-label">Destination</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="destination" id="destination"
                        placeholder="Destination" min="1" max="99999999999999999999" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="origin" class="col-sm-2 col-form-label">Origin</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="origin" id="origin" placeholder="Origin"
                        min="1" max="99999999999999999999" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount"
                        min="0" max="99999999999" disabled>
                </div>
            </div>
            <fieldset class="form-group">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Type</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="deposit"
                                value="deposit">
                            <label class="form-check-label" for="type1">
                                Deposit
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="withdraw"
                                value="withdraw">
                            <label class="form-check-label" for="type2">
                                Withdraw
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="transfer"
                                value="transfer">
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
        </form>  --}}
        <hr>
        </hr>
        <form action="/balance" method="get">
            <div class="row">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="account_id" id="account_id" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-primary col-sm-2">Search</button>
            </div>
        </form>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Account ID</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Deposot</th>
                    <th scope="col">Withdraw</th>
                    <th scope="col">Transfer</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->balance }}</td>
                        <td>
                            <!--  Nạp tài khoản  -->
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#depositAccount{{ $value->id }}">
                                Deposit
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="depositAccount{{ $value->id }}" tabindex="-1"
                                aria-labelledby="depositAccountLabel{{ $value->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="depositAccounttLabel{{ $value->id }}">Deposit from Account ID: {{ $value->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('event') }}" method="post"
                                                name="balanceFormDeposit{{ $value->id }}"
                                                id="balanceFormDeposit{{ $value->id }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="amount"
                                                        class="col-sm-2 col-form-label">Amount</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" name="amount"
                                                            id="amount" placeholder="Amount" min="0"
                                                            max="99999999999">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" id="deposit" value="deposit">
                                                <input type="hidden" name="destination" id="destination"
                                                    value="{{ $value->id }}">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--  end Nạp tài khoản  -->
                        </td>
                        <td>
                            <!--  Rút tài khoản  -->
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#withdrawAccount{{ $value->id }}">
                                Withdraw
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="withdrawAccount{{ $value->id }}" tabindex="-1"
                                aria-labelledby="withdrawAccountLabel{{ $value->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="withdrawAccountLabel{{ $value->id }}">Withdraw from Account ID: {{ $value->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('event') }}" method="post"
                                                name="balanceFormWithdraw{{ $value->id }}"
                                                id="balanceFormWithdraw{{ $value->id }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="amount"
                                                        class="col-sm-2 col-form-label">Amount</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" name="amount"
                                                            id="amount" placeholder="Amount" min="0"
                                                            max="99999999999">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" id="withdraw"
                                                    value="withdraw">
                                                <input type="hidden" name="origin" id="origin"
                                                    value="{{ $value->id }}">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--  end Rút tài khoản  -->
                        </td>
                        <td>
                            <!--  Chuyển tiền tài khoản  -->
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#transferAccount{{ $value->id }}">
                                Transfer
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="transferAccount{{ $value->id }}" tabindex="-1"
                                aria-labelledby="transferAccountLabel{{ $value->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="transferAccountLabel{{ $value->id }}">Transfer from Account ID: {{ $value->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('event') }}" method="post"
                                                name="balanceFormTransfer{{ $value->id }}"
                                                id="balanceFormTransfer{{ $value->id }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="destination" class="col-sm-2 col-form-label">Destination</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" name="destination" id="destination"
                                                            placeholder="Destination" min="1" max="99999999999999999999">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="amount"
                                                        class="col-sm-2 col-form-label">Amount</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" name="amount"
                                                            id="amount" placeholder="Amount" min="0"
                                                            max="99999999999">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" id="transfer"
                                                    value="transfer">
                                                <input type="hidden" name="origin" id="origin"
                                                    value="{{ $value->id }}">

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--  end Chuyển tiền tài khoản  -->
                        </td>
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
        if ($(this).val() == "deposit") {
            //set input enable
            $("#destination").prop('disabled', false);
            $("#amount").prop('disabled', false);
            //set input required
            $("#amount").prop('required', true);
            //set input disable
            $("#origin").prop('disabled', true);
        }
        if ($(this).val() == "withdraw") {
            //set input enable
            $("#origin").prop('disabled', false);
            $("#amount").prop('disabled', false);
            //set input required
            $("#origin").prop('required', true);
            $("#amount").prop('required', true);
            //set input disable
            $("#destination").prop('disabled', true);
        }
        if ($(this).val() == "transfer") {
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
