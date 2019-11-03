if(document.getElementById('form-signup')) {
    let form = document.getElementById('form-signup');
    let pwd = form.querySelector('input[name=pwd]');
    let pwd2 = form.querySelector('input[name=pwd2]');
    let helpers = form.querySelectorAll('input.helper');
    
    Array.prototype.forEach.call(helpers, helper => {
        helper.addEventListener('focus', () => {
            ((helper.parentNode).querySelector('small')).classList.remove('d-none');
        });
        helper.addEventListener('blur', () => {
            ((helper.parentNode).querySelector('small')).classList.add('d-none');
        });
    });

    pwd2.addEventListener('blur',() => {
        if(pwd2.value !== pwd.value) {
            if(!(pwd2.parentNode).classList.contains('has-error')) {
                (pwd2.parentNode).classList.add('has-error');
            };
        } else {
            if((pwd2.parentNode).classList.contains('has-error')) {
                (pwd2.parentNode).classList.remove('has-error');
            };
        };
    });
    
    form.addEventListener('submit', e => {
        e.preventDefault();
        if((form.querySelectorAll('.has-error')).length > 0) return;
        form.submit();
    });
};

if(document.getElementById('form-add-ads') || document.getElementById('form-edit-ads')) {
    
    if(document.getElementById('form-add-ads')) {
        (document.getElementById('form-add-ads')).addEventListener('submit', (e) => {
            e.preventDefault();
            let error = validateForm(document.getElementById('form-add-ads'));
            if(error) return;
            let error2 = validRaioImgInForm(e);
            if(error2) return;
            (e.target).submit();
        });
    };
    
    if(document.getElementById('form-edit-ads')) {
        (document.getElementById('form-edit-ads')).addEventListener('submit', (e) => {
            e.preventDefault();
            let error = validateForm(document.getElementById('form-edit-ads'));
            if(error) return;
            let error2 = validRaioImgInForm(e);
            if(error2) return;
            (e.target).submit();
        });
    };

    displayCardImg();

    (document.querySelector('input[type=file]')).addEventListener('change', function() {
        renderIMG(this);
        (document.querySelector('input[type=file]')).value = "";
    });

    function renderIMG(input) {  
        Array.prototype.forEach.call(input.files, file => {
            if(file.type === 'image/png' || file.type === 'image/jpeg') {

                if(!(document.getElementById(file.name))) {
                    let reader = new FileReader();
                    reader.onload = (e) => {           
                        let inputsImg = document.getElementById('input-imgs');
                        let radiosImg = document.getElementById('radio-imgs');

                        let input = document.createElement('input');
                        input.setAttribute('type', 'text');
                        input.setAttribute('name', 'add-imgs[]');
                        input.setAttribute('value', `name:${file.name};${e.target.result}`);
                        inputsImg.appendChild(input);

                        let div = document.createElement('div');
                        div.setAttribute('class', 'img-product d-flex flex-column col-12 col-md-6 col-lg-4');

                        let radio = document.createElement('input');
                        radio.setAttribute('type', 'radio');
                        radio.setAttribute('name', 'imgckd');
                        radio.setAttribute('id', file.name);
                        radio.setAttribute('value', file.name);
                        if(!radiosExists()) radio.setAttribute('checked', true);    
                        
                        div.appendChild(radio);                    

                        let label = document.createElement('label');
                        label.setAttribute('for', file.name);
                        label.setAttribute('class', 'd-flex flex-column');
                        
                        let img = document.createElement('img');
                        img.setAttribute('src', e.target.result);
                        img.setAttribute('alt', file.name);
                        label.appendChild(img);                    

                        let btnDel = document.createElement('button');
                        btnDel.appendChild(document.createTextNode('Excluir'));
                        btnDel.setAttribute('type', 'button');
                        btnDel.setAttribute('class', 'btn btn-danger m-2');
                        btnDel.setAttribute('onclick', 'removeAdsImg(this)');
                        label.appendChild(btnDel);
                        
                        div.appendChild(label);
                        radiosImg.appendChild(div);

                        displayCardImg();
                        ErrorRadio();    

                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Imagem já adicionada');
                };
            } else {
                alert('Erro !!! \nSó é permitido arquivos com extenção .jpeg/jpg/png');
            }
        });
    };

    function removeAdsImg(e) {
        let origin = ((e.parentNode).querySelector('img')).getAttribute('data-origin') || ''; 
        let img = ((e.parentNode).querySelector('img')).getAttribute('alt');
        let divInputs = document.getElementById('input-imgs');

        if(origin === 'db') {
            let input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('name', 'del-imgs[]');
            input.setAttribute('value', img);
            divInputs.appendChild(input);
        } else {
            Array.prototype.forEach.call((divInputs.querySelectorAll('input')), input => {
                if(input.value === img) input.remove();
            });
        };
        ((e.parentNode).parentNode).remove();
        displayCardImg();
    };

    function displayCardImg() {
        if((document.getElementById('radio-imgs')).children.length > 0) {
            (document.getElementById('card-imgs')).classList.remove('d-none');
        } else if(!(document.getElementById('card-imgs')).classList.contains('d-none')) {
            (document.getElementById('card-imgs')).classList.add('d-none');
        };
    };

    function radiosExists() {
        let radios = document.querySelectorAll('input[type=radio]');
        return (radios.length > 0) ? true : false;
    };

    function ErrorRadio() {
        document.querySelectorAll('.img-product label').forEach(radio => {
            radio.addEventListener('click', () => {
                if(document.querySelector('small[data-error=radios-img]')) document.querySelector('small[data-error=radios-img]').remove();
            });
        });

    };

    function validRaioImgInForm(e) {
        if(document.querySelectorAll('input[type=radio]').length > 0) {
            let ckd = false;
            Array.prototype.forEach.call(document.querySelectorAll('input[type=radio]'), radio => {
                if(radio.checked) ckd = true;
            })
            if(!ckd) {
                if(!document.querySelector('small[data-error=radios-img]')) {
                    let error = document.createElement('small');
                    error.setAttribute('class', 'd-block w-100 text-center');
                    error.setAttribute('data-error', 'radios-img');
                    error.style.color = 'red';
                    error.appendChild(document.createTextNode('Selecione uma imagem para ser a principal.'))
                    document.getElementById('radio-imgs').insertBefore(error, document.getElementById('radio-imgs').firstChild);
                };
            };
        };
        return (document.querySelectorAll('[data-error]').length > 0) ? true : false;
    };
};

function validateForm(form) {
    let requireds = form.querySelectorAll('[required]');
    Array.prototype.forEach.call(requireds, required => {
        switch(required.nodeName) {
            case 'SELECT':
                if((required.value) === '-1') addError(required);
                required.addEventListener('change', () => removeError(required));
                break;
            case 'RADIO':
                if((required.checked) === undefined) addError(required);
                required.addEventListener('change', () => removeError(required));
                break;
            default:
                if((required.value).length <= 0) addError(required);
                required.addEventListener('change', () => removeError(required));
                break;
        };
    });

    function addError(el) {
        if(!document.getElementById(`error-${el.name}`)) {
            let error = document.createElement('small');
            error.setAttribute('id', `error-${el.name}`);
            error.setAttribute('class', 'd-block');
            error.setAttribute('data-error', 'required');
            error.style.color = 'red';
            error.appendChild(document.createTextNode('Este campo é obrigatório.'));
            (el.parentNode).insertBefore(error, el.nextSibilian);
        };
    };
    
    function removeError(e) {
        if(document.getElementById(`error-${e.name}`)) (document.getElementById(`error-${e.name}`)).remove();
    }
    function hasError() {
        return (form.querySelectorAll('[data-error]').length > 0) ? true : false;
    };

    return hasError();
}; 