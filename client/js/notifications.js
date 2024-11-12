window.addEventListener('load', function() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '/violatordata?isAjax=1', true);

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
