window.onload = function () {

    function createRoom(roomName) {
        //Crée un channel de nom "roomName"
        //div
        let div = document.createElement("div");
        div.setAttribute("id", roomName);

        //chatbox
        let chatBox = document.createElement("input");
        chatBox.setAttribute("id", "chatter" + roomName);
        chatBox.setAttribute("class", "sender")
        chatBox.setAttribute("type", "text");
        chatBox.setAttribute("placeholder", "Envoyez un message dans #" + roomName);
        chatBox.setAttribute("name", "chatbox");

        //span
        let span = document.createElement("span");
        span.onclick = showRoom;
        span.innerHTML = "#" + roomName;

        //button
        let send = document.createElement("button");
        send.setAttribute("class", "sender");
        send.setAttribute("type", "button");
        send.setAttribute("value", "Envoyer");
        //send.setAttribute("name", "button");
        send.onclick = addMessage;

        //chatRoom

        let scrollable = document.createElement("div");
        scrollable.setAttribute("class", "scroll");

        //
        let chatterDiv = document.createElement("div");
        chatterDiv.setAttribute("id", "chatBox" + roomName);
        chatterDiv.setAttribute("class", "chatter");

        div.appendChild(span);
        chatterDiv.appendChild(scrollable);
        chatterDiv.appendChild(chatBox);
        chatterDiv.appendChild(send);
        chatterDiv.firstChild.nextSibling.addEventListener("keypress", function (event) {
            if (event.key == "Enter") {
                this.nextSibling.click();
                this.value = "";
            }
        });
        //chatterDiv.appendChild(container);
        chatterDiv.style.visibility = "hidden";
        div.append(chatterDiv);
        rooms.appendChild(div);

    }

    function addMessage() {
        //Ajoute le message dans le chat
        var currentRoom = this.parentNode.parentNode.id;
        let message = document.getElementById("chatter" + currentRoom).value;
        new simpleAjax("addMessage.php",
            "get",
            'message=' + message + "&" + "currentRoom=" + currentRoom,
            function (request) {
                let div = document.getElementById("chatBox" + currentRoom).firstChild;
                let text = JSON.parse(request.responseText);
                //Ajouter le texte au chat
                if(text!="Pas de texte"){
                    let content = text["message"];
                    let heure = text["time"];
                    let user = text["user"];
                    div.innerHTML += "<strong class = 'pseudo' style='color: blue;'>" + user + "</strong>" 
                                    + "<div class = 'heure' style='color: gray;'><font size ='2'>" + heure + "</font></div>"
                                    + "<div class = 'content'>" + content + "</div><br></br>";
                    autoScrollDown();
                }
                
            },
            function () {
                console.log("Add message : fail");
            }
        )
    }

    function autoScrollDown(){
        let scrollbars = document.getElementsByClassName("scroll");
        for (let j = 0; j < scrollbars.length; j++) {
            scrollbars[j].scrollTop = scrollbars[j].scrollHeight;
        }

    }
    function loadAllMessages() {
        //Charge tous les messages envoyés précédemment onload
        new simpleAjax("allMessages.php",
            "get",
            "",
            function (request) {
                let messageArray = JSON.parse(request.responseText);
                if (messageArray[0] != ['']) {
                    //Charge tous les messages d'un channel pour tous les channels
                    for (let i = 0; i < messageArray.length; i++) {
                        let info = messageArray[i];
                        if (session == info[2]) {
                            let room = info[info.length - 1];
                            let boxToWriteIn = document.getElementById(room).firstChild.nextSibling.firstChild;
                            boxToWriteIn.innerHTML += "<strong class = 'pseudo' style='color: blue;'>" + info[2] + "</strong>" 
                                                    + "<div class = 'heure' style='color=gray;'><font size = '2'>" + info[1] + "</font></div>" 
                                                    + "<div class = 'content'>" + info[0] + "</div><br></br>";
                            autoScrollDown();
                            //
                        }
                        else {
                            break;
                        }
                    }

                }

            },
            function () {
                console.log("Load All Messages : fail");
            }
        )
    }


    function addARoom() {
        let roomName = document.getElementById("adderText").value;
        new simpleAjax("createRoom.php",
            "get",
            "roomName=" + roomName,
            function (request) {
                let newRoomName = JSON.parse(request.responseText);
                createRoom(newRoomName);

            },
            function () {
                return "Echec";
            }
        );
    }
    function roomRequester() {
        new simpleAjax("allRooms.php",
            "get",
            "",
            createAllRooms,
            function () {
                console.log("raté");
            }
        )
    }

    function roomForm() {
        //Crée le "formulaire" pour créer un channel

        let div = document.createElement("div");
        let input = document.createElement("input");
        //let send = document.createElement("input");
        let send = document.createElement("button");
        input.setAttribute("id", "adderText");
        input.setAttribute("type", "text");
        input.setAttribute("class", "adder");
        input.setAttribute("name", "newRoom");
        input.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                this.nextSibling.onclick();
                this.value = "";
            }
        }
        );
        input.style.visibility = "hidden";

        send.setAttribute("class", "adder");
        //send.setAttribute("type", "submit");
        send.setAttribute("type", "button");
        //send.setAttribute("value", "Créer");
        send.innerHTML = "Créer";
        send.onclick = addARoom;
        send.style.visibility = "hidden";
        div.append(input);
        div.append(send);
        roomForms.appendChild(div);

    }

    function createAllRooms(request) {
        //Reforme tous les channels onload
        let channelArray = JSON.parse(request.responseText);
        if (channelArray != "Pas de channel") {
            for (let i = 0; i < channelArray.length; i++) {
                createRoom(channelArray[i]);
            }

            let span = document.getElementsByTagName("span");
            for (let i = 0; i < span.length; i++) {
                span[i].onclick = showRoom;
            }

            let textInputArray = [];
            for (let j = 0; j < channelArray.length; j++) {
                textInputArray.push(document.getElementById("chatter" + channelArray[j]));
            }
            loadAllMessages();
        }
    }

    function showRoom() {
        //Montre le channel si on clique sur son #nom
        let id = "chatBox" + this.innerHTML.substring(1, this.innerHTML.length);
        let chats = document.getElementsByClassName("chatter");
        let spans = document.getElementsByTagName("span");
        for (let i = 0; i < chats.length; i++) {
            if (chats[i].id != id) {
                chats[i].style.visibility = "hidden";
                spans[i].onclick = showRoom;
            }
            else {
                chats[i].style.visibility = "visible";
            }
        }
        this.onclick = hideRoom;
    }

    function hideRoom() {
        //Cache le channel si on clique sur son #nom
        let id = "chatBox" + this.innerHTML.substring(1, this.innerHTML.length);
        document.getElementById(id).style.visibility = "hidden";
        this.onclick = showRoom;
    }

    function hideRoomForm() {
        //Cache le formulaire qui ajoute des channels
        adders = document.getElementsByClassName("adder");
        for (let i = 0; i < adders.length; i++) {
            adders[i].style.visibility = "hidden";
        }
        this.onclick = showRoomForm;
    }

    function showRoomForm() {
        //Montre le formulaire qui ajoute des channels
        adders = document.getElementsByClassName("adder");
        for (let i = 0; i < adders.length; i++) {
            adders[i].style.visibility = "visible";
        }
        this.onclick = hideRoomForm;
    }

    var rooms = document.getElementsByClassName("Rooms")[0];
    var roomForms = document.getElementsByClassName("roomForm")[0];
    document.getElementById("utilisateur").style.color = "blue";
    document.getElementById("bouton").onclick = showRoomForm;
    roomForm();
    roomRequester();

}


