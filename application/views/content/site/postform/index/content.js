$(function() {
  $('.form-fancybox').fancybox ({
    beforeLoad: function () {
      this.title = $(this.element).data ('fancybox_title');
    },
    padding: 0,
    helpers: {
      overlay: {
        locked: false
      },
      title: {
        type: 'over'
      }
    },
    type: 'ajax',
    width: '70%',
    height: '70%',
    closeClick: false,
    autoSize: false,
    fitToView: false,
  });
});