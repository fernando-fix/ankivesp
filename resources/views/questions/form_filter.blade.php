{{-- Course --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="course_id">Curso</label>
        <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id"
            value="{{ old('course_id', $module->course ?? '') }}" required autocomplete="off">
            <option value="">Selecione</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                    @if (old('course_id')) @if (old('course_id') == $course->id)
                            selected @endif
                @elseif (isset($lesson->module->course_id) && $lesson->module->course_id == $course->id) selected @endif>
                    {{ $course->name }}
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

{{-- Módulo --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="module_id">Módulo</label>
        <select class="form-control @error('module_id') is-invalid @enderror" id="module_id" name="module_id"
            value="{{ old('module_id', $module->id ?? '') }}" required autocomplete="off">
            <option value="">Selecione</option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}"
                    @if (old('module_id')) @if (old('module_id') == $module->id)
                            selected @endif
                @elseif (isset($module) && $module->id == $module->id) selected @endif>
                    {{ $module->name }}
                </option>
            @endforeach
        </select>
        @error('module_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Aula --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="lesson_id">Aula</label>
        <select class="form-control @error('lesson_id') is-invalid @enderror" id="lesson_id" name="lesson_id"
            value="{{ old('lesson_id', $module->id ?? '') }}" required autocomplete="off">
            <option value="">Selecione</option>
            @foreach ($lessons as $lesson)
                <option value="{{ $lesson->id }}"
                    @if (old('lesson_id')) @if (old('lesson_id') == $lesson->id)
                            selected @endif
                @elseif (isset($lesson) && $lesson->id == $lesson->id) selected @endif>
                    {{ $lesson->name }}
                </option>
            @endforeach
        </select>
        @error('lesson_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
