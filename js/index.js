const listUsers = async ()=>{
    const respuesta = await fetch("https://jsonplaceholder.typicode.com/users");
    const users = await respuesta.json();
    
    let tableBody=``;

    users.forEach((user, index) => {
        
        tableBody += ` <tr>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td>${user.website}</td>
        </tr>`; 
    });
    //document.getElementById("tableBody_Users").innerHTML=tableBody;
    tableBody_Users.innerHTML=tableBody;
}

window.addEventListener("load",function(){
    console.log("Documento cargado!");
    listUsers();
})

function mostra(id)
{
    document.getElementById(id).style.visibility = "visible";
    document.getElementById(id).style.height = "auto";
}
function ocultar(id)
{
    document.getElementById(id).style.visibility = "hidden";
    document.getElementById(id).style.height = 0;
    document.getElementById(id).style.hidden = "hidden";
}