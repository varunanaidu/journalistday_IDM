$(function() {

    $('#buttonSearch').on('click', function() {
        $('#default-modal').modal('show');

    });
    $("#searchContainer").select2({
    	dropdownParent : $('#default-modal'),
        placeholder: "Type NIP or Name",
        minimumInputLength: 2,
        ajax: {
            url: base_url + "undian/search_participant",
            dataType: "json",
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        allowClear: true
    });

    $('#searchContainer').on('change', function(event) {
        event.preventDefault();

        var nip = $(this).val();
        $.ajax({
            url: base_url + 'undian/search_emp',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'nip': nip
            },
            success: function(data) {
                if (data.type == 'done') {
                    $('#nip').css('display', 'none');

                    $('#buttonSearch').css('display', 'none');
                    $('#default-modal').modal('hide');

                    $('#btn-start').removeAttr('style');
                    $('#emp_id').val(data.data.result_id);
                    $('#name_result').text(data.data.result_name.toUpperCase());
                    $('#information_result').text(data.data.result_nip.toUpperCase() + ' (' + data.data.result_department.toUpperCase() + ')');

                    $('#present_name').text('');
                    $('#present_image').data('src', '');
                    $('#present_image').attr('src', '');
                } else {
                    Swal.fire({
                        title: 'Failed !',
                        text: data.msg,
                        type: 'error',
                        timer: 1500,
                        showCancelButton: false,
                        showConfirmButton: false,
                    }).then(function() {
                        $('#nip').val('');
                        $('#nip').focus();
                    });
                }
            }
        });
    });

    var present = [];
    var flag = true;
    $('#nip').focus();
    refresh_present();

    $('#nip').keydown(function(event) {

        if (event.keyCode == 13) {
            event.preventDefault();

            var nip = $('#nip').val();

            $.ajax({
                url: base_url + 'undian/search_emp',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'nip': nip
                },
                success: function(data) {
                    if (data.type == 'done') {
                        $('#nip').css('display', 'none');
                    	$('#buttonSearch').css('display', 'none');
                        $('#btn-start').removeAttr('style');
                        $('#emp_id').val(data.data.result_id);
                        $('#name_result').text(data.data.result_name.toUpperCase());
                        $('#information_result').text(data.data.result_nip.toUpperCase() + ' (' + data.data.result_department.toUpperCase() + ')');

                        $('#present_name').text('');
                        $('#present_image').data('src', '');
                        $('#present_image').attr('src', '');
                    } else {
                        Swal.fire({
                            title: 'Failed !',
                            text: data.msg,
                            type: 'error',
                            timer: 1500,
                            showCancelButton: false,
                            showConfirmButton: false,
                        }).then(function() {
                            $('#nip').val('');
                            $('#nip').focus();
                        });
                    }
                }
            });

        }

    });

    $('#btn-start').on('click', function(event) {
        event.preventDefault();

        if (flag === true) {
            $('#btn-start').css('display', 'none');
            $('#btn-stop').removeAttr('style');
            flag = false;
            AniDice();
        }

    });

    $('#btn-stop').on('click', function(event) {
        event.preventDefault();

        if (flag === false) {

            var present_id;
            var emp_id = $('#emp_id').val();

            $.ajax({
                url: base_url + 'undian/get_result',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'emp_id': emp_id
                },
                success: function(data) {
                    stopDice();
                    $('#present_name').text(data.result_name + ' ' + data.result_type);
                    $('#present_image').attr('src', base_url + 'assets/images/prize/' + data.result_image);
                    present_id = data.result_id;
                },
                complete: function() {
                    $.ajax({
                        url: base_url + 'undian/save_doorprize',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            'emp_id': emp_id,
                            'present_id': present_id
                        },
                        success: function(data) {
                            refresh_present();

                            $('#btn-start').css('display', 'none');
                            $('#btn-stop').css('display', 'none');

                            $('#present_id').val('');
                            $('#emp_id').val('');

                            $('#nip').val('');
                            $('#nip').removeAttr('style');
                            $('#nip').focus();

                            $('#buttonSearch').removeAttr('style');
                        },
                    });
                }
            });

            flag = true;
        }

    });

    function refresh_present() {
        $.ajax({
            url: base_url + 'undian/get_present',
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                present = data;
            }
        });
    }

    function AniDice() {
        MyVar = setInterval(rolldice, 15)
    }

    function rolldice() {
        var ranNum = Math.floor(Math.random() * present.length);
        $('#present_id').val(present[ranNum].present_id);
        $('#present_name').text(present[ranNum].present_name.toUpperCase());
    }

    function stopDice() {
        clearInterval(MyVar);
    }
});