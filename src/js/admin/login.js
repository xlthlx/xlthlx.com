if (document.getElementById('loginform') !==null) {
    document.getElementById('loginform').classList.add('md-form')
}

if (document.getElementById('lostpasswordform') !==null) {
    document.getElementById('lostpasswordform').classList.add('md-form')
}

if (document.getElementById('lostpasswordform') !==null) {
    document.getElementById('lostpasswordform').classList.add('md-form')
}

if (document.getElementById('user_login') !==null) {
    let user_login = document.getElementById('user_login')
    user_login.classList.remove('input')
    user_login.classList.add('form-control','rounded-0')
}

if (document.getElementById('user_pass') !==null) {
    let user_pass = document.getElementById('user_pass')
    user_pass.classList.remove('input')
    user_pass.classList.add('form-control','rounded-0')
}

if (document.getElementById('wp-submit') !==null) {
    let wp_submit = document.getElementById('wp-submit')
    wp_submit.classList.remove('button','button-primary','button-large');
    wp_submit.classList.add('btn','btn-outline-primary','pink-hover','rounded-0')
}