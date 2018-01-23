<html>
<head>
    <link rel="stylesheet" href="{!! asset('bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <title>Личные данные</title>
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
            <a class="navbar-brand" href="#">Система бронирования билетов</a>
        </div>

    </div><!-- /.container-fluid -->
</nav>

<div class="container">
    <form style="margin-bottom: 0px; margin-left: auto; margin-right: auto;" id="person-form" name="person-form" class="form-horizontal" method="post" action="/api/flight">
        <div class="row">
            <div class="form-group">
                <h1 class="col-sm-offset-3 col-sm-6">
                    Укажите ваши данные
                </h1>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" >ФИО </label>
                <div class="col-sm-3">
                    <input placeholder="Иванов Иван Иванович" for="name" form="person-form" class="form-control" name="name">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3">Возраст </label>
                <div class="col-sm-3">
                    <input placeholder="99" for="age" form="person-form" class="form-control" name="age">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3">Пол </label>
                <select form="person-form" name="gender" class="selectpicker col-sm-3" >
                    <option value="M">Мужской</option>
                    <option value="F">Женский</option>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3">Серия паспорта </label>
                <div class="col-sm-3">
                    <input placeholder="1234" for="passport_series" form="person-form" class="form-control" name="passport_series">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3">Номер паспорта </label>
                <div class="col-sm-3">
                    <input placeholder="123456" for="passport_number" form="person-form" class="form-control" name="passport_number">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-3">
                    <button class="btn btn-primary col-sm-12" name="submit" type="submit">Выбрать билеты</button>
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script>
    $(function() {
        $( "#person-form" ).submit(function( event ) {
            event.preventDefault();
        });

        $("form[name='person-form']").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                name: "required",
                age: {
                    required: true,
                    number: true,
                    min:1
                },
                passport_series: {
                    required: true,
                    minlength: 4,
                    maxlength: 4
                },
                passport_number: {
                    required: true,
                    minlength: 6,
                    maxlength: 6
                }
            },
            // Specify validation error messages
            messages: {
                name: "Обязательно укажите имя",
                age: {
                    required: "Обязательно укажите возраст",
                    number: "Возраст должен быть числом",
                    min: "Возраст должен быть блольше нуля"
                },
                passport_series: {
                    required: "Обязательно укажите серию паспорта",
                    minlength: "Серия паспорта должна быть длиной в 4 символа",
                    maxlength: "Серия паспорта должна быть длиной в 4 символа"
                },
                passport_number: {
                    required: "Обязательно укажите номер паспорта",
                    minlength: "Номер паспорта должен быть длиной в 6 симолов",
                    maxlength: "Номер паспорта должен быть длиной в 6 симолов"
                }
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function() {
                var person = $( "#person-form" ).serializeArray().reduce(function (acc, kv) {
                    acc[kv.name] = kv.value;
                    return acc;
                }, {});

                $.post('/api/person', { person: person }, function(data) {
                    sessionStorage.setItem('personId', data.id);
                    location.href = '/select-tickets';
                })
            }
        });
    });
</script>

</html>