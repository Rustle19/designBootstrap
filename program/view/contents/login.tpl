<div class='center-content'>
    <div id="fb-root"></div>
    <div class='container'>
        <div class='card shadow'>
            <article class='card-body'>
                <h3 class='card-title text-center mb-4 mt-1'>Eh</h3>
                <hr>
                <form id='login' method='post'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text'> <i class='fa fa-user'></i> </span>
                            </div>
                            <input name='username' class='form-control' placeholder='Username' id='login_uname'
                                   type='text'>
                            <p class="invalid-feedback form-text error_msg"></p>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='input-group'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text'> <i class='fa fa-lock'></i> </span>
                            </div>
                            <input class='form-control' name='password' placeholder='Password' id='login_pw'
                                   type='password'>
                            <p class="invalid-feedback form-text error_msg"></p>
                        </div>
                    </div>
                    <div class=' form-group'>
                        <button type='submit' id="btnLogin" class='btn btn-secondary btn-block'> Login</button>
                    </div>
                    <div class='form-group'>
                        <button type='submit' id="btnGroupwareLogin" class='btn btn-dark btn-block'> Groupware Login
                        </button>
                    </div>
                    <h6>Or</h6>

                    <div class='row mr-1 ml-1'>
                        <div id="my-signin2" class="col d-none"></div>
                        <button type="button" id="btnGoogle" class='btn btn-outline-dark col mr-5'> Sign in on
                            Google
                        </button>
                        <button type="button" id="btnFacebook" class='btn btn-outline-dark col'> Sign in on
                            Facebook
                        </button>

                    </div>
                    <p class='text-center mt-3'><a href='registration' class='text-dark'>New? Register Here</a></p>
                </form>
            </article>
        </div>
    </div>
</div>