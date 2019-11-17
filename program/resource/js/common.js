class Common {
  //sends all forms to their respective apis
  sendForm(oForm, sType, sSocialData) {
    let aUserForms = ['login', 'register', 'create_user', 'edit_user', 'change_password']
    let aApiLogin = ['GroupwareLogin', 'Google', 'Facebook', 'Login']
    //since groupware login, google, and facebook all goes to the same login method
    let sFormId = aApiLogin.includes(sType) === true && sType !== undefined ? 'login' : $(oForm).attr('id')
    let sData = sType === 'Google' || sType === 'Facebook' ? sSocialData : $(oForm).serialize()
    let aData = sFormId === 'login' ? sData + '&type=' + sType : $(oForm).serialize()
    //get url
    let sUrl = aUserForms.includes(sFormId) === true ? '/rest/user/' + sFormId : '/rest/tweet/' + sFormId
    // send the data and the url in the form

    $.ajax({
      url: sUrl,
      data: aData,
      dataType: 'json',
      success: oResult => {
        if (oResult['bResult'] === true) {
          if (sFormId.includes('add') === false && sFormId.includes('edit') === false) {
            alert(oResult['sMsg'])
          }
          this[sFormId](oResult['aTweetInfo'])
        }
      }
    })
  }
  async addTweet(aTweetInfo) {
    let bUserId = true
    await this.generateTweetLayout(aTweetInfo['aTweet'], bUserId, 'prepend')
    $('#addTweet').trigger('reset')
  }
  async editTweet($aTweetInfo) {
    $('#btnCancel').trigger('click')
    $('button[data-id=' + $aTweetInfo['aTweet']['id'] + ']')
      .closest('.tweet-info')
      .find('.caption')
      .html($aTweetInfo['aTweet']['caption'])
  }
  async showEditTweet(iTweetId) {
    let oResult = await $.ajax({
      url: '/rest/tweet/getTweetById?tweetId=' + iTweetId,
      dataType: 'json'
    })
    return oResult['aTweet']
  }
  async deleteTweet(iTweetId) {
    let oResult = await $.ajax({
      url: '/rest/tweet/deleteTweet?tweetId=' + iTweetId,
      dataType: 'json'
    })
    await this.likeTweet(iTweetId, 'delete')
    return oResult['bResult']
  }
  async likeTweet(iTweetId, sStatus) {
    let oResult = await $.ajax({
      url: '/rest/tweet/likeTweet',
      data: { tweetId: iTweetId, status: sStatus },
      dataType: 'json'
    })
    return oResult
  }
  register() {
    window.location.replace('/')
  }

  login() {
    window.location.replace('/home')
  }

  async checkUserName(sUserName) {
    let oResult = await $.ajax({
      url: '/rest/user/checkUsername',
      data: { username: sUserName },
      dataType: 'json'
    })
    return oResult['bResult']
  }

  async getTweets() {
    await $.ajax({
      url: '/rest/tweet/getTweetList',
      dataType: 'json',
      success: aTweets => {
        $('#tweets').empty()
        this.displayTweets(aTweets['aTweets'], aTweets['sLoggedInId'])
      }
    })
  }

  async displayTweets(aTweets, iUserId) {
    if (aTweets.length > 0) {
      await $.each(aTweets, (sKey, aTweet) => {
        this.generateTweetLayout(aTweet, iUserId, 'append')
      })
    }
  }
  async showIsLiked(iTweetId, iUserId) {
    let oResult = await $.ajax({
      url: '/rest/tweet/isLiked',
      data: { tweetId: iTweetId, userId: iUserId },
      dataType: 'json'
    })
    return oResult
  }
  async showLikeCounter(iTweetId) {
    let oResult = await $.ajax({
      url: '/rest/tweet/getLikeList',
      data: { tweetId: iTweetId },
      dataType: 'json'
    })
    return oResult['aResult']
  }
  async generateTweetLayout(aTweet, iUserId, sShow) {
    let sIsUser = aTweet['user_id'] === iUserId || iUserId === true ? '' : 'display:none'
    let oResult = await this.showIsLiked(aTweet['id'], iUserId)
    let iLikeCounter = await this.showLikeCounter(aTweet['id'])

    let sIsLiked =
      oResult['aResult'] !== false && oResult['aResult']['user_id'] === iUserId ? 'fa-heart' : 'fa-heart-o'

    $('#tweets')[sShow](`
             <div class=" tweet-info">
                <div class="d-flex h-100 ">
                    <img class='text-center mr-2' src="${aTweet['image']}"
                     height="65px"
                     width="65px"/>
                    <div class="d-flex flex-column w-100" style="word-break:break-all">
                        <div class="d-flex justify-content-between tweetContent">
                            <div class="d-flex">
                                <p class="tweetLabelName">
                                    <a href="/profile" class="font-weight-bold">${aTweet['name']}</a>
                                    <span>@${aTweet['username']}</span>
                                    <span class="small"> · ${moment(aTweet['created_at']).fromNow()}</span>
                                </p>
                            </div>
                            
                            <div class="dropdown show" style="${sIsUser}">
                                 <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-chevron-down"></i>
                                 </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <button class="dropdown-item btnEditOption" data-id="${
                                      aTweet['id']
                                    }" data-toggle="modal" data-target="#editModal" >Edit</button>
                                    <button class="dropdown-item text-red btnDelOption" data-id="${
                                      aTweet['id']
                                    }" href="#">Delete</button>
                                </div>
                            </div>
                        </div>
                        <p class="mb-1 caption">${aTweet['caption']}</p>
                        <div class="d-flex">
                            <button type='button' class='btn btn-link text-dark btnLike' data-id="${
                              aTweet['id']
                            }"><i class="fa ${sIsLiked}  damt-1 mr-2 mt-1"></i></button>
                            <button type='button' class='btn btn-link text-dark btnLikeList'  data-toggle="modal" data-target="#likesModal" data-id="${
                              aTweet['id']
                            }"><span class='likeCounter'>${iLikeCounter.length}</span></button>
                        </div>
                    </div>
                </div>
                <hr>
             </div>
        `)
  }
}
