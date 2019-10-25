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
}