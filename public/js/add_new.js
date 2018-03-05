var isRecording = false;
var firstData = true;
var expId;
var oldLength = 0;

$(document).ready(function() {
  //Reset validation when title input is clicked
  $('.title_in').click(function() {
    $('.title_in').removeClass('border border-danger rounded').css('animation', 'none');
  });

  //Ajax request to start experiment capture
  $('.start_stop').click(function() {
    // If not recording, check title has been entered and then start recording
    if ($(this).html() == "Start") {
      title = $('.title_in').val().trim();
      if (title == "") {
        $('.title_in').addClass('border border-danger rounded').css('animation', 'shake 0.3s');
      }
      else {
        startRecord(title);
      }
    }
    // If recording, stop recording
    else {
      stopRecording();
    }
  });

  // If tries to leave window whilst recording, ask to confirm
  $(window).bind('beforeunload', function() {
    if (isRecording) {
      return confirm();
    }
  });

  // Sends request to stop recording when user leaves window
  window.onunload = function() {
    $.ajax({
      method:"GET",
      url:"http://svmib26.dcs.aber.ac.uk/webapp/public/stop_record",
      async:false
    });
  }
});

var dataInterval;

function startGetData() {
  dataInterval = setInterval(function(){ getData() }, 1000);
}

function endGetData() {
  clearInterval(dataInterval);
  $('.timer').stopwatch('stop');
}

function getData() {
  $.ajax({
    method: "POST",
    data: {'getTimeStarted': firstData, 'id': expId},
    url: "http://svmib26.dcs.aber.ac.uk/webapp/public/get_data",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data) {
      data = JSON.parse(data);
      // console.log(data.data);
      length = data.data.length;
      if (firstData && data.startTime) {
        $('#started div').remove();
        $('#started').append(" " + data.startTime);
        $('.timer').stopwatch().stopwatch('start');
        firstData = false;
      }
      if (length > oldLength) {
        $('#status').removeClass("bg-danger").addClass("bg-success").html("YES");
        oldLength = length;
      }
      else {
        $('#status').removeClass("bg-success").addClass("bg-danger").html("NO");
      }
    },
    error: function(error) {
      console.log(error);
    },
  });
}


// Send get request to start recording and then show toast message with warming and change css of Start button
function startRecord(title) {
  $.ajax({
    method: "POST",
    url:"http://svmib26.dcs.aber.ac.uk/webapp/public/start_record",
    data: {"title": title},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data) {
      data = JSON.parse(data);
      expId = data.id;
      if (data.id) {
        $('.start_stop').removeClass('btn-success').addClass('btn-danger').html("Stop");
        isRecording = true;
        startGetData();
        $('.title_in').prop('disabled', true);
        warningToast("Warning!", "Leaving the page will stop recording");
      }
    },
    error: function(error) {
      if (JSON.parse(error.responseText).message == "title_exists") {
        $('.title_in').addClass('border border-danger rounded').css('animation', 'shake 0.3s');
        errorToast("Error!", "Title already exists.");
      }
    }
  });
}

// Send get request to stop recording and then change css of Stop button
function stopRecording() {
  $.get("http://svmib26.dcs.aber.ac.uk/webapp/public/stop_record", function(data) {
    if (data[0].is_recording == 0) {
      $('.start_stop').removeClass('btn-danger').addClass('btn-success').html("Start");
      isRecording = false;
      endGetData();
    }
  })
}

// Jquery toast with custom message
function errorToast(heading, message) {
  $.toast({
    heading: heading,
    text: message,
    icon: "warning",
    position: "top-right",
    bgColor: "#b62937",
    loaderBg: "#ec3345"
  });
}

function warningToast(heading, message) {
  $.toast({
    heading: heading,
    text: message,
    icon: "warning",
    position: "top-right",
    bgColor: "#d5d91b",
    loaderBg: "#f3fe7a"
  });
}
