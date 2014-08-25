$(function() {
  $('#submit_button').click (function () {
    if (confirm ('送出?')) {
      $(this).parents ('form').submit ();
    }
  });
});