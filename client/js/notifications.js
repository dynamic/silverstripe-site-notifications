window.addEventListener('load', function() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '/violatordata?isAjax=1', true);

  xhr.onload = function() {
    if (xhr.status >= 200 && xhr.status < 400) {
      console.log(xhr.responseText);
      document.querySelector('.violators').innerHTML = xhr.responseText;
    } else {
      console.error('Error: ' + xhr.responseText);
    }
  };

  xhr.onerror = function() {
    console.error('Request failed');
  };

  xhr.send();
});
