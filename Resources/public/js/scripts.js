$(function () {

  function moveTag(tag) {

    var action = tag.hasClass('btn-primary') ? 'remove' : 'add';
    var manager = $('#tagGroupManager');

    $.ajax({
      type: "POST",
      url: manager.data('url-' + action),
      data: {
        kunstmaan_tag_group_type: {
          group: manager.data('group-id'),
          tag: tag.data('id')
        }
      },
      success(){
        tag.toggleClass('btn-default');
        tag.toggleClass('btn-primary');
      },
      beforeSend(){
        tag.attr('disabled', true);
      },
      complete(){
        tag.attr('disabled', false);
      }
    });
  }

  $('.tags').on('click', 'li', function () {
    moveTag($(this));
  });

});
