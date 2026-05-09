@php
    $type = $type ?? 'text';
    $placeholder = $placeholder ?? '';
    $value = $value ?? '';
    $required = $required ?? false;
    $autofocus = $autofocus ?? false;
    $hint = $hint ?? null;
@endphp

<div class="form-group">
    <label>{{ $label }}</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}" 
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
    >
    @if($hint)
        <p class="hint">{{ $hint }}</p>
    @endif
</div>

<style>
    .form-group {
        margin-bottom: 1.1rem;
    }

    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #4a5e78;
        margin-bottom: 0.4rem;
        letter-spacing: 0.01em;
    }

    .form-group input {
        width: 100%;
        padding: 0.7rem 1rem;
        background: white;
        border: 1.5px solid #dde3ed;
        border-radius: 10px;
        color: #0d1b2e;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }

    .form-group input:focus {
        border-color: #0055b3;
        box-shadow: 0 0 0 3px rgba(0,85,179,0.08);
    }

    .form-group input::placeholder {
        color: #b0bdcc;
    }

    .hint {
        font-size: 0.75rem;
        color: #8fa3bc;
        margin-top: 0.3rem;
    }
</style>