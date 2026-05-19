document.addEventListener('DOMContentLoaded', () => {
    const dt = document.querySelector('input[type="datetime-local"]');
    if (dt) {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        dt.min = now.toISOString().slice(0,16);
    }
});
