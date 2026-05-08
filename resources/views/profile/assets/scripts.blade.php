<script>
    const html = document.documentElement;
    const saved = localStorage.getItem('epg-theme') || 'light';
    html.setAttribute('data-theme', saved);

    document.getElementById('themeToggle').addEventListener('click', () => {
        const curr = html.getAttribute('data-theme');
        const next = curr === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('epg-theme', next);
    });

    function previewAvatar(input) {
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatarPreview');
            const initial = document.getElementById('avatarInitial');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initial) initial.style.display = 'none';
            document.querySelectorAll('.profile-avatar-sm img').forEach(img => {
                img.src = e.target.result;
                img.style.display = 'block';
            });
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('avatarForm').submit();
    }

    function checkStrength(val) {
        const bars = ['bar1','bar2','bar3','bar4'].map(id => document.getElementById(id));
        const label = document.getElementById('strengthLabel');
        let score = 0;
        if (val.length >= 8)  score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        const colors = ['#ef4444','#f59e0b','#f59e0b','#10b981'];
        const labels = ['Weak','Fair','Good','Strong'];
        bars.forEach((b, i) => { b.style.background = i < score ? colors[score - 1] : 'var(--border)'; });
        label.textContent = val.length > 0 ? labels[score - 1] || '' : '';
        label.style.color = score > 0 ? colors[score - 1] : 'var(--text3)';
    }
</script>