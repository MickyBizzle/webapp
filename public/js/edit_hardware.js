$(document).ready(function() {
  window.onunload = function() {
    $.ajax({
      method:"GET",
      url:"http://svmib26.dcs.aber.ac.uk/webapp/public/logout",
      async:false
    });
  }
});
