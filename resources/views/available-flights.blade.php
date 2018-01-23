<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <title>Список доступных путей</title>
</head>
<body>
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Система бронирования билетов</a>
</nav>
    <div class="container">
        <h2>Список доступных путей из {{ $fromCity->name }} в {{ $toCity->name }}</h2>
        @foreach($routes as $key=>$route)
            <div class="row" style="margin-bottom: 30px;">
                <div  class="card text-center col-sm-4" style="width: 18rem; padding: 0px">
                    <div class="card-header">
                        <h5>Доступный путь {{ $key+1 }}</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @if ($route->hasDiscounts)
                            <li class="list-group-item">В данном пути есть сезонные скидки!</li>
                            <li class="list-group-item">Общая цена с учетом скидок: {{ $route->wholePriceWithDiscounts }}$</li>
                        @else
                            <li class="list-group-item">Общая цена поездки: {{ $route->wholePrice }}$</li>
                        @endif
                        <li class="list-group-item">Общее время в пути: {{ $route->wholeTimeInRoute }}</li>
                        @if ($route->ticketsNumber > 1)
                            <li class="list-group-item">Количество пересадок: {{ $route->ticketsNumber - 1 }}</li>
                        @else
                            <li class="list-group-item">Прямой рейс</li>
                        @endif
                        <li class="list-group-item center-block">
                                <button id="{{ $key }}" style="color: white;" class="btn col-sm-12 btn-primary choose-button">Выбрать</button>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-8">
                    <table id="table{{ $key }}" class="display tables table-bordered" cellspacing="0" width="100%">
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
                        @foreach($route->tickets as $flight)
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
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Что то пошло не так</h4>
                </div>
                <div class="modal-body">
                    <p>Для того, чтобы заказать биллеты, нужно указать личные данные</p>
                </div>
                <div class="modal-footer">
                    <button id="go-reg" class="btn btn-primary">Заполнить личные данные</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
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
    function chooseTicketsRequest(tickets, personId) {
        $.post("/api/choose-tickets", { tickets : tickets, personId: personId }, function (data) {
            var orderId = data.id;
            location.href = '/order-page/' + orderId;
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
            $('.tables').DataTable({
                searching: false,
                paging: false,
                bPaginate: false,
                bInfo: false
            });
        } );

        $('#go-reg').click(function () {
           location.href = '/registration'
        });

        $('.choose-button').on('click', function() {
            var personId = sessionStorage.getItem('personId');
            if (!personId) {
                $("#myModal").modal();
            } else {
                var id = $(this).attr('id');
                var tableId = '#table' + id;
                var tickets = getTicketsIdsByTableId(tableId);

                chooseTicketsRequest(tickets, personId);
            }
        })
    });
</script>

</html>