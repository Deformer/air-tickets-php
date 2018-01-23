<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <title>Заказ</title>
</head>
<body>
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Система бронирования билетов</a>
</nav>
<div id="app">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div style="padding: 0px" class="card-block">
                        <div class="card-header">
                            <h2 class="card-title"> Заказ №{{ $order->id }}</h2>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Поездка из: {{ $order->fromCity->name}} в {{ $order->toCity->name }} </li>
                            @if ($order->hasDiscounts)
                                <li class="list-group-item">В данном пути есть сезонные скидки!</li>
                                <li class="list-group-item">Общая цена с учетом скидок: {{ $order->wholePriceWithDiscounts }}$</li>
                            @else
                                <li class="list-group-item">Общая цена поездки: {{ $order->wholePrice }}$</li>
                            @endif
                            <li class="list-group-item">Общее время в пути: {{ $order->wholeTimeInRoute }}</li>
                            @if ($order->ticketsNumber > 1)
                                <li class="list-group-item">Количество пересадок: {{ $order->ticketsNumber - 1 }}</li>
                            @else
                                <li class="list-group-item">Прямой рейс</li>
                            @endif
                        </ul>
                        <h4 class="col-sm-12">Информация о пользователе</h4>
                        <table class="display tables" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>ФИО</th>
                                <th>Возраст</th>
                                <th>Пол</th>
                                <th>Серия паспорта</th>
                                <th>Номер паспорта</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->person->name }}</td>
                                    <td>{{ $order->person->age }}</td>
                                    @if ($order->person->gender == 'M')
                                        <td>Мужчина</td>
                                    @else
                                        <td>Женщина</td>
                                    @endif
                                    <td>{{ $order->person->passport_series }}</td>
                                    <td>{{ $order->person->passport_number }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h4 class="col-sm-12">Информация о билетах</h4>
                        <table class="display tables" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Рейс</th>
                                <th>Класс</th>
                                <th>Цена $</th>
                                <th>Количество доступных билетов</th>
                                <th>Самолет</th>
                                <th>Откуда</th>
                                <th>Куда</th>
                                <th>Время вылета</th>
                                <th>Время прилета</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->tickets as $flight)
                                <tr>
                                    <td style="display: none;" class="ticketId">{{ $flight->id }}</td>
                                    <td>{{ $flight->airline }}</td>
                                    <td>{{ $flight->class }}</td>
                                    @if ($flight->hasDiscount)
                                        <td><s>{{ $flight->price }}</s> {{ $flight->priceWithDiscount }}</td>
                                    @else
                                        <td>{{ $flight->price }}</td>
                                    @endif
                                    <td>{{ $flight->number_of_tickets }}</td>
                                    <td>{{ $flight->aircraft->name }}</td>
                                    <td>{{ $flight->from->name }}</td>
                                    <td>{{ $flight->to->name }}</td>
                                    <td>{{ $flight->time_start }}</td>
                                    <td>{{ $flight->time_end }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
    $(function() {
        $(document).ready(function() {
            $('.tables').DataTable({
                searching: false,
                paging: false,
                bPaginate: false,
                bInfo: false,
                ordering: false
            });
        } );
    });
</script>

</html>