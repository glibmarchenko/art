/**
 * Created by Creo on 19.05.2017.
 */

$artdiller = $('body');

$.fn.extend({
  animateShow(animationName) {
    const animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
    this.addClass(`animated ${animationName}`).one(animationEnd, function () {
      $(this).css('opacity', '1');
      $(this).removeClass(`animated ${animationName}`);
    });
  },
});

$.fn.extend({
  animateHide(animationName) {
    const animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
    this.addClass(`animated ${animationName}`).one(animationEnd, function () {
      $(this).css('opacity', '0');
      $(this).removeClass(`visible animated ${animationName}`);
    });
  },
});

$.fn.extend({
  animateToggle(animationNameIn, animationNameOut) {
    console.log($(this));
    if ($(this).hasClass('hidden')) {
      $(this).animateShow(animationNameIn);
    } else {
      $(this).animateHide(animationNameOut);
    }
  },
});

window.Utility = {
  authCheck() {
    console.log('auth check');
    if (laravel.authCheck !== 1) {
      console.log('Unauthorised');
      $('#login-modal').modal('show');
    }
    console.log(laravel.authCheck);
    return laravel.authCheck;
  },
};


$('.stylish input').click(function () {
  $(this).closest('div').find('select').slideToggle(110);
});

$('.stylish select').click(function () {
  $(this).hide().closest('div').find('input')
    .val($(this).find('option:selected').text());
});


$(document).ready(() => {
  $('.menu-sandwich').click(() => {
    console.log('menu click');
    $artdiller.trigger('menu-sandwich');
  });

  $('.show-notifications').click(() => {
    console.log('notification click');
    $artdiller.trigger('menu-notification');
  });
});

$(window).load(() => {
  $isotope = $('.isotope').isotope({
    // options...
    itemSelector: '.pic-content-block',
    masonry: {
      // gutter: 34,
    },
  });

  console.log('force redraw');
  $isotope.isotope('layout');
  $isotope.isotope('reloadItems');
});


/*
    Product section functionality
 */
