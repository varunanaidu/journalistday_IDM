function docReady(fn) {
    console.log(document.readyState);
    // see if DOM is already available
    if (document.readyState === "complete" ||
        document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

docReady(function() {
    var resultContainer = document.getElementById('qr-reader-results');
    var nipContainer = document.getElementById('participant_nip');
    var lastResult = '';
    var countResults = 0;

    function onScanSuccess(decodedText, decodedResult) {
        if ( lastResult != decodedText ) {
            ++countResults;
            lastResult = decodedText;
            // Handle on success condition with the decoded message.
            $('#participant_id').val(decodedText);

            $.ajax({
                url: base_url + 'antigen/find',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'key': decodedText
                },
                success: function(data) {
                    if (data.type == 'done') {
                        $('#participant_name').val(data.msg[0].participant_name);
                        $('#dob').val(data.msg[0].dob);
                        $('#ukuran_jersey').val(data.msg[0].ukuran_jersey);
                        $('#category').val(data.msg[0].category);
                        $('#registration_id').val(data.msg[0].registration_id);
                    }
                        /*$('#attendanceForm').trigger('submit');
                    } else {
                        Swal.fire('Failed !', data.msg, 'error');
                        $('#participant_id').val('');
                    }*/
                }
            });

        }
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", {
            fps: 10,
            qrbox: 250
        });
    html5QrcodeScanner.render(onScanSuccess);
});

$(function() {

    $('#btnFind').on('click', function(event) {
        event.preventDefault();

        var participant_id = $('#participant_id').val();
        if (participant_id == '') {
            alert('Isi ID terlebih dahulu');
        }

        $.ajax({
            url: base_url + 'antigen/find',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'key': participant_id
            },
            success: function(data) {
                if (data.type == 'done') {
                    $('#participant_name').val(data.msg[0].participant_name);
                    $('#dob').val(data.msg[0].dob);
                    $('#ukuran_jersey').val(data.msg[0].ukuran_jersey);
                    $('#category').val(data.msg[0].category);
                    $('#registration_id').val(data.msg[0].registration_id);
                } else {
                    Swal.fire('Failed !', data.msg, 'error');
                }
            }
        });
    });

    $('#antigenForm').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: base_url + 'antigen/save_antigen',
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function(data) {
                if (data.type == 'done') {
                    $('#soundSuccess')[0].play();
                    Swal.fire('Success', data.participant_name + '<br>' + data.participant_id + '<br>' + data.ukuran_jersey + '<br>' + data.category, 'success');
                } else {
                    Swal.fire('Failed !', data.msg, 'error');
                }

                $('#participant_id').val('');
                $('#participant_name').val('');
                $('#dob').val('');
                $('#ukuran_jersey').val('');
                $('#category').val('');
            }
        });
    });
});