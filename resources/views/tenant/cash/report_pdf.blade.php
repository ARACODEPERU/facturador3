@php

    $establishment = $cash->user->establishment;

    $final_balance = 0;
    $cash_income = 0;
    $cash_egress = 0;
    $cash_final_balance = 0;

    $cash_documents = $cash->cash_documents;

    foreach ($cash_documents as $cash_document) {
        //$final_balance += ($cash_document->document) ? $cash_document->document->total : $cash_document->sale_note->total;

        if ($cash_document->sale_note) {
            if ($cash_document->sale_note->currency_type_id == 'PEN') {
                $cash_income += $cash_document->sale_note->total;
                $final_balance += $cash_document->sale_note->total;
            } else {
                $cash_income += $cash_document->sale_note->total * $cash_document->sale_note->exchange_rate_sale;
                $final_balance += $cash_document->sale_note->total * $cash_document->sale_note->exchange_rate_sale;
            }

            if (count($cash_document->sale_note->payments) > 0) {
                $pays = $cash_document->sale_note->payments;

                foreach ($methods_payment as $record) {
                    $record->sum = $record->sum + $pays->where('payment_method_type_id', $record->id)->sum('payment');
                }
            }
        } elseif ($cash_document->document) {
            if ($cash_document->document->currency_type_id == 'PEN') {
                $cash_income += $cash_document->document->total;
                $final_balance += $cash_document->document->total;
            } else {
                $cash_income += $cash_document->document->total * $cash_document->document->exchange_rate_sale;
                $final_balance += $cash_document->document->total * $cash_document->document->exchange_rate_sale;
            }

            if (count($cash_document->document->payments) > 0) {
                $pays = $cash_document->document->payments;

                foreach ($methods_payment as $record) {
                    $record->sum = $record->sum + $pays->where('payment_method_type_id', $record->id)->sum('payment');
                }
            }
        } elseif ($cash_document->expense_payment) {
            if ($cash_document->expense_payment->expense->state_type_id == '05') {
                if ($cash_document->expense_payment->expense->currency_type_id == 'PEN') {
                    $cash_egress += $cash_document->expense_payment->payment;
                    $final_balance -= $cash_document->expense_payment->payment;
                } else {
                    $cash_egress +=
                        $cash_document->expense_payment->payment *
                        $cash_document->expense_payment->expense->exchange_rate_sale;
                    $final_balance -=
                        $cash_document->expense_payment->payment *
                        $cash_document->expense_payment->expense->exchange_rate_sale;
                }
            }
        }
    }

    $cash_final_balance = $final_balance + $cash->beginning_balance;
    //$cash_income = ($final_balance > 0) ? ($cash_final_balance - $cash->beginning_balance) : 0;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte POS - {{ $cash->user->name }} - {{ $cash->date_opening }} {{ $cash->time_opening }}</title>
    <style>
        * {
            font-size: 12px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 2px;
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        td.precio {
            text-align: right;
            font-size: 11px;
        }

        td.cantidad {
            font-size: 11px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }


        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 100%;
            /* max-width: 155px; */
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            margin: 0;
            padding: 0;
        }

        body {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="ticket centrado">
        <h1>Reporte Punto de Venta</h1>
        <table>
            <tr>
                <td class="producto">
                    <p><strong>Empresa: </strong></p>
                </td>
                <td class="producto">
                    <p>{{ $company->name }}</p>
                </td>
            </tr>
            <tr>
                <td class="producto">
                    <p><strong>Fecha reporte: </strong></p>
                </td>
                <td class="precio">
                    <p>{{ date('Y-m-d') }}</p>
                </td>
            </tr>
            <tr>
                <td class="td-custom">
                    <p><strong>Establecimiento: </strong></p>
                </td>
                <td class="producto">
                    <p>{{ $establishment->address }} -
                        {{ $establishment->department->description }} - {{ $establishment->district->description }}</p>
                </td>
            </tr>
            <tr>
                <td class="producto">
                    <p><strong>Vendedor: </strong></p>
                </td>
                <td class="producto">
                    <p>{{ $cash->user->name }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="producto">
                    <p><strong>Fecha y hora apertura: </strong>{{ $cash->date_opening }} {{ $cash->time_opening }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="producto">
                    <p><strong>Estado de caja: </strong>{{ $cash->state ? 'Aperturada' : 'Cerrada' }}</p>
                </td>
            </tr>
            @if (!$cash->state)
                <tr>

                    <td colspan="2" class="producto">
                        <p><strong>Fecha y hora cierre: </strong>{{ $cash->date_closed }} {{ $cash->time_closed }}</p>
                    </td>

                </tr>
            @endif
            <tr>
                <td colspan="2" class="td-custom" style="text-align: center">
                    <p><strong>Montos de operación: </strong></p>
                </td>
            </tr>
            <tr>
                <td class="td-custom">
                    <p><strong>Saldo inicial: </strong>S/. {{ number_format($cash->beginning_balance, 2, '.', '') }}
                    </p>
                </td>
                <td class="td-custom">
                    <p><strong>Ingreso: </strong>S/. {{ number_format($cash_income, 2, '.', '') }} </p>
                </td>
            </tr>
            <tr>
                <td class="td-custom">
                    <p><strong>Saldo final: </strong>S/. {{ number_format($cash_final_balance, 2, '.', '') }} </p>
                </td>
                <td class="td-custom">
                    <p><strong>Egreso: </strong>S/. {{ number_format($cash_egress, 2, '.', '') }} </p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
