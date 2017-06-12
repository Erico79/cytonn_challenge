$(function(){
    // Initialize Datatable for available rides
    $('#available_rides').DataTable({
        "columnDefs": [ {
            "targets": 4,
            "orderable": false,
            "searchable": false
        } ]
    });

    // submit modals
    $('button:submit').on('click', function () {
        $(this).parents('div.modal').find('form').submit();
    });

    // logout
    $('#logout').on('click', function () {
        $('#logout-form').submit();
    });

    // get a ride
    $('.book_ride').on('click', function () {
        var ride_id = $(this).attr('ride_id');
        $('#ride_id').val(ride_id);

        $('#get_ride_form').submit();
    });
});
