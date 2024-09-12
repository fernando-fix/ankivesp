{{-- Name --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="name">Nome</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $course->name ?? '') }}" required autocomplete="off">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">
    {{-- Year --}}
    <div class="form-group col-6">
        <label for="year">Ano</label>
        <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year"
            value="{{ old('year', $course->year ?? '') }}" required autocomplete="off">
        @error('year')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    {{-- Semester --}}
    <div class="form-group col-6">
        <label for="semester">Semestre</label>
        <select class="form-control @error('semester') is-invalid @enderror" id="semester" name="semester"
            value="{{ old('semester', $course->semester ?? '') }}" required autocomplete="off">
            <option value="1" {{ old('semester', $course->semester ?? '') == 1 ? 'selected' : '' }}>1</option>
            <option value="2" {{ old('semester', $course->semester ?? '') == 2 ? 'selected' : '' }}>2</option>
        </select>
        @error('semester')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    {{-- Image --}}
    <div class="form-group col-12">
        <label for="image">Imagem</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
        @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
