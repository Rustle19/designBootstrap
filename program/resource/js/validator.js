class Validator {
  constructor() {
    this.oCommon = new Common()
    let oSelf = this
    this.oAllErrors = {}
    $('input').on('input change', function() {
      let sId = $(this).attr('id')
      let sValue = $(this).val()
      oSelf.oAllErrors[sId] = oSelf[sId](sValue)
      oSelf.showError(oSelf.oAllErrors)
    })

    $('#reg_uname').on('change', async function() {
      let aErrors = await oSelf['checkUsername']($(this).val())

      if (aErrors.length > 0) {
        oSelf.oAllErrors[$(this).attr('id')] = aErrors
        oSelf.showError(oSelf.oAllErrors)
      }
    })

    $('#btnRegister,#btnLogin').click(function() {
      $('input').change()
    })
  }

  showError(oErrors) {
    $.each(oErrors, function(key, value) {
      let sId = '#' + key
      $(sId)
        .addClass('is-invalid')
        .next()
        .html(' * ' + value.join('<br> * '))
      if (!value.length === true) {
        $(sId).removeClass('is-invalid')
        $(sId).addClass('is-valid')
      }
      // if ($(sId).val().length === 0) {
      //     $(sId).addClass('is-invalid').next().html('');
      // }
    })
  }

  validatePattern(sValue, mPattern) {
    return mPattern.test(sValue) === false
  }

  async checkUsername(sValue) {
    let aErrors = []

    if ((await this.oCommon.checkUserName(sValue)) === false && sValue.length > 0) {
      aErrors.push('Username already exists. Please choose another username')
    }
    return aErrors
  }

  login_uname(sValue) {
    let aErrors = []
    if (sValue.length === 0) {
      aErrors.push('Please enter your username')
    }
    return aErrors
  }

  login_pw(sValue) {
    let aErrors = []
    if (sValue.length === 0) {
      aErrors.push('Please enter your password')
    }
    return aErrors
  }

  reg_name(sValue) {
    let aErrors = []
    let mPattern = /^[a-zA-Z'. ]+$/

    if (sValue.length < 4) {
      aErrors.push('Please input at least 4 character(s)')
    } else if (sValue.length > 50) {
      aErrors.push(' Please input at most 50 characters')
    } else if (this.validatePattern(sValue, mPattern)) {
      aErrors.push(
        "Name must be alphabetic. It does not accept numbers and special characters except ' and ."
      )
    }
    return aErrors
  }

  reg_uname(sValue) {
    let aErrors = []
    let mPattern = /^(\d*[A-Za-z]+\d*)+$/

    if (sValue.length < 4) {
      aErrors.push('Please input at least 4 character(s)')
    } else if (sValue.length > 20) {
      aErrors.push(' Please input at most 20 characters')
    } else if (this.validatePattern(sValue, mPattern) === true) {
      aErrors.push('Username should only be alphabetic or alphanumeric')
    }

    return aErrors
  }

  reg_pw(sValue) {
    let aErrors = []
    let sConfirmPw = '#reg_confirm_pw'
    let mPattern = /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/

    if (sValue.length < 8) {
      aErrors.push('Please input at least 8 character(s)')
    } else if (sValue.length > 16) {
      aErrors.push(' Please input at most 20 characters')
    } else if (this.validatePattern(sValue, mPattern)) {
      aErrors.push('Password must be alphanumeric only')
    }
    if ($(sConfirmPw).val().length > 0) {
      $(sConfirmPw).change()
    }
    return aErrors
  }

  reg_confirm_pw(sValue) {
    let aErrors = []
    if (sValue !== $('#reg_pw').val() && sValue.length > 0) {
      aErrors.push('Password did not match')
    } else if (sValue.length === 0) {
      aErrors.push('Please input at least 8 character(s)')
    }
    return aErrors
  }
}
