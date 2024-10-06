{{-- name --}}
<div class="form-row">
    <div class="form-group col-12" style="max-width: 300px">
        <label for="name">Nome</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $user->name ?? '') }}" required autocomplete="off">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- password --}}
<div class="form-row">
    <div class="form-group col-12" style="max-width: 300px">
        <label for="password">Senha</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
            name="password" value="{{ old('password') }}" autocomplete="off">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- password_confirmation --}}
<div class="form-row">
    <div class="form-group col-12" style="max-width: 300px">
        <label for="password_confirmation">Confirme a senha</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
            id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}"
            autocomplete="off">
        @error('password_confirmation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </div>
</div>
