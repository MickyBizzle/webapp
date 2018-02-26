isRecording = false;

$(document).ready(function() {
  //Reset validation when title input is clicked
  $('.title_in').click(function() {
    $('.title_in').removeClass('border border-danger rounded').css('animation', 'none');
  });

  //Ajax request to start experiment capture
  $('.start_stop').click(function() {
    if ($(this).html() == "Start") {
      title = $('.title_in').val().trim();
      if (title == "") {
        $('.title_in').addClass('border border-danger rounded').css('animation', 'shake 0.3s');
      }
      else {
        startRecord();
      }
    }
    else {
      stopRecording();
    }
  });

  $(window).bind('beforeunload', function() {
    console.log(isRecording);
    if (isRecording) {
      return "Recording in progress. Navigating away will cause the recording to stop.";
    }
  });
});



function startRecord() {
  $.get("http://svmib26.dcs.aber.ac.uk/webapp/public/start_record", function(data) {
    if (data[0].is_recording == 1) {
      $('.start_stop').removeClass('btn-success').addClass('btn-danger').html("Stop");
      isRecording = true;
    }
  });
}

function stopRecording() {
  $.get("http://svmib26.dcs.aber.ac.uk/webapp/public/stop_record", function(data) {
    if (data[0].is_recording == 0) {
      $('.start_stop').removeClass('btn-danger').addClass('btn-success').html("Start");
      isRecording = false;
    }
  })
}
