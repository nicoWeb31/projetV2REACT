
//timer
let dom = document.getElementById('timerTrail');
let dateLaunch = new Date(2020,10,21);
console.log(dom)

const setDate = () =>{

    const date = new Date()
    let s = Math.floor((dateLaunch.getTime() - date.getTime())/1000) ; 
    setTimeout(setDate,1000);
   //  console.log(s)
    dom.innerHTML = s + "  s";
}

setDate();
