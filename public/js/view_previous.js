$(document).ready(function() {
  $('.training_check').change(function() {
    id = getId(this);
    checked = $(this).is(":checked");
    url = url.replace(/&?show=([^&]$|[^&]*)/i, "");
    url = url.replace(/&?page=([^&]$|[^&]*)/i, "");
    url = url.replace('?', "");
    console.log(url);
    $.ajax({
      method: 'POST',
      url: url + "/update_checked",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {'id': id, 'checked': checked},
      success: function(data) {
        console.log(data);
        location.reload();
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  $('.media_select').change(function() {
    id = getId(this);
    media = $(this).val();
    url = url.replace(/&?show=([^&]$|[^&]*)/i, "");
    url = url.replace(/&?page=([^&]$|[^&]*)/i, "");
    url = url.replace('?', "");
    $.ajax({
      method: 'POST',
      url: url + "/update_media",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {'id': id, 'media': media},
      success: function(data) {
        console.log(data);
        // location.reload();
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  $('.response_select').change(function() {
    id = getId(this);
    option = $(this).val();
    url = url.replace(/&?show=([^&]$|[^&]*)/i, "");
    url = url.replace(/&?page=([^&]$|[^&]*)/i, "");
    url = url.replace('?', "");
    $.ajax({
      method: 'POST',
      url: url + "/update_option",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {'id': id, 'option': option},
      success: function(data) {
        console.log(data);
        // location.reload();
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  function getId(element) {
    return $(element).attr('id')
  }
});
