var Checkout = (function() {
    var totalAmount        = 0;
    var encryptionKey      = null;
    var facebookAccessData = false;

    function Checkout(bolLoggedIn, encryption_key, total) {
        encryptionKey = encryption_key;
        totalAmount   = total;

        initValidator();
        initEvents();
        initIdentification();

        if (bolLoggedIn) {
            this.initStepPay();
        } else {
            facebookGetStatus();
        }
    }

    function initValidator() {
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
        $.validator.messages.required = 'Preencha este campo.';
    }

    function initEvents() {


        $('.payment-method').on('change', function () {
            var cartao = $(this).val() === 'credit_card';
            $('.payment-form-card').toggleClass('hidden', !cartao);
            $('.payment-form-boleto').toggleClass('hidden', cartao);

            $('#resumo-forma-pagamento').html('');
            if (cartao) {
                $('#inputParcelas').val('');
            }
        });

        $('.link-modal-termos').on('click', function(){
            var url= $(this).data('href');
            $('#modal-termos .modal-body').load(url, function() {
                $('#modal-termos').modal({show:true});
            });
        });

        //credit card
        $('#inputCardNumber').mask('0000 0000 0000 0000');
        $('#inputCardCVV').mask('0009');
        $('#inputCardExpiration').mask('00/00');
    }

    function dualBlockToggle(open, close) {
        $(open).toggleClass('hidden', false);
        $(close).toggleClass('hidden', true);
    }

    function initIdentification() {
        $('.btn-abrir-login').on('click', function () {
            dualBlockToggle('.login-block', '.cadastro-block');
        });

        $('.btn-abrir-cadastro').on('click', function () {
            dualBlockToggle('.cadastro-block', '.login-block');
        });

        initLogin();
        initCadastro();
    }

    function initLogin() {
        var loginForm = $('#login-form');
        if (loginForm.length) {
            loginForm.validate();

            loginForm.submit(function (e) {
                e.preventDefault();
                if (loginForm.valid()) {
                    submitLogin();
                }
            });
        }
        $('.btn-entrar-facebook').on('click', facebookLogin);
    }

    function submitLogin()
    {
        var loginForm = $('#login-form');
        loginForm.find('button').prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: loginForm.prop('action'),
            data: loginForm.serialize(),
            success: function (data) {
                $('.step-identification').html(data);
                loginForm = $("#login-form");
                initIdentification();

                var errorMessages = loginForm.find('.error-message');
                if (errorMessages.length) {
                    errorMessages.first().prev('input,select').focus();
                }
            },
            error: function () {
                alert('Não foi possível efetuar o login no momento. Tente novamente.');
            },
            complete: function() {
                loginForm.find('button').prop('disabled', false)
            }
        });
    }

    function initCadastro() {
        var cadastroForm = $("#cadastro-form");
        if (cadastroForm.length) {
            cadastroForm.validate();
            cadastroForm.submit(function (e) {
                e.preventDefault();
                if (cadastroForm.valid()) {
                    cadastroForm.find(':submit').prop('disabled', true);
                    $.ajax({
                        type: 'POST',
                        url: $(this).prop('action'),
                        data: $(this).serialize(),
                        success: function (data) {
                            $('.step-identification').html(data);
                            cadastroForm = $("#cadastro-form");
                            initIdentification();

                            var errorMessages = cadastroForm.find('.error-message');
                            if (errorMessages.length) {
                                errorMessages.first().prev('input,select').focus();
                            }
                        },
                        error: function () {
                            alert('Não foi possível efetuar o login no momento. Tente novamente.');
                        },
                        complete: function () {
                            cadastroForm.find(':submit').prop('disabled', false)
                        }
                    });
                }
            });

            cadastroForm.find(':input').on('change', function() {
                $(this).next('.error-message').remove();
            });
        }
    }

    function stepPay() {
        $('#finish-buy').toggleClass('stepPay', true).toggleClass('stepEnd', false);
        $('#finish-buy .payment-method').prop('disabled', false);

        $('#btn-finalizar').prop('disabled', true);
    }

    function initCupom() {
        var cupomForm = $("#cupom-form");
        if (cupomForm.length) {
            $('#finish-buy #inputCupom').prop('disabled', false);
            $('#finish-buy #btnCupom').prop('disabled', false);

            cupomForm.validate();
            cupomForm.submit(function (e) {
                e.preventDefault();
                if (cupomForm.valid()) {
                    cupomForm.find(':submit').prop('disabled', true);
                    $.ajax({
                        type: 'POST',
                        url: $(this).prop('action'),
                        data: $(this).serialize(),
                        success: function (data) {
                            $('.cupom-block').html(data);
                            cupomForm = $("#cupom-form");
                            initCupom();
                        },
                        error: function () {
                            alert('Não foi possível validar o cupom. Tente novamente.');
                        },
                        complete: function () {
                            cupomForm.find(':submit').prop('disabled', false);
                            refreshResume();
                        }
                    });
                }
            });

            cupomForm.find(':input').on('change', function() {
                $(this).next('.error-message').remove();
            });
        }
    }

    function refreshResume() {
        $.ajax({
            type: 'GET',
            url: '/orders/payment?refresh_resume',
            success: function(data) {
                $('.step-resume').html(data);
                initEvents();
                checkStep();
            }
        });
    }

    function initPaymentForm() {
        var form = $("#payment-form");
        form.trigger('reset');

        var isCard = function() {
            return $('#paymentMethodCard').prop('checked');
        };

        jQuery.validator.addMethod("cartao", function(value, element, params) {
            if (this.optional(element)) {
                return true;
            } else {
                var validations = creditCardValidation();
                return validations.hasOwnProperty('card') && validations.card[params[0]] !== false
            }
        }, jQuery.validator.format("{1}"));

        form.validate({
            rules: {
                "data[Order][payment_method]": "required",
                "data[Order][card_number]": {
                    required: isCard,
                    cartao: ['card_number', 'Número do cartão inválido.']
                },
                "data[Order][card_holder_name]": {
                    required: isCard,
                    cartao: ['card_holder_name', 'Nome do portador inválido.']
                },
                "data[Order][card_expiration_date]": {
                    required: isCard,
                    cartao: ['card_expiration_date', 'Validade inválida.']
                },
                "data[Order][card_cvv]": {
                    required: isCard,
                    cartao: ['card_cvv', 'Código de segurança inválido.']
                },
                "data[Order][installments]": {
                    required: isCard
                }
            },
            onkeyup: false
        });

        form.find(':input').on('change keyup', checkStep);
    }

    function checkStep() {
        if ($("#payment-form").validate().checkForm()) {
            stepEnd();
        } else {
            stepPay();
        }
    }

    function stepEnd() {
        $('#btn-finalizar').prop('disabled', false).on('click', finish);

        $('#finish-buy').toggleClass('stepPay', false).toggleClass('stepEnd', true);

        var isCartao = $('#paymentMethodCard').prop('checked');

        if (isCartao) {
            var parcela = $('#inputParcelas :selected');
            if (parcela && parcela.val() !== '') {
                $('#resumo-forma-pagamento').html('Em ' + parcela.text() + ' no cartão');
            } else {
                $('#resumo-forma-pagamento').html('');
            }
        } else {
            $('#inputParcelas').val('');
            $('#resumo-forma-pagamento').html('No boleto bancário');
        }
    }

    function getCreditCardObject() {
        return {
            card_number: $('#inputCardNumber').val(),
            card_holder_name: $('#inputCardHolder').val(),
            card_expiration_date: $('#inputCardExpiration').val(),
            card_cvv: $('#inputCardCVV').val()
        }
    }

    function creditCardValidation() {
        var cardValidations = {};

        try {
            cardValidations = pagarme.validate({card: getCreditCardObject()});
        } catch (e) {

        }

        var cardBrand = $('.card-brand');
        cardBrand.removeClass(function (index, css) {
            return (css.match (/\bicon-\S+/g) || []).join(' ');
        });
        if (cardValidations.hasOwnProperty('card') && cardValidations.card.hasOwnProperty('brand')) {
            cardBrand.addClass('icon-' + cardValidations.card.brand, true);
        }

        return cardValidations;
    }

    function formatMoney(n, c, d, t){
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d === undefined ? "." : d,
            t = t === undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }

    function creditCardInstallments() {
        var installments = [];
        for (var x = 1; x <= 10; x++) {
            var amount = Math.round((totalAmount / x) * 100) / 100;
            if (amount > 0.00) {
                amount = formatMoney(amount, 2, ',', '.');
                installments.push({parcela: x, valor: amount});
            }
        }

        var inputParcelas = $('#inputParcelas');
        inputParcelas.html('<option value=""></option>').val('');
        $.each(installments, function(key, val) {
            inputParcelas.append($("<option></option>").prop("value", val.parcela).text(val.parcela + 'x de R$ ' + val.valor + ' - s/ juros'));
        });
    }

    function finish() {
        var form = $("#payment-form");
        if (form.valid()) {
            var isCartao = $('#paymentMethodCard').prop('checked');

            if (isCartao) {

                var card = getCreditCardObject();

                var showError = function() {
                    alert('Houve um erro ao validar os dados do seu cartão. Nenhuma cobrança foi efetuada. Tente novamente.');
                };

                pagarme.client.connect({ encryption_key: encryptionKey}).then(
                    function(client) {
                        client.security.encrypt(card).then(
                            function(card_hash) {
                                $('#inputCardHash').val(card_hash);
                                form.submit().find(':input').prop('disabled', true);
                                $('#btn-finalizar').prop('disabled', true);
                            }, showError
                        );
                }, showError);

            } else {
                form.submit().find(':input').prop('disabled', true);
                $('#btn-finalizar').prop('disabled', true);
            }
        }
    }

    function facebookGetStatus() {
        facebookAccessData = null;

        if (typeof FB !== 'undefined') {
            FB.getLoginStatus(function (response) {
                if (response.status === 'connected') {
                    FB.api('/me', {fields: 'id,name,email'}, function(response) {
                        facebookAccessData = response
                    });
                }
            });
        } else {
            if (facebookAccessData === null) {
                setTimeout(facebookGetStatus, 900);
            }
        }
    }

    function facebookLogin()
    {
        if (typeof FB === 'undefined') {
            alert('O Login com o Facebook não está disponível no momento.');
            return false;
        }

        var sendLogin = function(responseData) {
            $('#input-facebook-json').val(JSON.stringify(responseData));
            submitLogin();
        };

        if (facebookAccessData) {
            sendLogin(facebookAccessData);
        } else {
            if (typeof FB !== 'undefined') {
                FB.login(function (responseLogin) {
                    if (responseLogin.status === 'connected') {
                        FB.api('/me', {fields: 'id,name,email'}, function (response) {
                            sendLogin(response);
                        });
                    }
                }, {scope: 'public_profile,email'});
            }
        }
    }

    function isEmpty(val) {
        return val === '' || val === null || val === undefined;
    }

    function verifyUser(user) {
        if (isEmpty(user.name) || user.name.trim().split(' ').length < 2 ||
            isEmpty(user.cpf) || isEmpty(user.email)
        ) {
            completeUserRegister(user);
            return false;
        } else {
            loggedUser = user;
            return true;
        }
    }

    function completeUserRegister(user) {
        $('.pre-login-block').toggleClass('hidden', true);
        $('.pre-cadastro-block h4').html('FINALIZE SEU CADASTRO');
        $('.pre-cadastro-block .btn-abrir-cadastro').toggleClass('hidden', true);
        $('.cadastro-block').toggleClass('hidden', false);

        $('#input-cadastro-name').val(user.name);
        $('#input-cadastro-cpf').val(user.cpf);
    }

    Checkout.prototype.initStepPay = function(scroll)
    {
        if (scroll) {
            $('html, body').animate({
                scrollTop: $("h1").offset().top
            }, 500);
        }
        initCupom();
        initPaymentForm();
        creditCardInstallments();
        stepPay();
    };

    Checkout.prototype.setTotalAmount = function(amount)
    {
        totalAmount = amount;
        creditCardInstallments();
    };

    return Checkout;
})();

