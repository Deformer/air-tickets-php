<html>
<head>
    <link rel="stylesheet" href="{!! asset('bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
</head>
<body>
<div id="app">
    <div class="container">
        <h2>Список доступных путей из {{ $fromCity->name }} в {{ $toCity->name }}</h2>
        @foreach($routes as $key=>$route)
            <h3>Доступный путь {{ $key+1 }}</h3>
            <p>Общая цена поездки: {{ array_reduce($route, function($carry, $item) {return $carry += $item->price;}) }}$</p>
            <button id="{{ $key }}" style="margin-bottom: 10px" type="button" class="btn btn-success choose-button">Выбрать</button>
            <table id="table{{ $key }}" class="display tables" cellspacing="0" width="100%">
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
                @foreach($route as $flight)
                    <tr>
                        <td style="display: none;" class="ticketId">{{ $flight->id }}</td>
                        <td>{{ $flight->airline }}</td>
                        <td>{{ $flight->class }}</td>
                        <td>{{ $flight->price }}</td>
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
        @endforeach
    </div>



</div>
</body>
<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{!! asset('bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script>
    function chooseTicketsRequest(tickets) {
        $.ajax({
            type: "POST",
            url: "/api/choose-tickets",
            data: { tickets : tickets},
            dataType: 'json',
            success: function(data) {
                var orderId = data.id;
                location.href = '/order-page/' + orderId;
            }
        })
    }

    function getTicketsIdsByTableId(tableId) {
        var tickets = [];
        $(tableId + ' tr').each(function() {
            var ticketId = $(this).find(".ticketId").html();

            if (ticketId) {
                tickets.push(parseInt(ticketId));
            }
        });
        return tickets;
    }

    $(function() {
        $(document).ready(function() {
            $('.tables').DataTable();
        } );

        $('.choose-button').on('click', function() {
            var id = $(this).attr('id');
            var tableId = '#table' + id;
            var tickets = getTicketsIdsByTableId(tableId);

            chooseTicketsRequest(tickets);
        })
    });
</script>

</html>