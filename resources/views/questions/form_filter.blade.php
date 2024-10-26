{{-- Course --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="course_id">Curso</label>
        <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id">
            <option value="">Selecione</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" @if (isset($filter['course_id']) && $filter['course_id'] == $course->id) selected @endif>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- Módulo --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="module_id">Módulo</label>
        <select class="form-control @error('module_id') is-invalid @enderror" id="module_id" name="module_id">
            <option value="">Selecione</option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}" @if (isset($filter['module_id']) && $filter['module_id'] == $module->id) selected @endif>
                    {{ $module->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- Aula --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="lesson_id">Aula</label>
        <select class="form-control @error('lesson_id') is-invalid @enderror" id="lesson_id" name="lesson_id">
            <option value="">Selecione</option>
            @foreach ($lessons as $lesson)
                <option value="{{ $lesson->id }}" @if (isset($filter['lesson_id']) && $filter['lesson_id'] == $lesson->id) selected @endif>
                    {{ $lesson->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- Pergunta --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="txt_question">Pergunta</label>
        <textarea class="form-control @error('question') is-invalid @enderror" name="question" id="question" rows="3">{{ isset($filter['question']) ? $filter['question'] : '' }}</textarea>
    </div>
</div>
