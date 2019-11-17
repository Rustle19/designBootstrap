<div class="center-content">
    <div class="container">
        <div class="card shadow">
            <article class="card-body">
                <h4 class="card-title text-center mb-4 mt-1">Sign Up</h4>
                <hr>
                <form id="register" method="post">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-id-card"></i> </span>
                            </div>
                            <input name="username" class="form-control" id="reg_uname" autocomplete="none"
                                   placeholder="Username"
                                   type="text"
                            >
                            <p class="invalid-feedback form-text error_msg"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                            </div>
                            <input name="name" class="form-control" id="reg_name" autocomplete="none" placeholder="Name"
                                   type="text"
                            >
                            <p class="invalid-feedback form-text error_msg"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-key"></i> </span>
                            </div>
                            <input class="form-control" name="password" id="reg_pw" placeholder="Password"
                                   type="password">
                            <p class="invalid-feedback form-text error_msg"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                            </div>
                            <input class="form-control" name="confirmPassword" id="reg_confirm_pw"
                                   placeholder="Confirm Password" type="password">
                            <p class="invalid-feedback form-text error_msg"></p>
                        </div>
                    </div>
                    <div class='row mr-1 ml-1 justify-content-center'>
                        <div class="form-group register">
                            <button type="button" class="btn btn-dark" id="btnReset"> Reset</button>
                        </div>
                        <div class="form-group register">
                            <button type="submit" class="btn btn-dark " id="btnRegister"> Register
                            </button>
                        </div>
                    </div>

                    <p class="text-center"><a href="/" class="text-dark">Already have an account? Login</a></p>
                </form>
            </article>
        </div>
    </div>
</div>