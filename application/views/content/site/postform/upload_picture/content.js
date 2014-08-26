$(function() {
  $('.pf_disable_panel').hide ();

  $pf_pic_area = $('#pf_pic_area').imgLiquid ({verticalAlign: "top"});
  var is_can_cancer = true;

  $('#pf_fileuploader').uploadFile ({
    multiple: false,
    maxFileSize: 1024 * 1024 * 100, //KB
    autoSubmit: true,
    showDone: false,
    showCancel: false,
    showAbort: false,
    fileName: 'picture',
    maxFileCount: 1,
    method: 'post',
    formData: {'a': 'b'},
    enctype: 'multipart/form-data',
    returnType: 'json',
    allowedTypes: 'jpg,png,gif',
    url: $('#postform_submit_temp_picture_url').val (),
    dragDropStr: '<span><b>或將圖片拖甩至此</b></span>',
    multiDragErrorStr: '不允許上傳多張照片！',
    sizeErrorStr: '照片大小不符合！ 最大只能: ',
    onSubmit: function (files) {
      $pf_pic_area.css ({'background': 'rgba(255, 255, 255, 1.00) url(data:image/gif;base64,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) no-repeat center center'});
    },
    onSuccess: function (files, data, xhr) {
      var $img = $pf_pic_area.find ('img');
      if (data.status) {
        $('#postform_picture_ori_url').val (data.url);
        $('#postform_temp_id').val (data.temp_id);
        $img.attr ('src', data.url);        
      } else {
        $.jGrowl (data.message, {theme: 'j_warning', easing: "easeInExpo"});
        $img.attr ('src', $img.data ('ori_src'));        
      }
      $pf_pic_area.imgLiquid ({verticalAlign: "top"});
      // $('.pf_choice_area .ajax-file-upload-statusbar').fadeOut (1000, function () { $(this).remove (); });
    },
    done: function(e,data) {
      console.info (data);
    }
  });
  
  var $pf_tags_area = $('#pf_tags_area');
  if (!$('#pf_tags_area .pf_choice_tag').length)
    $pf_tags_area.text ($pf_tags_area.attr ('placeholder'));
  $('#pf_create_tag_choice').click (function () {
    if (($pf_tag_choice = $('#pf_tag_choice')).val ().trim () != '') {
      if (!$('#pf_tags_area .pf_choice_tag').length)
        $pf_tags_area.text ('').empty ();
      $('<div />').addClass ('pf_choice_tag').text ($pf_tag_choice.val ().trim ()).append ($('<div />').addClass ('pf_choice_tag_cancer').text ('x')).appendTo ($pf_tags_area);
      $pf_tag_choice.val ('');
      $pf_tags_area.append (' ');
    }
  });

  $pf_tags_area.on ('click', '.pf_choice_tag_cancer', function () {
    if (is_can_cancer) {
      $(this).parents ('.pf_choice_tag').remove ();
        if (!$('#pf_tags_area .pf_choice_tag').length)
          $pf_tags_area.text ($pf_tags_area.attr ('placeholder'));      
    }
  });
  $("#pf_tag_choice").keypress (function (e) {
    if ((code = (e.keyCode ? e.keyCode : e.which)) == 13) {
      if ($(this).val ().trim () != '') {
        if (!$('#pf_tags_area .pf_choice_tag').length)
          $pf_tags_area.text ('').empty ();
        $('<div />').addClass ('pf_choice_tag').text ($(this).val ().trim ()).append ($('<div />').addClass ('pf_choice_tag_cancer').text ('x')).appendTo ($pf_tags_area);
        $(this).val ('');
        $pf_tags_area.append (' ');
      }
    }
  });
  
  $('#pf_submit').click (function () {
    if (!(($('#postform_picture_ori_url').val () != '') && ($('#postform_temp_id').val () != '') && ($('#postform_picture_ori_url').val () != 0) && ($('#postform_temp_id').val () != 0))) {
      return $.jGrowl ('請選擇一張照片！', {theme: 'j_warning', easing: "easeInExpo"});
    }

    var $pf_text_ter = null;
    if ($('#pf_text').val ().trim () == '') {
      clearTimeout ($pf_text_ter);
      $('.pf_text_area').addClass ('has-error');
      $pf_text_ter = setTimeout (function () {$('.pf_text_area').removeClass ('has-error')}, 1000);
      return $.jGrowl ('請為你的照片來點敘述吧！', {theme: 'j_warning', easing: "easeInExpo"});
    }

    var $pf_tag_ter = null;
    if (!$('#pf_tags_area .pf_choice_tag').length) {
      clearTimeout ($pf_tag_ter);
      $('.pf_tag_choice').addClass ('has-error');
      $pf_tag_ter = setTimeout (function () {$('.pf_tag_choice').removeClass ('has-error')}, 1000);
      return $.jGrowl ('請為你的照片新增分類吧！', {theme: 'j_warning', easing: "easeInExpo"});
    }

    var text = $('#pf_text').val ().trim (),
        temp_id = $('#postform_temp_id').val (),
        sync_fb = $('#pf_sync_fb').is (":checked"),
        tags = $.makeArray ($('#pf_tags_area .pf_choice_tag').map (function () { var val = $(this).find ('div').remove ().end ().text ().trim (); return val ? val : null; }))
        ;

    if (temp_id && text.length && tags.length) {
      $.ajax ({
        url: $('#submit_picture_url').val (),
        data: { temp_id: temp_id, text: text, tags: tags, sync_fb: sync_fb },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          is_can_cancer = false;
          $(this).bs_button ('loading');
          $('.pf_disable_panel').show ();
          $('.pf_main_area').addClass ('pf_blur');
          $('.pf_choice_area').addClass ('pf_blur');
          $('#pf_create_tag_choice').bs_button ('loading');
          $('#pf_text, #pf_tag_choice').attr ('readonly', true);
        }
      })
      .done (function (result) {
        $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
        setTimeout (function () {
          // if (result.status)
          //   window.location.assign (result.url);
          // else
            location.reload ();
        }, 1000);
        // is_can_cancer = true;
        // $(this).bs_button ('reset');
        // $('.pf_disable_panel').hide ();
        // $('.pf_main_area').removeClass ('pf_blur');
        // $('.pf_choice_area').removeClass ('pf_blur');
        // $('#pf_create_tag_choice').bs_button ('reset');
        // $('#pf_text, #pf_tag_choice').attr ('readonly', false);

      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
      

// console.info (sync_fb);
    // $('#pf_create_tag_choice').bs_button ('loading');
    // $(this).bs_button ('loading');
    // is_can_cancer = false;
    // $('#pf_text, #pf_tag_choice').attr ('readonly', true);
    // $('.pf_disable_panel').show ();
    // $('.pf_choice_area').addClass ('pf_blur');
    // $('.pf_main_area').addClass ('pf_blur');

  });
});