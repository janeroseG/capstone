function validate(){
    var pass = document.getElementById('myInput');
    var upper = document.getElementById('upper');
    var lower = document.getElementById('lower');
    var num = document.getElementById('number');
    var len = document.getElementById('length');
    var sp_char = document.getElementById('special_char');
    // check if pass value contain a number
    if(pass.value.match(/[0-9]/)) {// match is function which matchs a regular expressions
    // password contain 0  to 9 number then 
        num.style.color = 'green'


    }
    else {
        //otherwise
        num.style.color = 'red'
    }
     // check if pass value contain a uppercase
     if(pass.value.match(/[A-Z]/)) {// match is function which matchs a regular expressions
        // password contain A  to Z number then 
            upper.style.color = 'green'
    
    
        }
        else {
            //otherwise
            upper.style.color = 'red'
        }
     // check if pass value contain a lowercase
     if(pass.value.match(/[a-z]/)) {// match is function which matchs a regular expressions
        // password contain A  to Z number then 
            lower.style.color = 'green'
    
    
        }
        else {
            //otherwise
            lower.style.color = 'red'
        }
    // checking for special symbols
    if(pass.value.match(/[!\@\#\$\%\^\&\*\(\)\_\-\+\=\?\>\<\.\,]/)) {// match is function which matchs a regular expressions
        // type all special characters which you want 
            sp_char.style.color = 'green'
        // it returns true if those characters are in password
    
        }
        else {
            //otherwise
            sp_char.style.color = 'red'
        }


}
function confirmPassword(){
    var myInput = document.getElementById('myInput');
    var confirmPw = document.getElementById('confirmPw');
    if(myInput.value == confirmPw.value){
        document.getElementById('number').style.display = 'none';
        document.getElementById('length').style.display = 'none';
        document.getElementById('special_char').style.display = 'none';
        document.getElementById('upper').style.display = 'none';
        document.getElementById('lower').style.display = 'none';
    }
    else {
        document.getElementById('number').style.display = 'block';
        document.getElementById('length').style.display = 'block';
        document.getElementById('special_char').style.display = 'block';
        document.getElementById('upper').style.display = 'block';
        document.getElementById('lower').style.display = 'block';
    }
}
