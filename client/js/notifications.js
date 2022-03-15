;(function ($) {
  $(window).on("load", function(){
    $.ajax({
      type: 'GET',
      url: '/violatordata',
      data: {
        'isAjax': 1
      }
    })
      .done(function (response) {
        $('.violators').html(response)
      })
      .fail(function (xhr) {
        console.log('Error: ' + xhr.responseText);
      });
  });
})(jQuery)