$(document).ready(() => {
  const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  /* end PRODUCT section */

  /* MENU section */

  const $menuSection = $('.menu-section');
  const $menuSandwich = $('.menu-sandwich');
  $artdiller.on('menu-sandwich', () => {
    $('.slide-burger-menu').toggleClass('active');
    $('.burger-menu').toggleClass('active');
    $('.menu-sandwich').toggleClass('opened');

    const opened = $menuSandwich.data('opened');
    if (opened) {
      closeMenuSection();
    } else {
      openMenuSection();
    }
    $menuSandwich.find('.menu-trigger').toggleClass('active');
  });

  $(document).keyup((e) => {
    if (e.keyCode === 27) { // click ESC key
      if ($('.menu-trigger').hasClass('active')) { bindCloseMenuSection(e); } else if ($('.bl-close-zoom').length) {
        $('.bl-close-zoom').click();
      } else {
        $('.btn-icon-close').click();
      }
    } else if (e.keyCode === 37 && !$('.bl-zoom-now').length) { // click left arrow
      $('.btn-prev-item').click();
    } else if (e.keyCode === 39 && !$('.bl-zoom-now').length) { // click right arrow
      $('.btn-next-item').click();
    }
  });

  function bindCloseMenuSection(event) {
    if (event.target == undefined) {
      return;
    }
    if (!$(event.target).closest('.menu-section').length && !$(event.target).closest('.menu-sandwich').length && $menuSandwich.find('.menu-trigger').hasClass('active')) {
      $('.slide-burger-menu').toggleClass('active');
      $('.burger-menu').toggleClass('active');
      $('.menu-sandwich').toggleClass('opened');
      closeMenuSection();
      $menuSandwich.find('.menu-trigger').toggleClass('active');
    }
  }

  function bindCloseNotifSection(event) {
    if (!$(event.target).closest('.notifications-section').length && !$(event.target).closest('.show-notifications').length) {
      closeNotifSection();
    }
  }

  function openMenuSection() {
    $menuSection.velocity('transition.bounceRightIn');
    $menuSandwich.data('opened', 1);
    if (!$('.settings-block').length) {
      // $('.wrapper').addClass('tint-overlay');
    }
    /* $('#home-page').addClass('tint-overlay');
        $('#sub-nav-section').addClass('tint-overlay'); */
    $('.sub-menu-navigation').animateShow('fadeInRight');
  }

  function closeMenuSection() {
    $menuSection.velocity('transition.bounceRightOut');
    $menuSandwich.data('opened', 0);
    if ($menuSandwich.find('.menu-trigger').hasClass('active')) {
      /* $('.wrapper').removeClass('tint-overlay');
            $('#home-page').removeClass('tint-overlay');
            $('#sub-nav-section').removeClass('tint-overlay'); */
      $('.sub-menu-navigation').animateHide('fadeOutRight');
    }
  }

  /* end MENU section */
  /* CROPPER */

  let cropper;

  let isAuthorForm = null;
  let isUploadOn = 1;

  function readURL(input, gallery) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();

      reader.onload = function (e) {
        if (cropper) { cropper.destroy(); }

        let ratio = 1;
        if (!gallery) {
          console.log('author form!');
          isAuthorForm = 1;
        }
        if (gallery == '1') {
          isAuthorForm = 0;
          ratio = 3.15;
        }

        $(input).val(null); // clear input val for change same file

        $('#cropp').attr('src', e.target.result);
        $('.image-cropper').show();
        const image = document.getElementById('cropp');
        cropper = new Cropper(image, {
          aspectRatio: ratio / 1,
          viewMode: 2,
          /* preview: '.avatar-preview',
                    crop: function(e) {
                        //start_img_cropp(cropper);
                    }, */
          cropend() {
            startCroppingImage(cropper);
          },
        });

        cropper.artInput = input;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }


  function startCroppingImage(cropper) {
    const myimg = cropper.getCroppedCanvas({ width: 1000, height: 1000 });
    const b64data = myimg.toDataURL('image/jpeg');
    console.log(cropper.artInput);
    $(cropper.artInput.nextElementSibling).val(b64data);
    console.log('endCroppingImage');
    // console.log($('.img-res').val());
  }

  if ($('#avatar-preview').length) {
    if ($('#avatar-preview').hasClass('no-upload')) {
      isUploadOn = 0;
    }
    $('#img-change-file').change(function () {
      let gallery = null;
      console.log($(this));
      console.log($(this).hasClass('no-gallery'));
      if (!$(this).hasClass('no-gallery')) {
        gallery = $(this).data('gallery');
      }

      readURL(this, gallery);
    });

    $('#img-change-avatar').change(function () {
      console.log('change avatar?');
      const gallery = null;
      readURL(this, gallery);
    });

    $('.add-avatar').on('click', () => {
      $('#img-change-file').click();
    });

    $('.add-author-avatar').on('click', () => {
      $('#img-change-avatar').click();
    });

    $('.btn-cancel-crop').on('click', () => {
      $('.img-res').val('');
      $('.image-cropper').hide();
    });

    $('.btn-save-crop').on('click', function (e) {
      startCroppingImage(cropper);
      console.log('is author form?');
      console.log(isAuthorForm);
      if (isUploadOn === 0) {
        $('#avatar-preview').attr('src', $('.img-res').val());
        $('.image-cropper').hide();
        return true;
      }
      if (isAuthorForm) {
        $('#author-avatar-cropper').find('#avatar-preview').attr('src', $('.img-res').val());
        $('.image-cropper').hide();
        // saveCroppedImage();
      } else {
        $('#avatar-preview').attr('src', $('.img-res').val());
        $('.image-cropper').hide();
          console.log('scroll to form block bg');
          $([document.documentElement, document.body]).animate({
              scrollTop: $(".select2-small").offset().top
          }, 1500);
        if ($('#avatar-preview').hasClass('default-gallery-bg')) {
          $('#avatar-preview').removeClass('default-gallery-bg');
        }
        if ($(this).data('author') != '1') {
          // saveCroppedImage();
        }
      }
    });
  }

  /**
   * Save image via ajax
   * TODO: Выпилить функцию. Или сохранять фото обычным form submit, или на vue.js с блокированием действий, пока не сохранится
   *
   * @deprecated
   * @return void
   */
  function saveCroppedImage() {
    if (isAuthorForm) {
      var gallery = $('#img-change-avatar').data('gallery');
      var imageBase64 = $('#author-avatar-cropper').find('.img-res').val();
    } else {
      var gallery = $('#img-change-file').data('gallery');
      var imageBase64 = $('.img-res').val();
    }

    console.log(isUploadOn);
    if (isUploadOn === 1) {
      $.ajax({
        url: '/settings/profile/avatar',
        type: 'POST',
        data: { _token: CSRF_TOKEN, avatar_base64: imageBase64, gallery },
        dataType: 'JSON',
        success(data) {
          $('.img-res').val('');
          console.log($('.img-res').val());
        },
        error() {
        },
      });
    }
  }


  /* end CROPPER */

  /* SETTINGS page */

  $('.change-password').on('click', function () {
    $(this).parent().parent().hide();
    $('.password-block').show();
  });

  /* end SETTINGS page */


  /*
     Ajax Functionality for all forms with modal class
     */
  $(document).ready(() => {
    $('.modal-form').on('submit', function (e) {
      e.preventDefault(e);
      const $form = $(this).closest('form');
      const $modal = $(this).closest('.modal');
      const $formActionURL = $form.attr('action');
      const $errorBlock = $form.find('.error-block');
      const $token = $(this).closest('input[name="_token"]').val();
      const $successAction = $(this).attr('data-success-modal');
      const $successModal = $(`#${$(this).attr('data-success-modal')}`);
      $form.find('.form-error-message').hide().html('');
      $.ajax({
        type: 'POST',
        url: $formActionURL,
        headers: { 'X-CSRF-Token': $token },
        data: $form.serialize(),
        cache: false,
        success(resp) {
          if (resp.status == 'error') {
            $errorBlock.html(resp.responseJSON.message);
            $modal.velocity('callout.shake');
          } else if (resp.status == 'success') {
            if (resp.redirect != undefined && resp.redirect != 0) {
              window.location.href = '/';
              return;
            }

            window.location.reload();
            $errorBlock.html('');
            closeAndOpenModal($modal, $successModal);
          }
          if ($successAction == 'redirectHome') {
            window.location.href = '/';
            return;
          }
          $modal.modal('hide');
        },
        error(resp) {
          $.each(resp.responseJSON, (i, v) => {
            console.log(i);
            console.log(v);
            messageText = '';
            if ($.isArray(v)) { messageText = v[0]; } else { messageText = v; }

            $form.find(`.form-error-message[data-field="${i}"]`).html(messageText).show();
          });
          console.log(resp.responseJSON);
          if ($form.hasClass('simple-registration')) {
            analyticsTrigger('signup', 'validation error', 'simple-signup');
          }


          if ($successAction == 'redirectHome') {
            window.location.href = '/';
            return;
          }

          // $errorBlock.html(resp.responseJSON.message);
          // console.log($errorBlock);
          $modal.velocity('callout.shake');
        },
      });


      function closeAndOpenModal($closeModal, $openModal) {
        $closeModal.on('hidden.bs.modal', function (e) {
          // console.log('hideTrigger');
          $openModal.modal('show');
          $(this).off('hidden.bs.modal');
        });
        $closeModal.modal('hide');
      }
    });
  });

  /*
     END Ajax Functionality for all forms with modal class
     */


  if (window.location.href.indexOf('#login-modal') != -1) {
    $('#login-modal').modal('show');
  }
  if (window.location.href.indexOf('#reset-modal') != -1) {
    $('#reset-modal').modal('show');
  }
  if (window.location.href.indexOf('#registration-modal') != -1) {
    $('#registration-modal').modal('show');
  }

  if (window.location.href.indexOf('#saved') != -1) {
    $('#saved-modal').modal('show');
  }

  $('.checked-btn').on('click', function () {
    $(`.checked-btn[data-type="${$(this).data('type')}"]`).removeClass('active');
    $(this).addClass('active');
    $(`input[name="${$(this).data('type')}"]`).val($(this).data('val'));
  });

  $('.multi-checked-btn').on('click', function () {
    $(this).toggleClass('active');
    if ($(this).hasClass('active')) {
      $('form').find('input[data-name="materials"]');
    }
  });

  $('.select2').select2({
    dropdownCssClass: 'no-search',
    minimumResultsForSearch: Infinity,
    dropdownAutoWidth: true,
    width: 'auto',
  });

  $('.select2').on('select2:select', (e) => {
    const id = e.params.data.id;
    const option = $(e.target).children(`[value=${id}]`);
    option.detach();
    $(e.target).append(option).change();
  });

  $('.styles-select').select2({
    maximumSelectionLength: 3,
    language: {
      // You can find all of the options in the language files provided in the
      // build. They all must be functions that return the string that should be
      // displayed.
      maximumSelected(e) {
        return `Не более ${e.maximum} категорий`;
      },
    },
  });

  $('.show-check').on('click', () => {
    $('.cart-footer').toggleClass('show-details');
  });

  $('.radio-logist').on('change', function () {
    $('.delivery').html(`<span class="detail-price">${$(this).data('price')}</span><span class="detail-currency">USD</span>`);
    $('.tax').html(`<span class="detail-price">${$(this).data('tax')}</span><span class="detail-currency">USD</span>`);
    $('.delivery-name').html($(this).data('name'));

    const sum = calculateTotalSum();
    if (sum) {
      $('.cart-total').addClass('completed');
    } else {
      $('.cart-total').removeClass('completed');
    }
  });

  function calculateTotalSum() {
    let total = 0;
    $('.row-value').each(function () {
      total += parseInt($(this).find('.detail-price').text());
    });
    if (isNaN(total)) {
      total = 0;
    }
    $('.total-price').html(total);
    return total;
  }


  $(document).click((event) => {
    if (!$(event.target).closest('.submenu').length && !$(event.target).closest('.btn-add-item-dropdown').length) {
      $('.submenu').fadeOut(200);
    }
  });

  $('.btn-add-item-dropdown').on('click', function (e) {
    e.preventDefault();
    $(`.submenu[data-type="${$(this).data('type')}"]`).fadeToggle(200);
  });

  $.fn.isInViewport = function () {
    const elementTop = $(this).offset().top;
    const elementBottom = elementTop + $(this).outerHeight();

    const viewportTop = $(window).scrollTop();
    const viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
  };

  $('.btn-delete-author').on('click', function () {
    $.ajax({
      url: `/settings/authors/delete/${$(this).data('id')}`,
      type: 'POST',
      data: { _token: CSRF_TOKEN },
      dataType: 'JSON',
      success(data) {
        window.location.href = '/settings/authors';
      },
      error() {

      },
    });
  });

  $('.select-gallery-author').on('change', function () {
    if ($(this).val() == 'add_author') {
      window.location.href = '/settings/authors/add';
    } else {
      $('.block-content-gallery').fadeIn();
    }
  });
});

