<!DOCTYPE html>
<html>

<head>
    <title>Active Account</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style type="text/css">
        .container {
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        .content {
            width: 500px;
            border: 2px solid #87553b;
            box-shadow: 0px 30px 60px 0px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            border-radius: 20px;
            text-align: center;
            font-size: 14px;
        }

        .header h3 span {
            color: #87553b;
        }

        .body {
            font-size: 14px;
            font-weight: 600;
            line-height: 22px;
            opacity: .8;
        }

        .body span {
            color: #87553b;
        }

        .content .footer {
            font-size: 14px;
            font-weight: 600;
            opacity: .8;
        }

        .content .footer a {
            border: 2px solid #87553b;
            text-decoration: none;
            color: #87553b;
            border-radius: 20px;
            padding: 10px 40px;
            margin-top: 25px;
            display: inline-block;
        }

        .content .footer a:hover{
            background: #87553b;
            color: #fff;
        }
        .container>.footer {
            font-weight: 600;
            margin-top: 20px;
        }

    </style>
</head>
<div class="container">
    <div class="content en">
        <div class="header">
            <img src="{{ $message->embed(public_path('images/default/logo.svg')) }}" />
            <h3>Hello, <span>{{ $name }}</span></h3>
        </div>
        <div class="body">
            <p>we noticed your'e trying to change your password <br /> on <span>JEEM</span></p>
        </div>

        <div class="footer">
            Click On This Link
            <br>
            <a href="https://jeem-buyer.web.app/renew/{{ $type }}/{{ $token }}">Link</a>
        </div>
    </div>

    <div class="content ar">
        <div class="header">
            <img src="{{ $message->embed(public_path('images/default/logo.svg')) }}" />
            <h3>اهلا بيك, <span>{{ $name }}</span></h3>
        </div>
        <div class="body">
            <p>نريد اعلامك بانك حاولت تغير كلمة المرور الخاصة بك علي <br /> <span>JEEM</span></p>
        </div>

        <div class="footer">
            اضغطت علي هذا الرابط
            <br>
            <a href="https://jeem-buyer.web.app/renew/{{ $type }}/{{ $token }}">Link</a>
        </div>
    </div>

    <div class="footer">
        Thank you for choosing Jeem Company
    </div>
</div>

</body>

</html>
