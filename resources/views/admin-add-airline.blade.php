<html>
<head>
    <link rel="stylesheet" href="{!! asset('bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <title>Админ панель</title>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Добавить рейс <span class="sr-only">(current)</span></a></li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
    <div class="container">
        <h1>
            Добавить рейс
        </h1>
        <form style="margin-bottom: 0px; margin-left: auto; margin-right: auto;" id="ticketform" class="form-horizontal" method="post" action="/api/flight">
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-sm-3">Откуда </label>
                    <select form="ticketform" name="from" class="selectpicker col-sm-3" >
                        @foreach ($countries as $country)
                            <optgroup label="{{ $country->name }}" data-max-options="1">
                                @foreach ($country->cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Куда </label>
                    <select form="ticketform" name="to" class="selectpicker col-sm-3" >
                        @foreach ($countries as $country)
                            <optgroup label="{{ $country->name }}" data-max-options="1">
                                @foreach ($country->cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Самолет </label>
                    <select form="ticketform" name="aircraft" class="selectpicker col-sm-3" >
                        @foreach ($aircrafts as $aircraft)
                            <option value="{{ $aircraft->id }}">{{ $aircraft->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Класс </label>
                    <select form="ticketform" name="class" class="selectpicker col-sm-3" >
                            <option value="E">Econom</option>
                            <option value="B">Business</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" >Код рейса </label>
                    <div class="col-sm-3">
                        <input placeholder="Рейс" form="ticketform" class="form-control" name="airline" id="airline">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Цена </label>
                    <div class="col-sm-3">
                        <input placeholder="Цена" form="ticketform" class="form-control" name="price" id="price">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Даты отправления </label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" name="daterange" value="2017/10/10 - 2017/10/11" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                        <button class="btn btn-primary col-sm-12" name="submit" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{!! asset('bootstrap/js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
    $(function() {
        $( "#ticketform" ).submit(function( event, data ) {
            alert( "Handler for .submit() called." );
            // event.preventDefault();
            console.log( $( this ).serialize() );
        });
        $('input[name="daterange"]').daterangepicker({
            timePickerIncrement: 30,
            timePicker24Hour: true,
            timePicker: true,
            locale: {
                format: 'YYYY/MM/DD HH:mm'
            }
        });
    });
</script>

</html>