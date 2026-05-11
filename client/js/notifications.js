/**
 * @deprecated 3.0.0 AJAX violator loading is deprecated. Use template rendering instead.
 * This file will be removed in version 3.0.0.
 * To disable this warning, set PageController.use_ajax_violators to false in your config.
 */
window.addEventListener('load', function() {
  console.warn(
    'AJAX violator loading is deprecated and will be removed in version 3.0.0. ' +
    'Please use template rendering instead by setting PageController.use_ajax_violators to false.'
  );
  
  var xhr = new XMLHttpRequest();
  var url = '/violatordata?isAjax=1';

  // Append stage=Stage to the URL if not already present
  var currentUrl = new URL(window.location.href);
  var params = currentUrl.searchParams;

  if (params.has('stage') && params.get('stage') === 'Stage') {
    url = url + '&stage=Stage';
  }

  xhr.open('GET', url, true);

  xhr.onload = function() {
    if (xhr.status >= 200 && xhr.status < 400) {
      document.querySelector('.violators').innerHTML = xhr.responseText;
      var violators = document.querySelectorAll('.violators__violator[data-cookiename]');
      violators.forEach(function(violator) {
        var cookieName = violator.getAttribute('data-cookiename');
        if (getCookie(cookieName)) {
          violator.style.display = 'none';
        } else {
          violator.querySelector('.btn-close').addEventListener('click', function() {
            setCookie(cookieName, 'true', 365);
          });
        }
      });
    } else {
      console.error('Error: ' + xhr.responseText);
    }
  };

  xhr.onerror = function() {
    console.error('Request failed');
  };

  xhr.send();

  function setCookie(name, value, days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    var expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
  }

  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }
});
