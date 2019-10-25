if(document.getElementById('form-signup')) {
    let form = document.getElementById('form-signup');
    let helpers = form.querySelectorAll('input.helper');
    Array.prototype.forEach.call(helpers, helper => {
        helper.addEventListener('focus', () => {
            ((helper.parentNode).querySelector('small')).classList.remove('d-none');
        });
        helper.addEventListener('blur', () => {
            ((helper.parentNode).querySelector('small')).classList.add('d-none');
        });
    });
    
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let pwd = form.querySelector('input[name=pwd]');
        let pwd2 = form.querySelector('input[name=pwd2]');
        if(pwd.value !== pwd2.value) {
            pwd2.style.borderColor = 'red';
            return;
        };
        form.submit();
    })
}