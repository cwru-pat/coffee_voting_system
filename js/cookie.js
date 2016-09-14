function toggleSetCookie(cName, value, exdays) {
  var exdate = new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var cValue = value + '; expires=' + exdate.toUTCString();
  document.cookie = cName + '=' + cValue;
}

function toggleGetCookie(cName) {
  var carr = document.cookie.split(';');
  var name = cName + '=';
  for (i = 0; i < carr.length; i++) {
    c = carr[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length);
    }
  }
}
