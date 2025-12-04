window.addEventListener('load', function() {
    setTimeout(function() {
        const inputElement = document.getElementById('web');

        if (inputElement) {
            const parentLabel = inputElement.closest('label');

            if (parentLabel) {
                const newFieldHTML = '<label>URL <input type="url" id="web-url" name="web_url" placeholder="https://" class="web-form-control"></label>';
                parentLabel.insertAdjacentHTML('afterend', newFieldHTML);
            }
        }
    }, rjMoneyspotValue);
});
