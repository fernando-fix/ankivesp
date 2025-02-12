{{-- key --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="key">Nome</label>
        <input type="text" class="form-control @error('key') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $config->name ?? '') }}" required autocomplete="off">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Chave --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="key">Chave</label>
        <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key"
            value="{{ old('key', $config->key ?? '') }}" required autocomplete="off">
        @error('key')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Valor --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="value">Valor</label>
        <textarea class="form-control @error('value') is-invalid @enderror" id="value" name="value" rows="3" required>{{ old('value', $config->value ?? '') }}</textarea>
        @error('value')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
