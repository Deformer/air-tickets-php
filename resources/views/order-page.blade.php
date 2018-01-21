<html>
<head>
    <link rel="stylesheet" href="{!! asset('bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
</head>
<body>
<div id="app">
    <div class="container">
        <h2>Ваш заказ №{{ $order->id }}</h2>

            @if ($order->hasDiscounts)
                <p>В данном пути есть сезонные скидки!</p>
                <p>Общая цена с учетом скидок: {{ $order->wholePriceWithDiscounts }}</p>
            @else
                <p>Общая цена поездки: {{ $order->wholePrice }}$</p>
            @endif

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
</body>
<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{!! asset('bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script>
    $(function() {
        $(document).ready(function() {
            $('.tables').DataTable();
        } );
    });
</script>

</html>