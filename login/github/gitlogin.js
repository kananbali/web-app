document.getElementById('githublogin').setAttribute('target', '_blank');
document.getElementById('githublogin').addEventListener('click', function () {
    window.location.href =  'https://github.com/login/oauth/authorize?client_id=6b80ef155241be9adb31&scope=user:email&redirect_uri=http://ec2-13-235-76-10.ap-south-1.compute.amazonaws.com/login/github/github.php';
    // window.location.href =  'https://github.com/login/oauth/authorize?client_id=544df1bb709d379d3aec&scope=user:email&redirect_uri=http://localhost:8888/login/github/github.php';

});