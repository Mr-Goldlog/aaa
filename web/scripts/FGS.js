var password;
var pass1 = "1";
password = prompt(
    'Пожалуйста введите пароль, чтобы подтвердить что вы администратор :',
    '');
if (password == pass1) {
    alert('Пароль правильный! Нажмите Ок для входа на страницу.');
} else {
    window.location = "";
}