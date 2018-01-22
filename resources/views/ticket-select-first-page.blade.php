<html>
<head>
    <link rel="stylesheet" href="{!! asset('bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <title>Выбор дат и мест для путешествия</title>
</head>
<body>
<div id="app">
    <form style="margin-bottom: 0px; margin-left: auto; margin-right: auto;" id="ticketform" method="get" action="/available-flights">
        <div class="container">
            <h1>
                Выберете места и дату отправления и прилета
            </h1>
            <div class="col-xs-3 ">
                <div class="form-group">
                    <select form="ticketform" name="from" class="selectpicker" >
                        @foreach ($countries as $country)
                            <optgroup label="{{ $country->name }}" data-max-options="1">
                                @foreach ($country->cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3 ">
                <div class="form-group">
                    <select form="ticketform" name="to" class="selectpicker" >
                        @foreach ($countries as $country)
                            <optgroup label="{{ $country->name }}" data-max-options="1">
                                @foreach ($country->cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <input class="form-control" type="text" name="daterange" value="2017/10/10 - 2017/10/11" />

                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group"> <!-- Submit button -->
                    <button class="btn btn-primary " name="submit" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>

    <div class="container">
        <h2>Список доступных рейсов</h2>
        <table id="tickets" class="display tables" cellspacing="0" width="100%">
            <thead>
            <tr>
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
            @foreach($flights as $flight)
                <tr>
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
    <div class="container">
        <h2>Список доступных сезонных скидок</h2>
        <table id="discounts" class="display tables" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Направление</th>
                <th>Скидка %</th>
            </tr>
            </thead>
            <tbody>
            @foreach($discounts as $discount)
                <tr>
                    <td>{{ $discount->city->name }}</td>
                    <td>{{ $discount->discount_percentages }}</td>
            @endforeach
            </tbody>
        </table>
    </div>



</div>
</body>
{{--<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>--}}
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{!! asset('bootstrap/js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            timePickerIncrement: 30,
            locale: {
                format: 'YYYY/MM/DD'
            }
        });

        $(document).ready(function() {
            $('.tables').DataTable();
        } );
    });
</script>

</html>