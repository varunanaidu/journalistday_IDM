$( function () {
	
	var video = document.getElementById('video');

	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {

	    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {

	        video.srcObject = stream;
	        video.play();
	    });
	}

	$('#snap').on('click', function (e) {
		e.preventDefault();
		
		var video = document.getElementById('video');		
		var canvas = document.getElementById('canvas');
		var context = canvas.getContext('2d')

		context.drawImage(video, 0, 0, 450, 480);

		canvas.toBlob( (blob) => {
			const file = new File( [blob], 'participant_pic.png' );
			const dT = new DataTransfer();
			dT.items.add( file );
			document.getElementById('participant_pic').files = dT.files;
		});
	});
	
	$('#registrationForm').on('submit', function(event) {
		event.preventDefault();

    	var formData = new FormData(this);

		$.ajax({
			url : base_url + 'registration/save',
			type : "POST",
			dataType : "JSON",
			cache: false,
			contentType: false,
			processData: false,
			data : formData,
			beforeSend: function () {
				Swal.showLoading();	
			},
			success : function (data) {
				if ( data.type == 'done' ) {
					Swal.fire({
						title: 'Success',
						type: 'success',
						html: data.msg
					}).then( function () {
						window.location.href = base_url + 'registration/registered/' + data.id;
					});
				}else{
					Swal.fire("Failed!", data.msg, "error");
				}
			}
		});
	});
});