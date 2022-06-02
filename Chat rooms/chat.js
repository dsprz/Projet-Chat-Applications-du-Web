    function addMessage()
    {
        new simpleAjax("MessageJSON.php",
                        "get",
                        "",
                        displayMessage,
                        function()
                        {
                            console.log("raté");
                        }

        )
    }

    function getAllRooms() 
    {
        new simpleAjax("allRooms.php",
                        "get",
                        "",
                        roomArray,
                        function () 
                        {
                            console.log("raté");
                        }
        )
    }

    function roomArray(request)
    {
        return JSON.parse(request.responseText);
    }
    function displayMessage(request)
    {
        console.log(JSON.parse(request.responseText));
        document.getElementById("kaiba").innerHTML = "lol";
    }

    //var roomArray = getAllRooms();


