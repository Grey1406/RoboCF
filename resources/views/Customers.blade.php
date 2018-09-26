<!-- resources/views/Customers.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laravel-docker-cash-flow</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <nav class="navbar navbar-default">
        <!-- Содержимое Navbar -->
    </nav>
</div>
<!-- Bootstrap шаблон... -->

<div class="panel-body ml-5">
    <!-- Отображение ошибок проверки ввода -->
    @include('common.errors')

    @if(session('message-success'))
        <div class="row alert alert-success col-md-4">
            {{session('message-success')}}
        </div>
    @endif
    @if(session('message-fail'))
        <div class="row alert alert-danger col-md-4">
            {{session('message-fail')}}
        </div>
    @endif

    @if (count($customers) == 0)
        <div class="panel-heading">
            еще нет клиентов
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <p>Текущее состояние пользователей</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table border="1">
                    <tr>
                        <td>id пользователя</td>
                        <td>имя пользователя</td>
                        <td>баланс</td>
                        <td>последняя транзакция</td>
                    </tr>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>
                                {{$customer->id}}
                            </td>
                            <td>
                                {{$customer->name}}
                            </td>
                            <td>
                                {{$customer->balance}}
                            </td>
                            <td>
                                {{$customer->LastTransaction}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <p>Планирование новой транзакции</p>
            </div>
        </div>
        <form action="{{ url('cash') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-1"><p>Выбор отправителя</p></div>
                <div class="col-md-1"><p>Выбор получателя</p></div>
                <div class="col-md-1"><p>Ввод суммы</p></div>
                <div class="col-md-1"><p>Выбор даты</p></div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <select title="Выбор отправителя" name="sender">
                        @foreach ($customers as $customer)
                            @if(old('sender')==$customer->id)
                                <option label={{ $customer->name }} value={{ $customer->id}} selected></option>
                            @else
                                <option label={{ $customer->name }} value={{ $customer->id}}></option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select title="Выбор отправителя" name="receiver">
                        @foreach ($customers as $customer)
                            @if(old('receiver')==$customer->id)
                                <option label={{ $customer->name }} value={{ $customer->id}} selected></option>
                            @else
                                <option label={{ $customer->name }} value={{ $customer->id}}></option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <input title="Ввод суммы" type="number" size="2" name="amount" min="1" max="1000000"
                           value={{old('amount')?old('amount'):'200'}} step="0.5" required>
                </div>
                <div class="col-md-1">
                    <input title="Выбор даты" name="datetime" type="datetime-local"
                           value="{{old('datetime')?old('datetime'):$date}}">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-default" name="button">
                        <i class="fa fa-plus"></i>Перевести денежку
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
</body>
</html>