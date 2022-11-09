var area = document.getElementById('area'),
    buttonRegister = document.getElementById('reg_btn'),
    buttonLogging = document.getElementById('log_btn'),
    buttonRestart = document.getElementById('restart_btn'),
    inputLogin = document.getElementById('login'),
    inputPassword = document.getElementById('password'),
    isRegged = true,
    isLogged = true,
    isWin = false;

///Регистрация
buttonRegister.addEventListener('click', function (event) {
    if(isRegged){
        alert("Вы уже зарегистрировались!");
    }
    else{
        var login = document.getElementById('login').value;
        var password = document.getElementById('password').value;

        if(login !== '' && password !== '') {
            DB_Register(login, password);
        }
        else{
            alert('Для регистрации необходимо заполнить оба поля ввода');
        }
    }
})

function DB_Register(login, password) {
    data = 'login=' + login + '&password=' + password + '&isCheck' + false;
    var ajax = new XMLHttpRequest();
    ajax.open('POST', 'RegServer.php', true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.onreadystatechange = function() {
        console.log(this.responseText);
        document.getElementById('RegLogAnswer').innerHTML = 'Ответ: ' + this.responseText;
        if (this.responseText === 'Регистрация выполнена успешно') isRegged = true;
    }
    ajax.send(data);
    return false;
}

///Вход
buttonLogging.addEventListener('click', function (event) {
    if (isLogged) {
        alert("Вы уже вошли в аккаунт!");
        }
    else{
        var login = inputLogin.value;
        var password = inputPassword.value;
        if(login !== '' && password !== '') {
            DB_Check(login, password);
        }
        else{
            alert('Для входа необходимо заполнить оба поля ввода');
        }
    }
})



function DB_Check(login, password) {
    out = false;
    data = 'login=' + login + '&password=' + password + '&isCheck' + true;
    var ajax = new XMLHttpRequest();
    ajax.open('POST', 'RegServer.php', true);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.onreadystatechange = function() {
        document.getElementById('RegLogAnswer').innerHTML = 'Ответ: ' + this.responseText;
        if (this.responseText === 'Вход выполнен успешно') isLogged = true;
    }
    ajax.send(data);
    return out;
}

///Начать заново
buttonRestart.addEventListener('click', function () {
    isWin = false;
    var boxes = document.getElementsByClassName('box');
    for (var i = 0; i < boxes.length; i++){
        boxes[i].innerHTML = '';
    }
})

///Отслеживание нажатий в игре
area.addEventListener('click', function(event){
    if(isLogged){
        if(event.target.innerHTML !== 'X' && event.target.innerHTML !== 'O' && !isWin)
        {
            event.target.innerHTML = 'X';
            GameSender();
        }
    }
    else{
        alert('Вы не вошли в аккаунт');
    }

})

function GameSender(){
    var boxes = document.getElementsByClassName('box');
    var clientTTT = [];
    for (var i = 0; i < boxes.length; i++){
        if (boxes[i].innerHTML === 'X') clientTTT[i] = 1;
        else if (boxes[i].innerHTML === 'O')  clientTTT[i] = 0;
        else  clientTTT[i] = 2;
    }
    console.log('Ход игрока: ');
    console.log(clientTTT);

    var message = 'a=' + clientTTT[0] + '&b=' + clientTTT[1] + '&c=' + clientTTT[2] +
                  '&d=' + clientTTT[3] + '&e=' + clientTTT[4] + '&f=' + clientTTT[5] +
                  '&g=' + clientTTT[6] + '&h=' + clientTTT[7] + '&k=' + clientTTT[8];

    console.log(message);
    console.log(clientTTT);
    console.log('Ход компьютера: ');

    var ajax = new XMLHttpRequest();
    console.log(1);
    ajax.open('POST', 'GameServer.php', true);
    console.log(2);
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    console.log(3);
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4 && ajax.status === 200){
            console.log(this.responseText);
            if(this.responseText === 'Крестики выиграли'||this.responseText === 'Нолики выиграли'||
               this.responseText === 'Ничья'){
                isWin = true;
                alert(this.responseText);
            }
            else{
                numberChanged = parseInt(this.responseText)%10;
                console.log(numberChanged);
                clientTTT[numberChanged] = 0;
                boxes[numberChanged].innerHTML = 'O';
            }
        }
    }
    console.log(4);
    ajax.send(message);
    console.log(5);
    return false;
}