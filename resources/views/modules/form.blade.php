{{-- Name --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="name">Nome</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $module->name ?? '') }}" required autocomplete="off">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Course --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="course_id">Curso</label>
        <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id"
            value="{{ old('course_id', $module->course ?? '') }}" required autocomplete="off">
            <option value="">Selecione</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                    {{ old('course_id', $module->course ?? '') == $course->id ? 'selected' : '' }}>{{ $course->name }}
                </option>
            @endforeach
        </select>
        @error('course_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Due date --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="due_date">Prazo</label>
        <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date"
            name="due_date" value="{{ old('due_date', $module->due_date ?? '') }}" required autocomplete="off">
        @error('due_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
