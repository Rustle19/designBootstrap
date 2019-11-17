class Auth {
  constructor() {
    this.init()
    this.googleButton()
    this.oCommon = new Common()
  }

  init() {
    FB.init({
      appId: '583701275713785',
      cookie: true,
      version: 'v5.0'
    })
    gapi.load('auth2', function() {
      gapi.auth2.init({
        scope: 'profile email'
      })
    })
  }

  googleButton() {
    gapi.signin2.render('my-signin2', {
      scope: 'profile email',
      width: 240,
      height: 50,
      longtitle: true,
      theme: 'light',
      onsuccess: data => this.onSuccess(data),
      onfailure: this.onFailure
    })
  }

  signInGoogle() {
    $('#my-signin2')
      .children()
      .trigger('click')
  }

  signInFacebook() {
    FB.login(response => {
      if (response.status === 'connected') {
        if (window.location.pathname !== '/home') {
          FB.api('/me', { fields: 'name, email, picture.width(300)' }, response => {
            this.oCommon.sendForm(
              null,
              'Facebook',
              'app_id=' +
                response.id +
                '&name=' +
                response.name +
                '&image=' +
                encodeURIComponent(response.picture.data.url)
            )
          })
        }
      }
    })
  }

  onSuccess(googleUser) {
    let profile = googleUser.getBasicProfile()
    this.oCommon.sendForm(
      null,
      'Google',
      'app_id=' + profile.getId() + '&name=' + profile.getName() + '&image=' + profile.getImageUrl()
    )
  }

  signOutGoogle() {
    let auth2 = gapi.auth2.getAuthInstance()
    auth2.signOut().then(function() {
      console.log('User signed out.')
    })
  }

  onFailure(error) {
    console.log(error)
  }

  async logout() {
    let oResult = await $.ajax({
      url: '/rest/user/logout',
      dataType: 'json'
    })
    return oResult['sMsg']
  }
}
