document.addEventListener('DOMContentLoaded', function() {
  // Function to set a cookie
  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }

  // Function to get a cookie
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

  // Function to initialize modals
  function initializeModals() {
    document.querySelectorAll('.popup__modal').forEach(function(modal) {
      var cookieName = modal.getAttribute('data-cookiename');

      if (!cookieName || !getCookie(cookieName)) {
        var bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        modal.querySelector('.btn-close').addEventListener('click', function() {
          if (cookieName) {
            setCookie(cookieName, 'true', 365); // Set cookie for 1 year
          }
        });
      }
    });
  }

  // Check if Bootstrap is loaded and initialize modals
  var bootstrapCheckInterval = setInterval(function() {
    if (typeof bootstrap !== 'undefined') {
      clearInterval(bootstrapCheckInterval);
      initializeModals();
    }
  }, 100);
});
