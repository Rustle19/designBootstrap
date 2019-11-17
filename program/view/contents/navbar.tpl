<div class="row h-100 home pt-5">
  <div class="col-4 text-dark profile pb-2">
<div class='profileNav'>
    <div class="card w-100 ml-0 p-4 shadow">
      <div class="card-body">
        <div class="card-title text-center">
          <img class="text-center" src="<?=$image?>" height="60px" />
          <div class="text-center">
            <a href="/profile"><?=$name?></a>
          </div>
        </div>
        <h6 class="card-subtitle mb-2 text-muted">@<?=$username?></h6>
        <div class="d-flex flex-column text-center profile-links mt-3">
           <div>
            <a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
          </div>
          <div>
            <a href="/profile"><i class="fa fa-user-circle" aria-hidden="true"></i> Profile</a>
          </div>
          <div>
            <a href="/settings"><i class="fa fa-cogs" aria-hidden="true"></i> Settings</a>
          </div>
          <div>
            <a id="log_out" href="#"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>



