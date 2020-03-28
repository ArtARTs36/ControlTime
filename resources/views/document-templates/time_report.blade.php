<html>
<head>
<title>
    Посещаемость сотрудника: {{ $worker->getFullName() }}
</title>
</head>

<center style="margin-bottom: 15px; font-weight: bold; font-size:26px">
Посещаемость сотрудника: {{ $worker->getFullName() }}
</center>

<table>
    <tr>
        <td>
            #
        </td>
        <td>
            Дата прихода
        </td>
        <td>
            Время прихода
        </td>
        <td>
            Дата ухода
        </td>
        <td>
            Время ухода
        </td>
        <td>
            Пробыл часов
        </td>
    </tr>

    @foreach($times as $time)
        <tr>
            <td>
                {{ $time->id }}
            </td>
            <td>
                {{ $time->start_date }}
            </td>
            <td>
                {{ $time->start_time }}
            </td>
            <td>
                {{ $time->end_date }}
            </td>
            <td>
                {{ $time->end_time }}
            </td>
            <td>
                {{ $time->getAttendHours() }}
            </td>
        </tr>
    @endforeach
</table>

<style>
    body {
        font-family: calibri, cursive;
    }
    table {
        width: 100%;
        font-size: 14px;
        border-collapse: collapse;
        text-align: center;
    }
    th, td:first-child {
        background: #AFCDE7;
        color: white;
        padding: 10px 20px;
    }
    th, td {
        border-style: solid;
        border-width: 0 1px 1px 0;
        border-color: white;
    }
    td {
        background: #D8E6F3;
    }
    th:first-child, td:first-child {
        text-align: left;
    }
</style>

</html>
