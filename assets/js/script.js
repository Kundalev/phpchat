document.addEventListener("DOMContentLoaded", function () {
    const socket = new WebSocket('ws://localhost:8080');
    let join = $('#join-chat');
    let exit = $('#exit-chat');
    let messForm = $('#messForm');
    let loginForm = $('#loginForm');
    let users = $('#users')
    let reg = $('#reg')
    let nick = document.getElementById('nick')

    let login = function () {
        messForm.removeClass('d-none')
        reg.modal('hide')
        join.addClass('d-none')
        exit.removeClass('d-none')
        nick.innerText = getCookie('name')
        $('#123').addClass('d-none')
        socket.onopen = function(e) {
            console.log("Connection established!");
        };
    }
    let logOut = function () {
        messForm.addClass('d-none')
        join.removeClass('d-none')
        exit.addClass('d-none')
        $('#123').removeClass('d-none')
    }

    let getCookie = function (name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }
    let deleteCookie = function (name) {
        document.cookie = `${name}=;max-age=-1`;
    }



    exit.click(function () {
        deleteCookie('token')
        logOut()
    })

    loginForm.submit(function () {
        let name = $('#name').val()
        let color = $('#color').val()


        $.post( "/register", { name: name, color: color })
            .done(function( data ) {
                if (data !== 'This name is already taken'){
                    document.cookie = `token=${JSON.parse(data).token}`
                    document.cookie = `name=${JSON.parse(data).name}`
                    document.cookie = `color=${JSON.parse(data).color}`
                    login()
                }else {
                    alert(data)
                }
            });
        return false
    })




    $('#messForm').submit(function () {
        if ($('#message').val().length > 200) {
            alert('Ограничение 200 символов')
            return false
        } else {
            socket.send( JSON.stringify({
                name: getCookie('name'),
                message: $('#message').val(),
                color: getCookie('color')
            }));
            let parent = $('#all_mess')

                $(`<div class=\'alert alert-${getCookie('color')} col-6 ml-auto\'>\n` +
                    '                        <p class="d-flex justify-content-between align-items-center">\n' +
                    `                        <span>${getCookie('name')}</span>\n` +
                    '                            <span class="d-none text-right badge badge-dark">Admin</span>\n' +
                    '                        </p>\n' +
                    '                         \n' +
                    '                        <img class="d-none" style="width: 100px; height: 100px; object-fit: cover;" class="" src="https://yt4.ggpht.com/e2vhsw7wa0sO-QSqS3BzRhj-LkmSllra0-AjIi8kpM0PX3A9kfvsXJX8IWUhiEfFCaQXfmfPEoM=s32-c-k-c0x00ffffff-no-rj" alt="">\n' +
                    '                        <p class="mt-2">\n' +
                    `                            ${$('#message').val()}` +
                    '                        </p>\n' +
                    '                        \n' +
                    '                    </div>').appendTo(parent)
            document.getElementById('message').value = ''
            return false
        }

    })
    socket.onmessage = function(event) {
        console.log(`[message] Данные получены с сервера: ${(event['isTrusted'])}`);



        let parent = $('#all_mess')

        if ((event['isTrusted']) === true ) {
            $(`<div class=\'alert alert-${JSON.parse(event.data).color} col-6\'>\n` +
                '                        <p class="d-flex justify-content-between align-items-center">\n' +
                `                            <span>${JSON.parse(event.data).name}</span>\n` +
                '                            <span class="d-none text-right badge badge-dark"></span>\n' +
                '                        </p>\n' +
                '                        <img style="width: 100px; height: 100px; object-fit: cover;" class="d-none" src="" alt="">\n' +
                `                        <p>${JSON.parse(event.data).message}</p>\n` +
                '                    </div>').appendTo(parent)
        }

    }
})