window.onload = function()
{
    function createForm(){
        //Nouveaux Elements
        let form = document.createElement("form");
        let input = document.createElement("input");
        let button = document.createElement("button");
        //Attributs
        form.setAttribute("method", "post");
        input.setAttribute("type", "text");
        input.setAttribute("value", "Nom du canal");
        val = document.querySelector("input").value;
        button.setAttribute("onclick", "createRoom()");
        button.innerHTML = "Créer un canal";
    }
    function createRoom()
    {
        let div = document.createElement("div");
        let form = document.createElement("form");
        let input = document.createElement("input");

        form.setAttribute("method", "post");
        input.setAttribute("type", "submit");
    }
}