/**
 * Add checked materials to form inputs
 */
$(document).ready(() => {
  $('.form-item-create').on('submit', function () {
    $(this).find('button[type="submit"]').attr('disabled', 'disabled');
    const form = $(this);
    $('.multi-checked-btn[data-type="materials"]').each(function () {
      if ($(this).hasClass('active')) {
        $(form).append($('<input>')
          .attr('type', 'hidden')
          .attr('name', 'materials[]').val($(this).data('content')));
      }
    });
  });
});

$(document).ready(() => {
  $('#profileSubmit').click(() => {
      $('#loader').removeClass('hidden');
  });
});

/**
 * Block right click on entire website
 */
$(document).ready(() => {
  $('img').each(function () {
    $(this)[0].oncontextmenu = function () {
      return false;
    };
  });
  $('#zoom-image').each(function () {
    $(this)[0].oncontextmenu = function () {
      return false;
    };
  });
});

/**
 * Form submit loader
 */
$(document).ready(() => {
  $submitButton = $('.form-item-create').find('.btn-fill-red');
  $submitButtonRow = $('.submit-row');
  $('.form-item-create').submit((event) => {
    loading = "<img src='/images/loading.svg'>";
    $submitButtonRow.html(loading);
  });
});

/**
 * Country Select2 select edit form fill on page load
 */
