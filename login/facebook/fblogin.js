function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response); // The current login status of the person.
    if (response.status === 'connected') { // Logged into your webpage and Facebook.
        localStorage.setItem('access_token', response.authResponse.accessToken);
        FB.api('/me', {
            fields: 'name, email,picture'
        }, function (res) {
            localStorage.setItem('name', res.name);
            localStorage.setItem('email', res.email);
            localStorage.setItem('picture', res.picture.data.url);
            location.replace('./facebook/fb.php');
        });

    } else {
        // document.getElementById('status').innerHTML = 'Please log ' + 'into this webpage.';
    }
}
function checkLoginState() { // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function (response) { // See the onlogin handler
        statusChangeCallback(response);
    });
}
window.fbAsyncInit = function () {
    FB.init({
        // appId: '849607053091791',
        appId: '456704782820807',
        cookie: true, // Enable cookies to allow the server to access the session.
        xfbml: true, // Parse social plugins on this webpage.
        version: 'v13.0', // Use this Graph API version for this call.
    });


    FB.getLoginStatus(function (response) { // Called after the JS SDK has been initialized.
        statusChangeCallback(response); // Returns the login status.


    });
};

function testAPI() { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    // console.log('Welcome!  Fetching your information.... ');

}
document.getElementById('fblogin').addEventListener('click', function () {
    //do the login
    FB.login(statusChangeCallback, {
        scope: 'email,public_profile',
        return_scopes: true,

    });
}, false);
