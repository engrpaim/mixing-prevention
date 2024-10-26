<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Check Mixing</title>
</head>
<body>
    <div class="flex items-center justify-end h-24 max-w-full bg-gray-100 outline outline-1 outline-gray-300 md:min-w-full sm:me-48 sm:px-64" >
        <x-nav title="Add model" route="add" isLast="" tooltip="Insert new model"/>
        <x-nav title="Update details" route="sections" isLast="" tooltip="Update material and processes"/>
        <x-nav title="Check mixing" route="check" isLast="" tooltip="show or check mixing models"/>
        <x-home-button/>
    </div>
    you are in mixing page!
</body>
</html>