$(document).ready(() => {
  if ($('#country-select').length) {
    $('#country-select').val($('#country-select').attr('data-chosen')).trigger('change');
    console.log('setting country select');
  }
});

/**
 * Facebook share open in new window
 */
$(document).ready(() => {
  $('.fb-share').click(function (e) {
    e.preventDefault();
    window.open($(this).attr('href'), 'fbShareWindow', `height=450, width=550, top=${$(window).height() / 2 - 275}, left=${$(window).width() / 2 - 225}, toolbar=0, location=0, menubar=0, directories=0, scrollbars=0`);
    return false;
  });
});

/**
 * Metatags action
 */
$(document).ready(() => {
  $artdiller.on('metatags-set', (e, metatags) => {
    console.log(e);
    console.log(metatags);
    $.each(metatags, (index, metatag) => {
      console.log('metatag set');
      console.log(metatag);
      $(`meta[property=og\\:${metatag.name}]`).attr('content', metatag.value);
    });
  });
});

/**
 * User Edit forms Nickname suggestion
 */
$(document).ready(() => {
  const $nicknameSelect = $('.nicknames ');
  /* REGISTER page */

  if ($nicknameSelect.length) {
    $('.form-user-info input').on('input', function () {
      if ($(this).attr('name') == 'name' || $(this).attr('name') == 'surname' || $(this).attr('name') == 'pseudonym') { generateUserNicknames(); }
    });

    generateUserNicknames();
  }

  function generateUserNicknames() {
    const params = [];
    const chosenValue = $nicknameSelect.attr('data-val');
    let options = '<option value="" selected></option>';
    $('.form-user-info input').each(function () {
      if ($(this).attr('name') == 'name' || $(this).attr('name') == 'surname' || $(this).attr('name') == 'pseudonym') { params.push($(this).val()); }
    });
    const cases = allPossibleCases(params, 1);
    const issetOptions = [];
    let changedText = '';
    if ($nicknameSelect.data('changed')) {
      changedText = $('.nicknames').data('changed');
    }
    $.each(cases, (i, v) => {
      optionName = '';
      $.each(v, (i, v) => {
        if (v !== '') {
          optionName += `${v} `;
        }
      });
      if (optionName != '' && issetOptions[optionName] == undefined) {
        optionName = optionName.slice(0, -1);
        issetOptions[optionName] = 1;
        changeString = '';
        if (changedText == optionName.trim()) {
          changeString = 'selected';
        }
        if (chosenValue == optionName) {
          options += `<option selected value="${optionName}"${changeString}>${optionName}</option>`;
        } else {
          options += `<option value="${optionName}"${changeString}>${optionName}</option>`;
        }
      }
    });
    $nicknameSelect.html(options);
  }

  /**
     * Sort out possible combinations of array
     *
     * @param a - array
     * @param min - min combination count
     * @returns {Array}
     */
  function allPossibleCases(a, min) {
    const fn = function (n, src, got, all) {
      if (n === 0) {
        if (got.length > 0) {
          all[all.length] = got;
        }
        return;
      }
      for (let j = 0; j < src.length; j++) {
        fn(n - 1, src.slice(j + 1), got.concat([src[j]]), all);
      }
    };
    const all = [];
    for (let i = min; i < a.length; i++) {
      fn(i, a, [], all);
    }
    all.push(a);
    return all;
  }
});

