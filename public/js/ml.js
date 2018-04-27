$(document).ready(function() {
  $('.train').click(function() {
    $.ajax({
      method: "GET",
      url: url.replace('/ml_test', '') + '/ml_train',
      timeout: 0,
    });

  });
});
