 // For Firebase JS SDK v7.20.0 and later, measurementId is optional
 const firebaseConfig = {
    apiKey: "AIzaSyCvefstY5Oq1KjpfpIaWG6EV3UireNVuq4",
    authDomain: "agrifresh-7573e.firebaseapp.com",
    databaseURL: "https://agrifresh-7573e-default-rtdb.firebaseio.com",
    projectId: "agrifresh-7573e",
    storageBucket: "agrifresh-7573e.appspot.com",
    messagingSenderId: "790374013375",
    appId: "1:790374013375:web:222d36ddb05dfdb14e690a",
    measurementId: "G-PRH9SRK83C"
  };
  //initilized firebase
  firebase.InitilizedApp(firebaseConfig);

  //reference 
  var logindb = firebase.database().ref("login");

  document.getElementById('login').addEventListener('submit', submitform);

  function submitform(e){
    e.preventDefault();
    var name = getElementVal('name');
    var email = getElementVal('email');
    var role = getElementVal('role');
    var myInput = getElementVal('myInput');
    var confirmPw = getElementVal('confirmPw');

    console.log(name, email, role, myInput, confirmPw)
  }

  const getElementVal = (id) => {
    return document.getElementById(id).value;
  }