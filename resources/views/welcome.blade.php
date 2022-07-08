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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
    <!--  Reset  -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#resetAccount">
        Reset
    </button>

    <!-- Modal -->
    <div class="modal fade" id="resetAccount" tabindex="-1" aria-labelledby="resetAccountLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetAccountLabel">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/reset" method="post" name="resetForm" id="resetForm">
                        @csrf
                        <p>Are you sure?</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--  end Reset  -->
    <hr>
    <form action="/balance" method="get">
        <div class="row">
            <div class="col">
                @php
                    $filter = $_GET['filter'] ?? '';
                    $value = $_GET['value'] ?? '';

                @endphp
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="filter" id="filter">
                    @if(isset($_GET['filter']) && isset($_GET['value']))

                    @endif
                    <option
                    value="" {{ $filter == '' ? 'selected' : '' }} >--Chọn--</option>
                    <option value="1" {{ $filter == 1 ? 'selected' : '' }}>Chọn Account ID</option>
                    <option value="2" {{ $filter == 2 ? 'selected' : '' }}>Chọn tiền ></option>
                    <option value="3" {{ $filter == 3 ? 'selected' : '' }}>Chọn tiền <</option>
                    <option value="4" {{ $filter == 4 ? 'selected' : '' }}>Chọn tiền < hoặc =</option>
                    <option value="5" {{ $filter == 5 ? 'selected' : '' }}>Chọn tiền > hoặc =</option>
                </select>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="value" value="{{ $value }}" id="value" placeholder="Search">
                @error('value')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary col-sm-2">Search</button>
        </div>
    </form>
    {{--  @dd($_SERVER["REQUEST_URI"])  --}}
    {{--  @dd($_GET['value'])  --}}

    <table class="table text-center">
        <thead>
            <tr>
                <th>Account ID</th>
                <th>Balance</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($result))
            @foreach ($result as $key => $value)
            <tr>
                @if (isset($value->id) && isset($value->balance))
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->balance }}</td>
                @endif
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
                                    <h5 class="modal-title" id="depositAccounttLabel{{ $value->id }}">Deposit
                                        from
                                        Account ID: {{ $value->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('event') }}" method="post"
                                        name="balanceFormDeposit{{ $value->id }}"
                                        id="balanceFormDeposit{{ $value->id }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
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
                                    <h5 class="modal-title" id="withdrawAccountLabel{{ $value->id }}">Withdraw
                                        from
                                        Account ID: {{ $value->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('event') }}" method="post"
                                        name="balanceFormWithdraw{{ $value->id }}"
                                        id="balanceFormWithdraw{{ $value->id }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="amount"
                                                    id="amount" placeholder="Amount" min="0"
                                                    max="99999999999">
                                            </div>
                                        </div>
                                        <input type="hidden" name="type" id="withdraw" value="withdraw">
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
                                    <h5 class="modal-title" id="transferAccountLabel{{ $value->id }}">Transfer
                                        from
                                        Account ID: {{ $value->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('event') }}" method="post"
                                        name="balanceFormTransfer{{ $value->id }}"
                                        id="balanceFormTransfer{{ $value->id }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="destination"
                                                class="col-sm-2 col-form-label">Destination</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="destination"
                                                    id="destination" placeholder="Destination" min="1"
                                                    max="99999999999999999999">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="amount"
                                                    id="amount" placeholder="Amount" min="0"
                                                    max="99999999999">
                                            </div>
                                        </div>
                                        <input type="hidden" name="type" id="transfer" value="transfer">
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
            @endif

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

    {{--  $("#filter").click(function() {
        let option =$(this).val();
        //getting option clicked value
        if (option == "") {
            //set input no required
            $("#value").prop('required', false);
        } else {
            //set input  required
            $("#value").prop('required', true);
        }
    });  --}}
</script>

</html>
