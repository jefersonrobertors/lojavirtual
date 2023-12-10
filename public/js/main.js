var updateProgressBar, maxSteps = 3, currentStep = 1;
function displayStep(stepNumber) {
    if(stepNumber >= 1 && stepNumber <= maxSteps) {
        $(".step-" + currentStep).hide();
        $(".step-" + stepNumber).show();
        currentStep = stepNumber;
        updateProgressBar();
    }
}
$(document).ready(function (){
    const email = $('.email'),
        comment = $('#comment'),
        password = $('#password'),
        confirm_password = $('#confirm-password'),
        image = $('#image'),
        cpf = $('#cpf'),
        cep = $('#cep'),
        address = $('#address'),
        complement = $('#complement'),
        state = $('#state'),
        city = $('#city'),
        image_preview = $('#preview'),
        district = $('#district'),
        full_name = $('#full-name'),
        phone_number = $('#phone-number');

    // var updateProgressBar, maxSteps = 3, currentStep = 1;

    const stateList = [
        'AC', 
        'AL', 
        'AP', 
        'AM', 
        'BA', 
        'CE', 
        'DF', 
        'ES', 
        'GO', 
        'MA', 
        'MT', 
        'MS', 
        'MG', 
        'PA', 
        'PB', 
        'PR', 
        'PE', 
        'PI', 
        'RJ', 
        'RN', 
        'RO', 
        'RS', 
        'RR', 
        'SC', 
        'SP', 
        'SE', 
        'TO'
    ];

    $.fn.mask = function (mask) {
        $(this).on('input', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const input = $(this);
            let value = input.val().replace(/\D/g, ''), format = '';

            for(let x = 0, i = 0; x < mask.length && i < value.length; x++) {
                format += mask.charAt(x).includes('#') ? value.charAt(i++) : mask.charAt(x);
            }
            input.val(format);
        });
    };

    $.fn.email = function () {
        const input = $(this);
        let text = '';
        const inputValue = input.val().trim();

        input.removeClass('is-valid is-invalid');

        if(inputValue.length > 0) {
            if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(inputValue)) {
                input.addClass('is-valid');
            }else{
                input.addClass('is-invalid');
                text = 'E-mail inválido!';
            }
        }else{
            input.addClass('is-invalid');
            text = 'Campo obrigatório!';
        }
        input.parents('.input-floating').find('.help-block').html(text);
    };

    $.fn.suggests = function (domains) {
        const suggests = $('#suggests');
        const input = $(this);

        if(domains.length == 0) return;

        input.on('keyup', function (event) {
            event.preventDefault();
            event.stopPropagation();
            
            const value = input.val().trim();
            const keyCode = event.keyCode;
            
            const handleArrowKeys = () => {
                let highlighted = $(".highlighted"), highlight;
               
                if(highlighted.length == 0) {
                    let list = suggests.find('li');
                    list.siblings().removeClass('highlighted');
                    highlighted = list.first().addClass('highlighted');
                }
                if(keyCode === 40) {
                    highlight = highlighted.next();
                }else if(keyCode === 38) {
                    highlight = highlighted.prev();
                }
                const highlightPosition = highlight.position(), suggestsPosition = suggests.position();

                if(highlightPosition && suggestsPosition) {
                    suggests.scrollTop(suggests.scrollTop() + (highlightPosition.top - suggestsPosition.top) - (suggests.height() / 2) + (highlight.height() / 2));
                }
                highlight.addClass('highlighted');
                highlight.siblings().removeClass('highlighted');
            };

            const handleEnterKey = () => {
                input.val($('.highlighted').text());
                suggests.hide();
            };
          
            const generateSuggestions = () => {
                const exactMatches = [], errorMatches = [], emailsDirty = value.split("@");

                suggests.empty().hide();
                
                if(emailsDirty.length < 2 || emailsDirty[0] === "") return;
                
                const emailDomain = emailsDirty[1];
                
                if(emailDomain.length === 0) {
                    domains.filter((domain) => exactMatches.push(domain));
                }else{
                    $.each(domains, function (index, domain) {
                        const testString = domain.substr(0, emailDomain.length);
                    
                        if(emailDomain === testString) {
                            exactMatches.push(domain);
                        }else{
                            let k = undefined, a = emailDomain, b = testString;
                    
                            if(a.length === 0) {
                                k = b.length;
                            }
                            if(b.length === 0) {
                                k = a.length;
                            }
                            if(typeof k !== 'undefined') {
                                var matrix = [];
                                
                                for(let i = 0; i <= b.length; i++) {
                                    matrix[i] = [i];
                                }
                                 for(let j = 0; j <= a.length; j++) {
                                    matrix[0][j] = j;
                                }
                                for(let i = 1; i <= b.length; i++) {
                                    for(let j = 1; j <= a.length; j++) {
                                        if(b.charAt(i - 1) == a.charAt(j - 1)) {
                                            matrix[i][j] = matrix[i - 1][j - 1];
                                        }else{
                                            matrix[i][j] = Math.min(matrix[i - 1][j - 1] + 1, Math.min(matrix[i][j - 1] + 1, matrix[i - 1][j] + 1));
                                        }
                                    }
                                }
                                k = matrix[b.length][a.length];
                            }        
                            if(k < 2 && emailDomain.length > 1) {
                                errorMatches.push(domains[k]);
                            }
                        }
                    });
                }
                if(exactMatches.length > 0) {
                    $.each(exactMatches, function (index, match) {
                        const subStr = match.substr(emailDomain.length, match.length);
                        
                        if(subStr.length !== 0) suggests.append('<li class="list-item">' + value + "<b>" + subStr + "</b></li>");
                    });
                }else if(errorMatches.length > 0) {
                    $.each(errorMatches, function (index, match) {
                        suggests.append('<li class="list-item">' + emailsDirty[0] + "@<b>" + match + "</b></li>");
                    }); 
                }
                if(exactMatches.length > 0 || errorMatches.length > 0) {
                    const list = suggests.find('.list-item');
                    list.first().addClass("highlighted");
                    list.each(function () {
                        const element = $(this);

                        element.on('click', function (event) {
                            event.preventDefault();
    
                            input.val($(this).text());

                            input.email();
                            
                            suggests.empty().hide();
                        });
                    
                        element.mouseover(function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            
                            $(this).addClass('highlighted');
                            $(this).siblings().removeClass('highlighted');
                        });
                        
                        element.mouseout(function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            
                            $(this).removeClass('highlighted');
                        });
                    });
                    suggests.show();
                }
            };
            if(keyCode === 40 || keyCode === 38) {
                handleArrowKeys();
            }else if(keyCode === 13) {
                handleEnterKey();
            }else{
                generateSuggestions();
            }
        });
    };

    const validateCPF = (value) => {
        value = value.replace(/[^\d]+/g, '');
        
        if(value.length !== 11) {
            return false;
        }
        if(/^(\d)\1+$/.test(value)) {
            return false;
        }
        for(var i = 1; i < value.length; i++) {
            if(value.charAt(i) !== value.charAt(0)) {
                break;
            }
        }
        if(i === value.length - 1) {
            return false;
        }
        var sum = 0;
        var remainder;

        for(var i = 1; i <= 9; i++) {
            sum = sum + parseInt(value.charAt(i-1)) * (11 - i);
        }
        remainder = (sum * 10) % 11;
      
        if((remainder === 10) || (remainder === 11)) {
            remainder = 0;
        }
        if(remainder !== parseInt(value.charAt(9))) {
            return false;
        }
        sum = 0;
        for(var i = 1; i <= 10; i++) {
            sum = sum + parseInt(value.charAt(i-1)) * (12 - i);
        }
        remainder = (sum * 10) % 11;
    
        if((remainder === 10) || (remainder === 11)) {
            remainder = 0;
        }
        if(remainder !== parseInt(value.charAt(10))) {
            return false;
        }
        return true;
    };

    const updatePasswordStrength = (value) => {
        const strength = calculatePasswordStrength(value);
        const sections = $('.meter-section').removeClass('weak medium strong very-strong');
        const strengthText = $('.strength-label').html('');

        let text;

        if(strength >= 1) {
            sections.eq(0).addClass('weak');
            text = 'Fraco';
        }
        if(strength >= 2) {
            sections.eq(1).addClass('medium');
            text = 'Média';
        }
        if(strength >= 3) {
            sections.eq(2).addClass('strong');
            text = 'Forte';
        }
        if(strength >= 4) {
            sections.eq(3).addClass('very-strong');
            text = 'Muito Forte';
        }
        strengthText.html(text);
    };

    const calculatePasswordStrength = (value) => {
        const criteriaWeights = {
            length: 0.2,
            uppercase: 0.4,
            lowercase: 0.4,
            number: 0.6,
            symbol: 1
        };
        let strength = 0;
    
        strength += value.length * criteriaWeights.length;
    
        if(/[A-Z]/.test(value)) {
            strength += criteriaWeights.uppercase;
        }
        if(/[a-z]/.test(value)) {
            strength += criteriaWeights.lowercase;
        }
        if(/\d/.test(value)) {
            strength += criteriaWeights.number;
        }
        if(/[^A-Za-z0-9]/.test(value)) {
            strength += criteriaWeights.symbol;
        }
        if(/^(\d)\1+$/.test(value)) {
            strength -= 2.4;
        }
        if(/\s/.test(value)) {
            password.removeClass('is-valid').addClass('is-invalid');
            strength = 0;
        }
        return strength;
    };

    const domains = ["aol.com", "facebook.com", "gmail.com", "googlemail.com",
    "google.com", "hotmail.com", "hotmail.co.uk", "mac.com", "me.com", "mail.com", "msn.com",
    "live.com", "yahoo.com", "yahoo.co.uk"];

    $('.email').suggests(domains);

    cpf.mask('###.###.###-##');
    phone_number.mask('(##) ####-####');
    cep.mask('#####-###');

    $('.form-register').find('.step').slice(1).hide();

    updateProgressBar = () => $('.progress-bar').css('width', (((currentStep - 1) / 2) * 100) + '%');

    $(".previous-step").click(function (event) {
        event.preventDefault();

        if(currentStep === 1) {
            return;
        }
        currentStep--;
        
        $(".step").hide();
        $(".step-" + currentStep).show();

        updateProgressBar();
    });

    $(".next-step").click(function (event) {
        event.preventDefault();
        let errors = 0;
        $('.form-register').find(".step-" + currentStep + " input[data-required]").each(function () {
            let text = '';
            const input = $(this),
                required = Boolean(input.data('required')),
                name = String(input.data('custom-name'));

            if(required) {
                if(!input.hasClass('is-valid')) {
                    input.addClass('is-invalid');

                    if(input.val().length == 0) {
                        text = 'Campo obrigatório!';
                    }else{
                        text = name + ' inválido!';
                    }
                    errors++;
                }
            }else{
                if(input.hasClass('is-invalid')) {
                    text = name + ' inválido!';
                    errors++;
                }
            }
            input.parents('.input-floating').find('.help-block').html(text);
        });
        if(errors > 0) {
            return false;
        }
        if(currentStep > maxSteps) {
            return false;
        }
        currentStep++;
        
        $(".step").hide();
        $(".step-" + currentStep).show();

        updateProgressBar();

        return true;
    });

    $('.input-control').blur(function (event) {
        event.preventDefault();

        $(this).removeClass('keep');

        if($(this).val().trim().length == 0) {
            return;
        }
        $(this).addClass('keep');
    });

    email.on('input', function (event) {
        event.preventDefault();

        $(this).email();
    });

    password.on('input', function (event) {
        event.preventDefault();
    
        const input = $(this);
        const value = input.val().trim();
    
        input.removeClass('is-valid is-invalid');
    
        let text = '';
        
        if(value.length == 0) {
            input.addClass('is-invalid');
            text = 'Campo obrigatório!';
        }else if(value.length >= 8) {
            const passwordValue = confirm_password.val();
    
            if(passwordValue.length >= 8) {
                if(value === passwordValue) {
                    input.addClass('is-valid');
                }else{
                    text = 'As senhas não são iguais';
                    input.addClass('is-invalid');
                }
            }else{
                input.addClass('is-valid');
            }
        }else{
            text = `Senha inválida!`;
            input.addClass('is-invalid');
        }
    
        input.parents('.input-floating').find('.help-block').html(text);

        updatePasswordStrength(value);
    });

    comment.on('input', function (event) {
        event.preventDefault();

        const textarea = $(this);
        
        const min = textarea.attr('minlength');
        const max = textarea.attr('maxlength');

        const length = textarea.val().length;

        textarea.removeClass('is-valid is-invalid');

        if(length > 0) {
            if(length < min) {
                textarea.addClass('is-invalid');
                $(this).parents('.form-floating').find('.input-tooltip').html('Campo requer, pelo menos 50 caracteres.');
            }else{
                textarea.addClass('is-valid');
            }
        }
        $('.comment-length').html(length + '/' + max);
    });

    $('.rating-list').on('click', '.star-icon', function (event) {
        event.preventDefault();

        const rate = $(this).data('rate');
        const labels = {
            1: 'Ruim',
            2: 'Regular',
            3: 'Bom',
            4: 'Muito Bom',
            5: 'Excelente'
        };
        let size = 0;
        const classList = $(this).find('i').attr('class').split(/\s+/);

        if(!classList || classList.length == 0) {
            size = 2;
        }
        const fontSize = classList.reverse()[0];

        if(fontSize.length > 0) {
            size = fontSize.substring(3);
        }
        $('.star-icon').each(function () {
            $(this).html($(this).data('rate') <= rate 
                ? `<i class="bi bi-star-fill me-2 fs-${size}"></i>` 
                : `<i class="bi bi-star me-2 fs-${size}"></i>`
            );
            if($(this).hasClass('is-selected')) {
                $(this).removeClass('is-selected');
            }
        });
        $('.btn-submit-review').removeClass('disabled');
        $(this).addClass('is-selected');
        $('.rating-label').html(labels[rate]);
    });

    $('.eye-pwd').click(function (event) {
        event.preventDefault();

        $(this).toggleClass('visible');

        const visible = $(this).hasClass('visible');

        let size = 0;
        const classList = $(this).find('i').attr('class').split(/\s+/);

        if(!classList || classList.length == 0) {
            size = 2;
        }
        const fontSize = classList.reverse()[0];

        if(fontSize.length > 0) {
            size = fontSize.substring(3);
        }
        
        $(this).html(visible 
            ? `<i class="bi bi-eye-slash-fill fs-${size}"></i>`
            : `<i class="bi bi-eye-fill fs-${size}">` 
        );
        $(this).parents('.input-floating').find('#password').attr('type', visible ? 'text' : 'password');
    });

    $('.modal').on('hidden.bs.modal', function (event) {
        event.preventDefault();        
        $(this).find('.input-control').each(function () {
            $(this).val('');
            $(this).parents('.input-floating').find('.help-block').html('');
            $(this).removeClass('is-valid is-invalid keep');
        });
    });
    
    $('#modal-review').on('hidden.bs.modal', function (event) {
        event.preventDefault();

        $('.star-icon').each(function () {
            let size = 0;
            const classList = $(this).find('i').attr('class').split(/\s+/);

            if(!classList || classList.length == 0) {
                size = 2;
            }
            const fontSize = classList.reverse()[0];

            if(fontSize.length > 0) {
                size = fontSize.substring(3);
            }
            $(this).html(`<i class="bi bi-star me-2 fs-${size}"></i>`);

            if($(this).hasClass('is-selected')) {
                $(this).removeClass('is-selected');
            }
        });
        comment.removeClass('is-valid is-invalid');
        comment.val('');

        $('.rating-label').html('');
        $('.comment-length').html('0/' + comment.attr('maxlength'));
        $('.btn-submit-review').addClass('disabled');
    });

    cep.keyup(function (event) {
        event.preventDefault();
        const input = $(this), 
            inputValue = input.val().replace(/\D/g, ''),
            isValid = inputValue.length === 8,
            text = isValid ? '' : input.data('custom-name') + ' inválido!';
    
        input.removeClass('is-valid is-invalid');

        input.toggleClass('is-valid', isValid);
        input.toggleClass('is-invalid', !isValid);

        input.parents('.form-floating').find('.help-block').html(text);
    });

    cpf.keyup(function (event) {
        event.preventDefault();
        const input = $(this), 
            inputValue = input.val(),
            isValid = validateCPF(inputValue),
            text = isValid ? '' : input.data('custom-name') + ' inválido!';
    
        input.removeClass('is-valid is-invalid');

        input.toggleClass('is-valid', isValid);
        input.toggleClass('is-invalid', !isValid);

        input.parents('.form-floating').find('.help-block').html(text).show();
    });

    $('.eye-check-input').change(function (event) {
        const checked = $(this).is(':checked')

        if(checked) {
            password.attr('type', 'text');
            confirm_password.attr('type', 'text');
        }else{
            password.attr('type', 'password');
            confirm_password.attr('type', 'password');
        }
    });
});