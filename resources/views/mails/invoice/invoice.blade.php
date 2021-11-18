<!DOCTYPE html>
<html lang="ar">

<head>
    <title>Invoice E-mail</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style type="text/css">
        .invoice {
            margin: 20px 0;
            font-family: 'Cairo', sans-serif;
            box-shadow: 0px 30px 60px 0px rgba(0, 0, 0, 0.1);
            width:900px;
            margin:auto;
        }

        .ar {
            direction: rtl;
        }

        .invoice-logo {
            margin: auto;
            padding: 20px;
            box-shadow: 0px 30px 60px 0px rgba(0, 0, 0, 0.1);
        }

        .invoice-content {
            padding: 20px;
            box-shadow: 0px 30px 60px 0px rgba(0, 0, 0, 0.1);


        }

        .invoice-top {
            background: #94664b;
            color: #fff;
            padding: 20px;
            border-bottom: 2px solid #000;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            display: flex;
            flex-direction: row-reverse
        }

        .company-logo {
            position: relative;
            width: 130px;
            height: 120px;
            border-radius: 20px;
            overflow: hidden;
            line-height: 60px;
        }

        .company-logo::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
            opacity: 0;
        }

        img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }



        .invoice-bottom {
            margin-top: 20px;
        }


        .invoice-buyer-info {
            display: flex;
            justify-content: space-between;
            text-align: center;
            margin: 30px 0;


        }

        .invoice-buyer {
            text-align: right;
        }

        .invoice-buyer span:first-child {
            margin: 0 6px;
            font-weight: 500;
            font-size: 15px;
            width: 115px;
            display: inline-block;
        }

        .invoice-buyer span:last-child {
            font-size: 12px;
            font-weight: 500;
            opacity: .9;
        }

        ul {
            list-style: none;
            margin: 0;
        }

        li {
            text-align: right;

        }

        li span:first-child {
            min-width: 150px;
            display: inline-block;
            margin: 0 6px;
            font-weight: 500;
            font-size: 15px;
        }

        li span:last-child {
            display: inline-block;
            font-size: 13px;
            font-weight: 500;
            text-align: right;
            opacity: .9;
        }

table{
    width:100%;
}
        table tbody tr td {

            font-weight: 500;
            font-size: 13px;
            line-height: 30px;
            text-align: center;
            align-content: center;
            white-space: nowrap;
            border: 1px solid #dee2e6;
        }

        thead tr th {
            padding: 8px;
            color: #fff;
            text-align: center;
            border: 1px solid #fff;
            white-space: nowrap;
            background: #94664b;
            font-weight: 600;
            font-size: 14px;
        }

        .invoice-total {
            display:flex;
            margin-top: 40px;
            padding: 20px;
            justify-content: space-between;
            align-items: center;
            text-align: center;

            .rtl & {
                flex-direction: row-reverse;
            }

        }

        .invoice-total div span:first-child {
            font-size: 14px;
            font-weight: 600;
            margin-right: 5px;
            text-transform: capitalize;
        }

        .invoice-total div span:last-child {
            margin-top: 5px;
            font-size: 13px;
            font-weight: 500;
        }

        .invoice-footer {
            padding: 30px 0;
            font-weight: 500;
            font-size: 14px;
            text-align: center;
            opacity: .8;
        }

    </style>
</head>

<body>
    <div class="invoice ar">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-12 m-auto">
                    <div class="invoice-content mt-5">
                        <div class="invoice-details">
                            <div class="invoice-top">
                                <div class="company-logo">
                                    {{-- <img src={{ $message->embed(storage_path($data ?? ''->c_image)) }} alt="logo" /> --}}
                                </div>
                                <div class="company-name">
                                    <span>اسم الشركة : </span>
                                    <span>{{ $data ?? ''['c_name'] }}</span>
                                </div>
                            </div>

                            <div class="invoice-bottom">
                                <div class="invoice-buyer-info">
                                    <div class="invoice-buyer">
                                        <div>
                                            <span>الي :</span> <span>{{ $data ?? ''['name'] }}</span>
                                        </div>
                                        <div>
                                            <span>العنوان :</span>
                                            <span>{{ $data ?? ''['address'] }}</span>
                                        </div>
                                        <div>
                                            <span>البريد الالكتروني :</span>
                                            <span>{{ $data ?? ''['email'] }}</span>
                                        </div>
                                    </div>

                                    <div class="invoice-info">
                                        <ul>
                                            <li>
                                                <span>تاريخ الفاتورة : </span>
                                                <span>{{ $data ?? ''['create'] }}</span>
                                            </li>
                                            <li>
                                                <span>رقم الفاتورة : </span>
                                                <span>{{ $data ?? ''['code'] }}</span>
                                            </li>
                                            <li>
                                                <span>طرق الدفع : </span>
                                                <span>Cash</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="invoice-orders">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>كود</th>
                                                <th>الاسم</th>
                                                <th>الكمية</th>
                                                <th>السعر</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $data ?? ''['code'] }}</td>
                                                <td>{{ $data ?? ''['product'] }}</td>
                                                <td>{{ $data ?? ''['count'] }}</td>
                                                <td>{{ $data ?? ''['price'] }} ASR</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="invoice-total">
                                <div class="total">
                                    <span>السعر : </span>
                                    <span>{{ $data ?? ''['price'] }} ASR</span>
                                </div>
                                <div class="code">
                                    <span>كود : </span>
                                    <span>&{{ $data ?? ''['in_code'] }}&</span>
                                </div>
                            </div>

                            <div class="invoice-footer">
                                All Data in This Invoice Belongs to Company
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
