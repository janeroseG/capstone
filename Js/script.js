function myFunctionpw(){
    var x = document.getElementById("confirmPw");
    var y = document.getElementById("show1");
    var z = document.getElementById("show2");

    if(x.type === 'password'){
        x.type = "text";
        y.style.display = "block";
        z.style.display = "none";
    }
    else{
        x.type = "password";
        y.style.display = "none";
        z.style.display = "block";
    }
}
$('#password_validation').on('focus',function(){
    $('.password_required').slideDown();
})
$('#password_validation').on('blur', function(){
    $('.password_required').slideUp();
})

