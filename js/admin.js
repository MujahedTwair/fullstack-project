//console.log(dataArray);

let data = document.getElementById("data");
let search = document.getElementById("search");
let fullname = document.getElementById("fullname");
let username = document.getElementById("username");
let email = document.getElementById("email");
let phonenumber = document.getElementById("phonenumber");
let password = document.getElementById("password");
let photo = document.getElementById("photo");
let addBtn = document.getElementById("click");
let update = document.getElementById("update");
let htable = document.getElementById("htable")


//displayData
function displayData(){
    let result = ``;
    for(let i=0 ; i<dataArray.length;i++){
        result += `
        <tr>
            <td>${dataArray[i].id}</td>
            <td>${dataArray[i].fullname}</td>
            <td>${dataArray[i].username}</td>
            <td>${dataArray[i].email}</td>
            <td>${dataArray[i].phonenumber}</td>
            <td>${dataArray[i].password}</td>
            <td><img src="../imges/usersimges/${dataArray[i].photo}" width="200" height="200" /></td>  
            <td><button class = "btn btn-info" onclick="getUsers(${i},event)">Update</button></td>
            <td><button  class="btn btn-danger"> <a href="admin.php?deletedid=${dataArray[i].id}">delete</a></button> </td>
            
        </tr>
        `
        data.innerHTML = result;
    }
    
}

//search
search.onkeyup = function(){
    let result =`` ;
    for(let i=0;i<dataArray.length;i++){
        if(dataArray[i].username.toLowerCase().includes(search.value.toLowerCase())){
            result += `
            <tr>
            <td>${dataArray[i].id}</td>
            <td>${dataArray[i].fullname}</td>
            <td>${dataArray[i].username}</td>
            <td>${dataArray[i].email}</td>
            <td>${dataArray[i].phonenumber}</td>
            <td>${dataArray[i].password}</td>
            <td ><img src="../imges/usersimges/${dataArray[i].photo}" width="200" height="200" /></td>  
            <td><button  class = "btn btn-info" onclick="getUsers(${i},event)">Update</button></td>
            <td><button  class="btn btn-danger"> <a href="admin.php?deletedid=${dataArray[i].id}">delete</a></button> </td>
        </tr>
        `
        }
        
    }
    data.innerHTML = result;  
}

//Update

function getUsers(index,event){
    if(event) event.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // You can use 'smooth' for smooth scrolling or 'auto' for instant scrolling
      });
    let user = dataArray[index];
//    console.log(user);

    htable.classList.add('btn') ;
    htable.classList.add('btn-warning') ;
    htable.innerHTML =`Update information for user has id of (<input type='hidden' id="forid" name="id" value="${user.id}">${user.id})` ;
    fullname.value = user.fullname;
    username.value = user.username;
    email.value = user.email;
    phonenumber.value = user.phonenumber;
    password.value = user.password;

    update.style.display = "inline";
    addBtn.style.display = "none";
    
}

displayData();



