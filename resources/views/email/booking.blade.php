<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Schedule Confirmation</title>
    <meta name="description" content="Meeting Schedule Confirmation Email">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f3f8;
            font-family: 'Open Sans', sans-serif;
        }
        .email-container {
            max-width: 670px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 3px;
            box-shadow: 0 6px 18px rgba(0,0,0,.06);
            padding: 40px;
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }
        .email-header h1 {
            color: #1e1e2d;
            font-size: 32px;
            margin: 0;
            font-weight: 400;
            font-family: 'Rubik', sans-serif;
        }
        .email-body {
            text-align: center;
        }
        .email-body p {
            font-size: 16px;
            color: #1e1e2d;
            margin: 10px 0;
        }
        .email-footer {
            text-align: center;
            padding-top: 20px;
            color: #9a9a9a;
            font-size: 14px;
        }
        .email-footer a {
            color: #3734a9;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <table class="email-container" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="email-header">
                    <h1>Meeting Schedule Confirmation</h1>
                </div>
                <div class="email-body">
                    <p>Name {{ $timeSlot->name }},</p>
                    <p>Email {{ $timeSlot->email }},</p>
                    <p>Phone {{ $timeSlot->phone }},</p>
                    
                    <p><strong>Date:</strong> {{ $meeting_date }}</p>
                    <p><strong>Time Slot:</strong> {{ $timeSlot->time_slots }}</p>
                   
                </div>
                <div class="email-footer">

                    <p><a href="{{ url('/') }}">Visit our website</a></p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
