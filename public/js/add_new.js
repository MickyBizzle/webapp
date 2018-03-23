var isRecording = false;
var firstData = true;
var expId;
var oldLength = 0;
var data_array = [];

$(document).ready(function() {
  google.charts.load('current', {packages: ['line']});
  // google.charts.setOnLoadCallback(drawChart);
  //Reset validation when title input is clicked
  $('.title_in').click(function() {
    $('.title_in').removeClass('border border-danger rounded').css('animation', 'none');
  });

  //Ajax request to start experiment capture
  $('.start_stop').click(function() {
    // If not recording, check title has been entered and then start recording
    if ($(this).html() == "Start") {
      title = $('.title_in').val().trim();
      trainingData = +$('.is_training_data').is(":checked");
      if (title == "") {
        $('.title_in').addClass('border border-danger rounded').css('animation', 'shake 0.3s');
      }
      else {
        startRecord(title, trainingData);
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

  $('.modal .save').click(function() {
    if ($('input[name=emotion]:checked').val()) {
      $.ajax({
        method: "POST",
        url: "http://svmib26.dcs.aber.ac.uk/webapp/public/add_emotion",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'id': expId, 'emotion': $('input[name=emotion]:checked').val()},
        success: function() {
          $('#emotionModal').modal('hide');
        },
        error: function(e) {
          console.log(e);
        }
      });
    }
    else {
      $('.modal .row .errMsg').remove();
      $('.modal .row').append('<p class="errMsg text-danger">Please select an option</p>');
    }
  });

  $('.modal .close').click(function() {
    if (confirm('Closing without an option defaults it to N/A and it will not be used for training. This can be changed in the "View Previous" section.')) {
      $('#emotionModal').modal('hide');
    }
  });
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
    url: "http://svmib26.dcs.aber.ac.uk/webapp/public/get_data",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {'getTimeStarted': firstData, 'id': expId},
    success: function(data) {
      data = JSON.parse(data);
      length = data.length;
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
      if (data.data.length != 0) {
        drawChart(data.data);
      }
    },
    error: function(error) {
      console.log(error);
    },
  });
}


// Send get request to start recording and then show toast message with warming and change css of Start button
function startRecord(title, trainingData) {
  $.ajax({
    method: "POST",
    url:"http://svmib26.dcs.aber.ac.uk/webapp/public/start_record",
    data: {"title": title, "isTrainingData": trainingData},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data) {
      console.log(data);
      data = JSON.parse(data);
      expId = data.id;
      if (data.id) {
        $('.start_stop').removeClass('btn-success').addClass('btn-danger').html("Stop");
        isRecording = true;
        startGetData();
        $('.title_in').prop('disabled', true);
        $('.is_training_data').prop('disabled', true);
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

// Send post request to stop recording, passing in time elapsed, and then change css of Stop button
function stopRecording() {
  $.ajax({
    method: "POST",
    url: "http://svmib26.dcs.aber.ac.uk/webapp/public/stop_record",
    data: {'time': $('.timer').html(), 'id': expId},
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data) {
      console.log(data);
      if ($('.is_training_data').is(':checked')) {
        $('#emotionModal').modal('show');
      }
      if (data[0].is_recording == 0) {
        $('.start_stop').removeClass('btn-danger').addClass('btn-success').html("Start");
        $('#status').removeClass("bg-success").addClass("bg-danger").html("NO");
        isRecording = false;
        endGetData();
      }
    },
    error: function(error) {
      console.log(error);
    }
  });
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


function drawChart(exp_data) {
  data_array = [];
  exp_data = exp_data.reverse();
  // console.log(exp_data);

  $.each(exp_data, function(index, value) {
    var tempArr = [index+1];
    $.each(JSON.parse(value.data), function(index, value) {
      tempArr.push(parseFloat(value.value));
    });
    data_array.push(tempArr);
  });


  // Define the chart to be drawn.
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'Past Ten Seconds');
  data.addColumn('number', 'Beats Per Minute');
  data.addColumn('number', 'Skin Temperature');
  data.addColumn('number', 'Galvanic Skin Resistance');

  data.addRows(data_array);

  var options = {
    chart: {
      title: 'Results',
      legend: { position: 'bottom' },
    }
  };

  // Instantiate and draw the chart.
  var chart = new google.charts.Line($('.data_chart')[0]);
  chart.draw(data, google.charts.Line.convertOptions(options));
}
