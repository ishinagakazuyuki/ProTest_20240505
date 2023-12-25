<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <span>{{$name}} 様、ご予約のお知らせになります。</span><br>
        <span>スタッフ一同お待ちしておりますので、ぜひお越しください。</span><br><br>
        <span>【ご予約内容】</span><br>
        <span>  ご予約店名：{{$shop}} </span><br>
        <span>  ご予約日時：{{$date}} {{$time}}</span><br>
        <span>  ご予約人数：{{$number}}</span>
    </div>
</body>
</html>
