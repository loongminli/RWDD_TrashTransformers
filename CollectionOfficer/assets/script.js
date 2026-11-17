document.addEventListener('DOMContentLoaded', () => {

    function showFormError(form, message) {
        let box = form.parentElement.querySelector('.js-error');
        if (!box) {
            box = document.createElement('p');
            box.className = 'error js-error';
            box.setAttribute('role', 'alert');
            form.parentElement.insertBefore(box, form);
        }
        box.textContent = message;
        box.hidden = (message === '');
    }

    document.querySelectorAll('form.validate-form').forEach(form => {
        form.addEventListener('submit', (e) => {
            let message = '';

            form.querySelectorAll('input[type="text"], textarea').forEach(field => {
                field.value = field.value.trim();
                if (field.required && field.value === '') {
                    message = 'Please fill in all required fields. Spaces only is not allowed.';
                }
            });

            showFormError(form, message);
            if (message) e.preventDefault();
        });
    });

    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!confirm(form.dataset.confirm)) e.preventDefault();
        });
    });

    const actualInput = document.getElementById('actual_quantity');
    const qtyHint = document.getElementById('qtyHint');

    if (actualInput && qtyHint) {
        const declared = Number(actualInput.dataset.declared);

        actualInput.addEventListener('input', () => {
            const actual = Number(actualInput.value);
            if (actualInput.value !== '' && actual !== declared) {
                qtyHint.textContent = `Different from declared quantity (${declared}).`;
            } else {
                qtyHint.textContent = '';
            }
        });
    }

    const imageDialog = document.getElementById('imageDialog');
    const dialogImg = document.getElementById('dialogImg');

    if (imageDialog && dialogImg) {
        document.querySelectorAll('.zoom-trigger').forEach(btn => {
            btn.addEventListener('click', () => {
                const thumb = btn.querySelector('img');
                dialogImg.src = btn.dataset.full;
                dialogImg.alt = thumb.alt;
                imageDialog.showModal();
            });
        });

        document.getElementById('closeDialog')
            .addEventListener('click', () => imageDialog.close());

        imageDialog.addEventListener('click', (e) => {
            if (e.target === imageDialog) imageDialog.close();
        });
    }
    });
