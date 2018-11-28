let typingTimer;
let doneTypingInterval = 2000;
let emailHelper = document.getElementById( "email_helper" );
let emailInput = document.getElementById( "email" );
let emailInputP = document.getElementById( "email_input_p" );

// Send email off to be validated 2 seconds after user stops typing
emailInput.addEventListener( 'keyup', () => {

    emailHelper.style.visibility = 'hidden';

    if( !ValidateEmail( emailInput.value ) ){
        emailInput.classList.remove( "is-success" );
        emailInput.classList.add( "is-danger" );
        emailInputP.classList.remove( 'is-loading' );

    } else {
        emailInput.classList.remove( "is-danger", "is-success" );
        emailInputP.classList.add( 'is-loading' );

        clearTimeout( typingTimer );
        if( emailInput.value ){
            typingTimer = setTimeout( setTimeout( doneTyping, doneTypingInterval ) );
        }
    }

});

// Taken from W3Resource.com
function ValidateEmail(mail){
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( mail )){
        return (true)
    }
    return (false)
}

function doneTyping(){
    //emailInputP.classList.add( 'is-loading' );

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = () => {
        if( xmlhttp.readyState === XMLHttpRequest.DONE && xmlhttp.status === 200 ){
            // Remove the loading circle
            emailInputP.classList.remove( 'is-loading' );

            // Check the response
            if( xmlhttp.responseText === 'true' ){
                emailHelper.style.visibility = 'hidden';
                emailInput.classList.remove( "is-danger" );
                emailInput.classList.add( "is-success" );
            } else {
                emailHelper.style.visibility = '';
                emailInput.classList.remove( "is-success" );
                emailInput.classList.add( "is-danger" );
            }
        }
    };

    xmlhttp.open( 'GET', 'verifyemail.php?email=' + emailInput.value, true );
    xmlhttp.send();
}

let password = document.getElementById("password");
let confirmPassword = document.getElementById("confirm_password");

// Minimum password length = 8
password.addEventListener( 'keyup', () => {
    if( password.value.length === 0 ){
        password.classList.remove( 'is-success', 'is-danger' );
    } else if( password.value.length < 8 ){
        password.classList.remove( 'is-success' );
        password.classList.add( 'is-danger' );
    } else {
        password.classList.remove( 'is-danger' );
        password.classList.add( 'is-success' );
    }
});

confirmPassword.addEventListener( 'keyup', () => {
    if( confirmPassword.value === password.value ){
        confirmPassword.classList.remove( "is-danger" );
        confirmPassword.classList.add( "is-success" );
    } else if( confirmPassword.value !== password.value ){
        confirmPassword.classList.remove( "is-success" );
        confirmPassword.classList.add( "is-danger" );
    } else if( confirmPassword.value.length === 0 || password.value.length === 0 ){
        confirmPassword.classList.remove( "is-success", "is-danger" );
    }
} );