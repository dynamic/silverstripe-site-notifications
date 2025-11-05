/**
 * Violator cookie handling for template-rendered violators
 * Handles "show once" functionality using cookies
 */
(function() {
  'use strict';

  // Wait for DOM to be ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initViolators);
  } else {
    initViolators();
  }

  function initViolators() {
    var violators = document.querySelectorAll('.violators__violator[data-cookiename]');
    
    violators.forEach(function(violator) {
      var cookieName = violator.getAttribute('data-cookiename');
      
      // Hide if cookie exists
      if (getCookie(cookieName)) {
        violator.style.display = 'none';
      } else {
        // Add event listener to close button
        var closeButton = violator.querySelector('.btn-close');
        if (closeButton) {
          closeButton.addEventListener('click', function() {
            setCookie(cookieName, 'true', 365);
          });
        }
      }
    });
  }

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
})();
