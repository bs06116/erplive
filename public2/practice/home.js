
function appendData(data) {
    var mainContainer = document.getElementById("p");
    for (var i = 0; i < data.length; i++) {
        var div = document.createElement("div");
        div.innerHTML = data[i].text;
        mainContainer.appendChild(div);
    }
}
