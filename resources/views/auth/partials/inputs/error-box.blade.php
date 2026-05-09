@if ($errors->any())
    <div class="error-msg">{{ $errors->first() }}</div>
@endif

<style>
    .error-msg {
        background: #fef2f2;
        border: 1px solid #fca5a5;
        color: #dc2626;
        padding: 0.65rem 0.9rem;
        border-radius: 9px;
        font-size: 0.82rem;
        margin-bottom: 1.25rem;
        font-weight: 500;
    }
</style>
