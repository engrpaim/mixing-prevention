<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add model</title>
</head>
<body>
    <form method="POST">
        @csrf
        <label>MODEL:</label>
        <input><br><br>
        <label>WIDTH:</label>
        <input type="number">
        <label >LENGTH:</label>
        <input type="number">
        <label>TICKHNESS:</label>
        <input type="number">
        <br><br>
        <input type="submit" value="ADD MODEL">
    </form>
</body>
</html>
