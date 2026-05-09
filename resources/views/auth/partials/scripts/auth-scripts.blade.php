<script>
    const container = document.getElementById('authContainer');
    const formCard = document.getElementById('formCard');

    function showLogin() {
        container.classList.add('active-login');
        const tpl = document.getElementById('loginFormContainer');
        if (tpl) formCard.innerHTML = tpl.innerHTML;
    }

    function showRegister() {
        container.classList.add('active-login');
        const tpl = document.getElementById('registerFormContainer');
        if (tpl) formCard.innerHTML = tpl.innerHTML;
    }

    function showHero() {
        container.classList.remove('active-login');
    }
</script>