$(document).ready(function() {
  $('.training_check').change(function() {
    id = getId(this);
    checked = $(this).is(":checked");
    console.log("noice", id, checked);
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

  $('.response_select').change(function() {
    id = getId(this);
    option = $(this).val();
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
