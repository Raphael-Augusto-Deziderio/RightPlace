<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Right Place</title>
        <meta charset="utf-8">

        {{--JQUERY CDN--}}
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

        {{--MAIN CSS--}}
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    </head>

    <body>
        <h1>RIGHT PLACE</h1>
        <section class="container flex">
            <div class="item">
                <input type="text" name="searchHotel" id="searchHotel" placeholder="here are you going to travel?">
            </div>
            <div class="item">
                <select id="orderBy">
                    <option value="proximity">Proximity</option>
                    <option value="pricepernight">Price Per Nigth</option>
                </select>
            </div>

            <div class="item">
                <button type="submit" id="btnSubmit">Enviar</button>
            </div>
        </section>

            <div id="waiting" class="item"></div>
            <div class="item">
                <div id="rightPlace"></div>
            </div>

    {{--INCLUDE THE JS ARCHIVE--}}
    @include('HotelSearch.js')
    </body>
</html>