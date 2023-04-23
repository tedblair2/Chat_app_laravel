const chatArea=document.querySelector('.chat-area')
const userArea=document.querySelector('.users-area')
const chats=document.querySelector('.chat-area .chats');
const sendChat=document.querySelector('.chat-area .actions');
const defaultpage=document.querySelector('.chat-area .cover')
const userList=document.querySelector('.users-area .users')
let csrftoken=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const sendForm=sendChat.querySelector("form")
const chatInput=sendForm.querySelector('#msg')
const btnSubmit=sendForm.querySelector('button')
const topArea=document.querySelector('.chat-area .top')
const searchForm=document.querySelector('.users-area form')
const searchInput=document.querySelector('.users-area form #searchUser')
let receiver_id;

sendForm.onsubmit=(e)=>{
    e.preventDefault()
}
searchForm.onsubmit=(e)=>{
    e.preventDefault()
}
const getUsers=()=>{
    let xhr=new XMLHttpRequest()
    xhr.open("GET","/get_users",true)
    xhr.setRequestHeader("X-CSRF-TOKEN", csrftoken);
    xhr.onreadystatechange=()=>{
        if(xhr.readyState==4 && xhr.status==200){
            let response=JSON.parse(xhr.responseText)
            userList.innerHTML=response.usertxt
            const users=document.querySelectorAll('.users-area .users .single')
            users.forEach(item=>{
                item.onclick=()=>{
                    if(chats.classList.contains("active") || sendChat.classList.contains("active")){
                        chats.classList.remove("active")
                        sendChat.classList.remove("active")
                        defaultpage.classList.add("active")
                        topArea.classList.remove("active")
                    }
                    chats.innerHTML=""
                    let data=item.getAttribute('data-value')
                    receiver_id=data
                    let xhr=new XMLHttpRequest();
                    xhr.open("POST","/set_session",true)
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrftoken);
                    xhr.onreadystatechange=()=>{
                        if(xhr.readyState==4 && xhr.status==200){
                            let response=JSON.parse(xhr.responseText)
                            topArea.innerHTML=`<button class="back"><i class="fa fa-arrow-left"     aria-hidden="true"></i></button>
                                <img src="/profiles/${response.image}" alt="">
                                <div class="names">
                                    <h2>${response.name}</h2>
                                    <p>${response.status}</p>
                                </div>`
                        }
                        if(xhr.status==500){
                            console.log("Something went wrong!")
                        }
                    }
                    xhr.send('data='+data)
                    setInterval(getChats,500)
                }
            })
        }
        if(xhr.status==500){
            console.log("Something went wrong!")
        }
    }
    xhr.send()
}
getUsers()
btnSubmit.onclick=()=>{
    let xhr=new XMLHttpRequest()
    xhr.open("POST","/send_message",true)
    xhr.onreadystatechange=()=>{
        if(xhr.readyState==4 && xhr.status==200){
            let response=JSON.parse(xhr.responseText)
            chatInput.value=""
            console.log(response.msg)
        }
        if(xhr.status==500){
            console.log("Something went wrong!")
        }
    }
    let formdata=new FormData(sendForm)
    xhr.send(formdata)
}

const getChats=()=>{
    let xhr=new XMLHttpRequest()
    xhr.open("POST","/get_messages",true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader("X-CSRF-TOKEN", csrftoken);
    xhr.onreadystatechange=()=>{
        if(xhr.readyState==4 && xhr.status==200){
            chats.innerHTML=""
            let response=JSON.parse(xhr.responseText)
            chats.innerHTML=response.chattxt
        }
        if(xhr.status==500){
            console.log("Something went wrong!")
        }
    }
    xhr.send('id='+receiver_id)
}

searchInput.onkeyup=()=>{
    let searchTxt=searchInput.value
    if(searchTxt !=""){
        searchInput.classList.add("on")
    }else{
        searchInput.classList.remove("on")
    }
    let xhr=new XMLHttpRequest()
    xhr.open("POST","/search_user",true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader("X-CSRF-TOKEN", csrftoken);
    xhr.onreadystatechange=()=>{
        if(xhr.readyState==4 && xhr.status==200){
            let response=JSON.parse(xhr.responseText)
            userList.innerHTML=""
            userList.innerHTML=response.searchtxt
            const users=document.querySelectorAll('.users-area .users .single')
            users.forEach(item=>{
                item.onclick=()=>{
                    if(chats.classList.contains("active") || sendChat.classList.contains("active")){
                        chats.classList.remove("active")
                        sendChat.classList.remove("active")
                        defaultpage.classList.add("active")
                        topArea.classList.remove("active")
                    }
                    chats.innerHTML=""
                    let data=item.getAttribute('data-value')
                    receiver_id=data
                    let xhr=new XMLHttpRequest();
                    xhr.open("POST","/set_session",true)
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrftoken);
                    xhr.onreadystatechange=()=>{
                        if(xhr.readyState==4 && xhr.status==200){
                            let response=JSON.parse(xhr.responseText)
                            topArea.innerHTML=`<button class="back"><i class="fa fa-arrow-left"     aria-hidden="true"></i></button>
                                <img src="/profiles/${response.image}" alt="">
                                <div class="names">
                                    <h2>${response.name}</h2>
                                    <p>${response.status}</p>
                                </div>`
                        }
                        if(xhr.status==500){
                            console.log("Something went wrong!")
                        }
                    }
                    xhr.send('data='+data)
                    setInterval(getChats,500)
                }
            })
        }
        if(xhr.status==500){
            console.log("Something went wrong!")
        }
    }
    xhr.send('search='+searchTxt)
}
