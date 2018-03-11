var id;
var shouldRefresh = false;

$(document).ready(function() {
  $('.edit').click(function(event) {
    event.preventDefault();
    id = this.id;
    $('#titleModal').modal('show');
    $('.modal-input-title').val($(this).attr('title'));
  });

  $('#titleModal .save').click(function() {
    $('.error_msg').remove();
    $('.modal-input-title').removeClass('border border-danger rounded').css('animation', 'none');
    $.ajax({
      method: 'POST',
      url: "http://svmib26.dcs.aber.ac.uk/webapp/public/update_title",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {'id': id, 'title': $('.modal-input-title').val()},
      success: function(data) {
        if (data == 1) {
          $('#titleModal').modal('hide');
          shouldRefresh = true;
        }
      },
      error: function(error) {
        console.log(error);
        if (error.responseJSON.message == "title_exists") {
          $('.modal-body').append("<span class='error_msg'>Title already exists</span>");
        }
        if (error.responseJSON.message == "no_title") {
          $('.modal-body').append("<span class='error_msg'>Please enter a title</span>");
        }
        if (error.responseJSON.message == "title_exists" || error.responseJSON.message == "no_title") {
          $('.modal-input-title').addClass('border border-danger rounded').css('animation', 'shake 0.3s');
        }
      }
    });
  });

  $('#titleModal').on('hidden.bs.modal', function() {
    if (shouldRefresh) {
      location.reload();
    }
    $('.error_msg').remove();
    $('.modal-input-title').removeClass('border border-danger rounded').css('animation', 'none');
  });
});
