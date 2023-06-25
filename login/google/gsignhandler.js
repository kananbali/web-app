
// function login() {
//     var myParams = {
//         'clientid': '758670487371-5prrjqsqcptj7n4vea7rs5im9sr8bof1.apps.googleusercontent.com',
//         'cookiepolicy': 'single_host_origin',
//         'callback': 'loginCallback',
//         'approvalprompt': 'force',
//         'scope': 'profile email'
//     };
//     gapi.auth.signIn(myParams);
// }

// function loginCallback(result) {
//     if (result['status']['signed_in']) {
//         var request = gapi.client.plus.people.get(
//             {
//                 'userId': 'me'
//             });
//         request.execute(function (resp) {
//             /* console.log(resp);
//             console.log(resp['id']); */
//             var email = '';
//             if (resp['emails']) {
//                 for (i = 0; i < resp['emails'].length; i++) {
//                     if (resp['emails'][i]['type'] == 'account') {
//                         email = resp['emails'][i]['value'];//here is required email id
//                     }
//                 }
//             }
//             var usersname = resp['displayName'];//required name
//         });
//     }
// }
// function onLoadCallback() {
//     gapi.client.setApiKey('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');
//     gapi.client.load('plus', 'v1', function () { });
// }
// (function () {
//     var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
//     po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
//     var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
// })();