/**
 * Gallery.show About block Show / Hide
 */
$(document).ready(() => {
  $('.terms-popup').on('click', () => {
    console.log('on click about popup');
    $artdiller.trigger('terms-show');
  });

  $artdiller.on('terms-show', () => {
    $('html, body').css({
      overflow: 'hidden',
      height: '100%',
    });
    $('#terms-about-popup').velocity('transition.fadeIn');
    $('.terms-about-container').velocity('transition.flipYIn', { duration: 310 });
  });

  $('#terms-about-popup').on('click', () => {
    $('html, body').css({
      overflow: 'auto',
      height: 'auto',
    });
    $('#terms-about-popup').velocity('transition.fadeOut');
    $('.terms-about-container').velocity('transition.flipYOut', { duration: 310 });
  });
});


/**
 * Registration Rules SHow Hide
 */
$(document).ready(() => {
  $('#show-rules').on('click', () => {
    if (laravel.authCheck == 1) {
      $('.modal-close-wrapper').hide();
    }
    $('#rules-block').velocity('transition.fadeIn');

    $('#rules-close').on('click', () => {
      if (laravel.authCheck !== 1) {
        $('#rules-block').velocity('transition.fadeOut');
      } else {
        $('#registration-modal').modal('hide');
      }
    });
  });
  $('#footer_rules').on('click', () => {
    $('#show-rules').trigger('click');
  });
});


