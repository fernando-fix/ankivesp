{{-- Course --}}
<input type="hidden" name="course_id" value="{{ $course->id }}">

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
