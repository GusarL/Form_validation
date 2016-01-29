<!DOCYTPE html>
<html>
  <head>
    <title>Form validation</title>
    <meta charset="utf-8">
  </head>
  <body>
    <form>
      <input type = "text" name="login" placeholder="Логин"><br/>
      <input type="password" name="passwd" placeholder="Пароль"><br/>
      <input type="password" name="checkPasswd" placeholder="Проверка пароля"><br/>
      <div id="info"></div>
      <input type="submit">
    </form>
      <script>
        var flag, check;
        var count = 0;
        var form = document.forms[0];
        var elemInputs = form.elements;
        var field = elemInputs.login;
        var fieldPass = elemInputs.passwd;
        var fieldCheckPass = elemInputs.checkPasswd;
        var info = form.querySelector('#info');

        function checkUnic(strQuery, login){
          var xhr = new XMLHttpRequest();
          var params = strQuery + login;
          xhr.open('GET', params, true);
          xhr.send();
          xhr.onreadystatechange = function(){
            if(xhr.readyState != 4)return;
            if(xhr.status != 200){
              alert(xhr.status + ':' + xhr.statusText);
            }else{
                 if(xhr.responseText == 1){
                  info.innerHTML = 'Логин занят';
                 }else{
                     info.innerHTML = '';
                    return flag = true;
                      };
                 };
          };
        return flag;  
        };
        function checkFillReg (inputValue, re, fillMessage, regMessage){
          if(!inputValue){
            info.innerHTML = fillMessage;
          }else if(!re.test(inputValue)){
                info.innerHTML = regMessage;
                    }else{
                     info.innerHTML = '';
                     check= true;
                     };
        };
        field.onblur = function(){
          checkFillReg(this.value, /^[A-Z][a-z]+$/, 'Введите логин', 'Логин состоит только из латинских букв, первая заглавная');
          if(check){
//предположим, файл, который обрабатывает форму, называется reg.php, находится в папке ajax и с бэкендщиком договорились, что при указании 
//в строке запроса check=on, делается проверка на наличие логина в базе. При этом сервер отвечает 1 если логин занят, 0 если свободен, 
            checkUnic('ajax/reg.php?check=on&login=', this.value);
          };
        };
        fieldPass.onblur = function(){
          checkFillReg(this.value, /^\w+$/, 'Введите пароль', 'Пароль состоит из латинских букв, цифр и знака подчёркивания'); //var re = /^(?=.*\d)(?=.*_)(?=.*[a-z])[\w]+$/;
        };
        function getCookie(name){
          var matches = document.cookie.match(new RegExp("(?:^|;)" +
              name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
            return matches ? decodeURIComponent(matches[1]): undefined;
        };
        function setCookie(name, value, options) {
           options = options || {};

           var expires = options.expires;

           if (typeof expires == "number" && expires) {
           var d = new Date();
           d.setTime(d.getTime() + expires * 1000);
           expires = options.expires = d;
           };
           if (expires && expires.toUTCString) {
           options.expires = expires.toUTCString();
           };

           value = encodeURIComponent(value);

           var updatedCookie = name + "=" + value;

           for (var propName in options) {
             updatedCookie += "; " + propName;
             var propValue = options[propName];
             if (propValue !== true) {
                 updatedCookie += "=" + propValue;
             };
           };

           document.cookie = updatedCookie;
           };

        function makeDisable(inputField){
           inputField.setAttribute('disabled', true);
        }; 

        form.onsubmit = function(){
          event.preventDefault();
          if(flag && check){
            if(fieldPass.value != fieldCheckPass.value){
              info.innerHTML = 'Пароли не совпадают';
            }else{
              info.innerHTML = '';
              if(checkUnic('ajax/reg.php?check=on&login=', field.value)){ 
                if(getCookie("attempt") == 5){
                  makeDisable(field);
                  makeDisable(fieldPass);
                  makeDisable(fieldCheckPass);
                  return;
                };   
                count++;
                setCookie("attempt", count, {expires: 3600*24});
                alert(document.cookie);
              }; 
                };
          };   
        };
        
      </script>
  </body>
</html>