/**
 * Gallery.show Authors Show / Hide
 */
$(document).ready(() => {
  const $authorsButton = $('#show-all-authors');
  if ($authorsButton.length) {
    let isDisplayed = false;
    $authorsButton.on('click', () => {
      if (!isDisplayed) {
        $('#authors-gallery-list').addClass('expand');
        $authorsButton.html('Скрыть');
      } else {
        $('#authors-gallery-list').removeClass('expand');
        $authorsButton.html('Показать всех');
      }
      isDisplayed = !isDisplayed;
    });
  }
});


/**
 * Gallery.show About block Show / Hide
 */
$(document).ready(() => {
  $('.gallery-popup').on('click', () => {
    console.log('on click about popup');
    $('#gallery-about').trigger('click');
  });

  $('#gallery-about').on('click', () => {
    // $artdiller.trigger('show-gallery-about');
    $('html, body').css({
      overflow: 'hidden',
      height: '100%',
    });
    $('#gallery-about-popup').velocity('transition.fadeIn');
    $('.gallery-about-container').velocity('transition.flipYIn', { duration: 310 });
  });
  $('#gallery-about-popup').on('click', () => {
    $('html, body').css({
      overflow: 'auto',
      height: 'auto',
    });
    $('#gallery-about-popup').velocity('transition.fadeOut');
    $('.terms-about-container').velocity('transition.flipYOut', { duration: 310 });
  });
});

/**
 * Mobile Gallery.show About, Info block Show / Hide
 */
$(document).ready(() => {
  $('.mob-navigation .cols').on('click', function () {
    $('.opened').velocity('slideUp');
    $('section').removeClass('opened');

    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      return;
    }
    $('.mob-navigation .cols').removeClass('active');
    $(this).addClass('active');

    if ($(this).is('.info.active')) {
      $('#info-box').velocity('slideDown');
      $('#info-box').addClass('opened');
    } else if ($(this).is('.author.active')) {
      $('section.authors-bar').velocity('slideDown');
      $('section.authors-bar').addClass('opened');
    }
  });
});
/**
 * Mobile Left Menu Show / Hide
 */
$(document).ready(() => {
  const $menuSandwich = $('.left-mob-menu');
  $artdiller.on('click', '.left-mob-menu', () => {
    $menuSandwich.toggleClass('opened-left');
    const opened = $menuSandwich.hasClass('opened-left');

    if (opened) {
      if ($('.right-mob-menu').hasClass('active')) {
        $('.right-mob-menu').removeClass('active');
        $('.menu-section').velocity('transition.bounceRightOut');
        $('.menu-sandwich').data('opened', 0);
        if ($('.menu-sandwich').find('.menu-trigger').hasClass('active')) {
          $('.sub-menu-navigation').animateHide('fadeOutRight');
        }
      }
      $('#nav-section .left-menu').velocity('transition.bounceLeftIn');
    } else {
      $('#nav-section .left-menu').velocity('transition.bounceLeftOut');
    }

    $menuSandwich.find('.menu-trigger').toggleClass('active');
  });
});

$(document).ready(() => {
  const $menuSandwich = $('.right-mob-menu');
  $artdiller.on('click', '.right-mob-menu', () => {
    $menuSandwich.toggleClass('active');
    const opened = $('.left-mob-menu').hasClass('opened-left');
    if (opened) {
      $('#nav-section .left-menu').velocity('transition.bounceLeftOut');
      $('.left-mob-menu').removeClass('opened-left');
      $('.left-mob-menu').find('.menu-trigger').removeClass('active');
    }
  });
});
