$(function () {
  showAlert ($('#title').val (), $('#message').val (), function(){window.location.assign ($('#redirect').val ());});
});