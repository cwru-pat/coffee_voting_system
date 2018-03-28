function toggleSetCookie(cName, value, exdays) {
  let exdate = new Date();
  exdate.setDate(exdate.getDate() + exdays);
  const cValue = value + '; expires=' + exdate.toUTCString();
  document.cookie = cName + '=' + cValue;
}

function toggleGetCookie(cName) {
  const carr = document.cookie.split(';');
  const name = cName + '=';
  for (i = 0; i < carr.length; i++) {
    let c = carr[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length);
    }
  }
}
