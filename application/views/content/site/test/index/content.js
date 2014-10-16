$(function() {
    var context = {
        aaa: 'xxxx',
        bbb: 'ss'
    }
    template = $("#template").html ();
    var compiled = _.template (template, context);
    html = compiled (context);
    $('#root').append (html);
});