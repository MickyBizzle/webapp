$(document).ready(function() {
  $('.start_stop').click(function() {
    title = $('.title_in').val().trim();
    if (title == "") {
      $('.title_in').addClass('border border-danger rounded').css('animation', 'shake 0.3s');
    }
  });
  $('.title_in').click(function() {
    $('.title_in').removeClass('border border-danger rounded').css('animation', 'none');
  });
});
