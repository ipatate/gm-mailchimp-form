var gmTimeShow = 8000

/**
 * check email
 * @param {string} text
 * @returns boolean
 */
var isEmail = function (text) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  return re.test(text)
}

/**
 * show the modal by removing the class and replacing it after x milliseconds
 * @param {string} target id
 * @param {string} classname hidden
 */
function showModal(target, classname) {
  var modal = document.getElementById(target)
  modal.classList.remove(classname)
  setTimeout(() => {
    modal.classList.add(classname)
  }, gmTimeShow)
}

/**
 * main function
 */
document.addEventListener('DOMContentLoaded', function () {
  document
    .getElementById('gm-mailchimp-form-status')
    .addEventListener('click', function (e) {
      e.preventDefault()
      e.currentTarget.classList.add('gm-mailchimp-form-status-hidden')
    })

  document
    .getElementById('gm-mailchimp-form')
    .addEventListener('submit', function (e) {
      e.preventDefault()
      var button = document.getElementById('gm-mailchimp-form-submit')
      var form = e.currentTarget
      // input filled
      if (
        form.email.value !== '' &&
        form.lastname.value !== '' &&
        form.firstname.value !== '' &&
        form.accept.value !== '' &&
        isEmail(form.email.value)
      ) {
        var request = new XMLHttpRequest()
        request.onreadystatechange = function () {
          button.setAttribute('disabled', 'true')
          if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText)
            // error
            if (res.error) {
              // show wrapper modal
              showModal(
                'gm-mailchimp-form-status',
                'gm-mailchimp-form-status-hidden',
              )
              // show message error
              showModal(
                'gm-mailchimp-form-error',
                'gm-mailchimp-form-modal-hidden',
              )
              // user exist or delected
              var message =
                res.message === 'USER_EXIST'
                  ? gmMailchimpFormErrorMessageAlreadySubsribed
                  : gmMailchimpFormErrorMessageDeleted
              button.removeAttribute('disabled')

              return (document.querySelector(
                '.gm-mailchimp-form-error span.gm-message',
              ).innerHTML = message)
            }
            // success
            // show wrapper modal
            showModal(
              'gm-mailchimp-form-status',
              'gm-mailchimp-form-status-hidden',
            )
            // show success message
            showModal(
              'gm-mailchimp-form-success',
              'gm-mailchimp-form-modal-hidden',
            )
            form.reset()
            button.removeAttribute('disabled')
            return (document.querySelector(
              '.gm-mailchimp-form-success span.gm-message',
            ).innerHTML = gmMailchimpFormSuccessMessage)
          }
        }

        request.open('POST', '/wp-json/gm_mailchimp_form/action')
        request.send(new FormData(e.currentTarget))
      }
    })
})
