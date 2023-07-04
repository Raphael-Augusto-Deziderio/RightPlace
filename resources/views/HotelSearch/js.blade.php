<script>
    $(document).ready(function() {
        $('#btnSubmit').click(function() {
            var address = $('#searchHotel').val();
            var orderBy = $('#orderBy').val();

            $.ajax({
                url: "{{url('hotel-search')}}",
                method: 'GET',
                dataType: 'json',
                data: {
                    _method: 'GET',
                    address: address,
                    orderBy: orderBy,
                    _token: '{{csrf_token()}}',
                },
                success: function(response) {
                    console.log(response.distanceFormated);
                    $('#rightPlace').append('<p> Hotel: ' + response.name + '</p>');
                    $('#rightPlace').append('<p> Distante: ' + response.distanceFormated + '</p>');
                    $('#rightPlace').append('<p> Price Per Night: ' + response.pricePerNight + ' EUR</p>');
                },
                error: function(xhr, status, error) {
                    $('#rightPlace').append('<p> ERRO: '  + error + '</p>');
                },
            }).done(function (doneResponse) {
                console.log('doneResponse');
            });

            $('#waiting').append('<p>PLEASE WAIT WHILE WE FIND THE RIGHT PLACE</p>');


        });

    });
</script>