let socket = new WebSocket("ws://localhost:8080");

socket.onopen = function(e) {
    console.log("[open] Соединение установлено");
    console.log("Отправляем данные на сервер");
    socket.send(JSON.stringify({
        'kek' : 'lol'
    }));
};

socket.onmessage = function(event) {
    console.log(`[message] Данные получены с сервера: ${event.data}`);
};

socket.onclose = function(event) {
    if (event.wasClean) {
        console.log(`[close] Соединение закрыто чисто, код=${event.code} причина=${event.reason}`);
    } else {
        // например, сервер убил процесс или сеть недоступна
        // обычно в этом случае event.code 1006
        alert('[close] Соединение прервано');
    }
};

socket.onerror = function(error) {
    alert(`[error] ${error.message}`);
};