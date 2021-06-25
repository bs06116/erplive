var a=2;
var b=2;
console.log(a+b);
//fetch("data.json")
//  .then(response => response.json())
//.then(json => console.log(json));

fetch("data.json")
    .then(function(resp){
        return resp.json();
    })
    .then(function(data){
        console.log(data);
    });
function appendData(data) {
    var mainContainer = document.getElementById("p");
    for (var i = 0; i < data.length; i++) {
        var div = document.createElement("div");
        div.innerHTML = data[i].text;
        mainContainer.appendChild(div);
    }
}
