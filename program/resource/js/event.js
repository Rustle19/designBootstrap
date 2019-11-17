$(async function() {
  let oAuth = new Auth()
  let oCommon = new Common()
  let validate = new Validator('form')
  await oCommon.getTweets()
  $('#log_out').click(async function() {
    oAuth.signOutGoogle()
    FB.logout()
    alert(await oAuth.logout())
    location.replace('/')
  })
  $('#btnGoogle').click(function() {
    oAuth.signInGoogle()
  })

  $('#btnFacebook').click(function() {
    oAuth.signInFacebook()
  })

  $('form').submit(function(e) {
    e.preventDefault()
    //gets the btn button id
    let sBtn = $(document.activeElement).attr('id')
    oCommon.sendForm(this, sBtn.slice(3))
  })
  $('#btnReset').click(function() {
    $(this)
      .closest('form')
      .trigger('reset')
    $('input').removeClass('is-invalid is-valid')
    // $(this).closest('form').find('.invalid-feedback').remove();
    validate.oAllErrors = {}
  })
  $('#tweets').on('click', '.btnDelOption, .btnEditOption, .btnLike, .btnLikeList', async function() {
    if ($(this).hasClass('btnDelOption')) {
      if (confirm('Are you sure you want to delete this tweet?')) {
        let bResult = await oCommon.deleteTweet($(this).data('id'))
        if (bResult === true) {
          $(this)
            .closest('.tweet-info')
            .remove()
        }
      }
    } else if ($(this).hasClass('btnEditOption')) {
      let aResult = await oCommon.showEditTweet($(this).data('id'))
      $('#edit_tweet_id').val(aResult['id'])
      $('#edit_tweet_content').val(aResult['caption'])
    } else if ($(this).hasClass('btnLike')) {
      let sOldIcon =
        $(this)
          .children()
          .hasClass('fa-heart-o') === true
          ? 'fa-heart-o'
          : 'fa-heart'
      let sNewIcon =
        $(this)
          .children()
          .hasClass('fa-heart-o') === true
          ? 'fa-heart'
          : 'fa-heart-o'
      let sStatus = sNewIcon === 'fa-heart' ? 'insert' : 'delete'
      await oCommon.likeTweet($(this).data('id'), sStatus)
      let iLikeCounter = await oCommon.showLikeCounter($(this).data('id'))
      $(this)
        .closest('.tweet-info')
        .find('.likeCounter')
        .html(iLikeCounter.length)
      $(this)
        .children()
        .removeClass(sOldIcon)
        .addClass(sNewIcon)
    } else if ($(this).hasClass('btnLikeList')) {
    }
  })
})
