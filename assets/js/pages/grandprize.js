var participants = [];
var flag = true;

$(function() {

    get_participant();

    // EVENT TOMBOL START

    $('#btnStart').on('click', function (e) {
        e.preventDefault();

        if ( participants && participants != 0 ) {
            if ( flag === true ) {
                flag = false;
                AniDice();
                $('#div_result').text('');
                $('#btnStart').text('Stop');
                $('#btnNext').data('id', 0);
            }else{
                var participant_id;

                $.ajax({
                    url: base_url + 'grandprize/get_result',
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        stopDice();
                        participant_id = data.result_id;
                        $('#name_result').text(data.result_name.toUpperCase());
                        $('#div_result').text(data.result_div.toUpperCase());
                        $('#wa_result').text(data.result_wa.toUpperCase());
                        $('#participant_pic').attr('src', base_url + data.result_pic);
                        flag = true;
                        $('#btnStart').text('Start');
                        $('#btnNext').data('id', participant_id);
                    }
                });
            }
        }

    });

    // #####################################################
    // EVENT TOMBOL NEXT

    $('#btnNext').on('click', function (e) {
        e.preventDefault();

        var participant_id = $(this).data('id');
        console.log(participant_id);

        if ( participants && participants != 0 ) {  
            $.ajax({
                url: base_url + 'grandprize/save_tr',
                data: {
                    'participant_id': participant_id
                },
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    $('#name_result').text('');
                    $('#div_result').text('');
                    $('#wa_result').text('');
                    $('#participant_pic').attr('src', '');
                    flag = true;
                    $('#btnNext').data('id', 0);
                    get_participant();
                }
            });
        }
    });

    // #####################################################
    // EVENT TOMBOL RESET

    $('#btnReset').on('click', function (e) {
        e.preventDefault();
        $('#name_result').text('');
        $('#div_result').text('');
        $('#wa_result').text('');
        $('#participant_pic').attr('src', '');
        flag = true;
        $('#btnNext').data('id', 0);        
    });

    // #####################################################

    $(document).keydown(function(e) {

        if (e.keyCode == 113) {
            e.preventDefault();
            if (flag === true) {
                flag = false;
                AniDice();
                $('#div_result').text('');
                $('#btnStart').text('Stop');
                $('#btnNext').data('id', 0);
            }
        } else if (e.keyCode == 114) {
            e.preventDefault();
            if (flag === false) {

                var participant_id;
                $.ajax({
                    url: base_url + 'grandprize/get_result',
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        stopDice();
                        participant_id = data.result_id;
                        $('#name_result').text(data.result_name.toUpperCase());
                        $('#div_result').text(data.result_nip.toUpperCase());
                        $('#wa_result').text(data.result_wa.toUpperCase());
                        flag = true;
                        $('#btnStart').text('Start');
                        $('#btnNext').data('id', participant_id);
                    },
                });

                flag = true
            }
        }
    });

    Pusher.logToConsole = true;

    var pusher = new Pusher('57b1c37d7c00671cbe6f', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('channel1');
    channel.bind('event', function(data) {

        if (data.message == 'start') {
            AniDice();
            $('#div_result').text('');
        }

        if (data.message == 'stop') {

            var participant_id;
            $.ajax({
                url: base_url + 'grandprize/get_result',
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    stopDice();
                    participant_id = data.result_id;
                    $('#name_result').text(data.result_name.toUpperCase());
                    $('#div_result').text(data.result_nip.toUpperCase());
                    $('#wa_result').text(data.result_wa.toUpperCase());
                },
                complete: function() {
                    $.ajax({
                        url: base_url + 'grandprize/save_tr',
                        data: {
                            'participant_id': participant_id
                        },
                        type: 'POST',
                        dataType: 'JSON',
                        success: function(data) {
                            console.log(data);
                        }
                    });
                }
            });

        }

        if (data.message == 'selected_result') {
            var participant_id;
            stopDice();
            participant_id = data.data.result_id;
            $('#name_result').text(data.data.result_name.toUpperCase());
            $('#div_result').text(data.data.result_nip.toUpperCase());
            $('#wa_result').text(data.result_wa.toUpperCase());
            $.ajax({
                url: base_url + 'grandprize/save_tr',
                data: {
                    'participant_id': participant_id
                },
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                }
            });
        }

    });

    function get_participant() {
        $.ajax({
            url: base_url + 'grandprize/get_participant',
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                participants = data;
            }
        });
    }

    function AniDice() {
        MyVar = setInterval(rolldice, 30)
    }

    function rolldice() {
        var ranNum = Math.floor(Math.random() * participants.length);
        $('#name_result').text(participants[ranNum].participant_name.toUpperCase());
        $('#div_result').text(participants[ranNum].participant_div.toUpperCase());
        $('#wa_result').text(participants[ranNum].participant_wa.toUpperCase());
    }

    function stopDice() {
        clearInterval(MyVar);
    }

});