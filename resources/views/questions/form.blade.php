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
                @elseif (isset($question->module->course_id) && $question->module->course_id == $course->id) selected @endif>
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

{{-- Module --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="module_id">Módulo</label>
        <select class="form-control @error('module_id') is-invalid @enderror" id="module_id" name="module_id"
            value="{{ old('module_id', $module->course ?? '') }}" required autocomplete="off">
            @if (!isset($question) && old('module_id'))
                @php
                    $old_module = App\Models\Module::find(old('module_id'));
                @endphp
                <option value="{{ $old_module->id }}" selected>{{ $old_module->name }}</option>
            @elseif (!isset($question))
                <option value="">Escolha o curso primeiro</option>
            @endif
            @if (isset($question))
                <option value="">Selecione</option>
                @php
                    $modules = $question->course->modules;
                @endphp
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}"
                        @if (old('module_id')) @if (old('module_id') == $module->id)
                            selected @endif
                    @elseif (isset($question->module->id) && $question->module->id == $module->id) selected @endif>
                        {{ $module->name }}
                    </option>
                @endforeach
            @endif
        </select>
        @error('module_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Lessons --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="lesson_id">Aula</label>
        <select class="form-control @error('lesson_id') is-invalid @enderror" id="lesson_id" name="lesson_id"
            value="{{ old('lesson_id', $module->course ?? '') }}" required autocomplete="off">
            @if (!isset($question) && old('lesson_id'))
                @php
                    $old_lesson = App\Models\Lesson::find(old('lesson_id'));
                @endphp
                <option value="{{ $old_lesson->id }}" selected>{{ $old_lesson->name }}</option>
            @elseif (!isset($question))
                <option value="">Escolha o módulo primeiro</option>
            @endif

            @if (isset($question))
                <option value="">Selecione</option>
                @php
                    $lessons = $question->module->lessons;
                @endphp
                @foreach ($lessons as $lesson)
                    <option value="{{ $lesson->id }}"
                        @if (old('lesson_id')) @if (old('lesson_id') == $module->id)
                            selected @endif
                    @elseif (isset($question->lesson->id) && $question->lesson->id == $lesson->id) selected @endif>
                        {{ $lesson->name }}
                    </option>
                @endforeach
            @endif
        </select>
        @error('lesson_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row d-flex flex-column">
    <div class="form-group col-12">
        <label for="txt_question{{ $question->id ?? '' }}">Pergunta</label>
        <div id="txt_question{{ $question->id ?? '' }}" class="quill-editor"></div>
        <input type="hidden" name="question" value="{{ old('question', $question->question ?? '') }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        <label for="type">Resposta correta</label>
        <br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="correct_answer"
                @error('correct_answer') is-invalid @enderror id="correct_answer01-{{ $question->id ?? '' }}"
                value="answer_1"
                @if (old('correct_answer') == 'answer01') checked
                @elseif (isset($question) && $question->answers[0]->correct)
                    checked @endif>
            <label class="form-check-label" for="correct_answer01-{{ $question->id ?? '' }}">Resposta - 01</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="correct_answer"
                @error('correct_answer') is-invalid @enderror id="correct_answer02-{{ $question->id ?? '' }}"
                value="answer_2"
                @if (old('correct_answer') == 'answer02') checked
                @elseif (isset($question) && $question->answers[1]->correct)
                    checked @endif>
            <label class="form-check-label" for="correct_answer02-{{ $question->id ?? '' }}">Resposta - 02</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="correct_answer"
                @error('correct_answer') is-invalid @enderror id="correct_answer03-{{ $question->id ?? '' }}"
                value="answer_3"
                @if (old('correct_answer') == 'answer03') checked
                @elseif (isset($question) && $question->answers[2]->correct)
                    checked @endif>
            <label class="form-check-label" for="correct_answer03-{{ $question->id ?? '' }}">Resposta - 03</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="correct_answer"
                @error('correct_answer') is-invalid @enderror id="correct_answer04-{{ $question->id ?? '' }}"
                value="answer_4"
                @if (old('correct_answer') == 'answer04') checked
                @elseif (isset($question) && $question->answers[3]->correct)
                    checked @endif>
            <label class="form-check-label" for="correct_answer04-{{ $question->id ?? '' }}">Resposta - 04</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="correct_answer"
                @error('correct_answer') is-invalid @enderror id="correct_answer05-{{ $question->id ?? '' }}"
                value="answer_5"
                @if (old('correct_answer') == 'answer05') checked
                @elseif (isset($question) && $question->answers[4]->correct)
                    checked @endif>
            <label class="form-check-label" for="correct_answer05-{{ $question->id ?? '' }}">Resposta - 05</label>
        </div>
        @if ($errors->has('correct_answer'))
            <div class="invalid-feedback" style="display: block;">
                <strong>{{ $errors->first('correct_answer') }}</strong>
            </div>
        @endif
    </div>
</div>

{{-- Resposta 01 --}}
<div class="form-row d-flex flex-column">
    <div class="form-group col-12">
        <label for="txt_answer01{{ $question->id ?? '' }}">Resposta - 01</label>
        <div id="txt_answer01{{ $question->id ?? '' }}" class="quill-editor"></div>
        <input type="hidden" name="answers[0][answer]"
            value="{{ old()['answers'][0]['answer'] ?? ($question->answers[0]->answer ?? '') }}">
        <input type="hidden" class="quill_ignore" name="answers[0][answer_id]"
            value="{{ $question->answers[0]->id ?? 0 }}">
    </div>
</div>

{{-- Resposta 02 --}}
<div class="form-row d-flex flex-column">
    <div class="form-group col-12">
        <label for="txt_answer02">Resposta - 02</label>
        <div id="txt_answer02" class="quill-editor"></div>
        <input type="hidden" name="answers[1][answer]"
            value="{{ old()['answers'][1]['answer'] ?? ($question->answers[1]->answer ?? '') }}">
        <input type="hidden" class="quill_ignore" name="answers[1][answer_id]"
            value="{{ $question->answers[1]->id ?? 0 }}">
    </div>
</div>

{{-- Resposta 03 --}}
<div class="form-row d-flex flex-column">
    <div class="form-group col-12">
        <label for="txt_answer03">Resposta - 03</label>
        <div id="txt_answer03" class="quill-editor"></div>
        <input type="hidden" name="answers[2][answer]"
            value="{{ old()['answers'][2]['answer'] ?? ($question->answers[2]->answer ?? '') }}">
        <input type="hidden" class="quill_ignore" name="answers[2][answer_id]"
            value="{{ $question->answers[2]->id ?? 0 }}">
    </div>
</div>

{{-- Resposta 04 --}}
<div class="form-row d-flex flex-column">
    <div class="form-group col-12">
        <label for="txt_answer04">Resposta - 04</label>
        <div id="txt_answer04" class="quill-editor"></div>
        <input type="hidden" name="answers[3][answer]"
            value="{{ old()['answers'][3]['answer'] ?? ($question->answers[3]->answer ?? '') }}">
        <input type="hidden" class="quill_ignore" name="answers[3][answer_id]"
            value="{{ $question->answers[3]->id ?? 0 }}">
    </div>
</div>

{{-- Resposta 05 --}}
<div class="form-row d-flex flex-column">
    <div class="form-group col-12">
        <label for="question">Resposta - 05</label>
        <div id="txt_answer05" class="quill-editor"></div>
        <input type="hidden" name="answers[4][answer]"
            value="{{ old()['answers'][4]['answer'] ?? ($question->answers[4]->answer ?? '') }}">
        <input type="hidden" class="quill_ignore" name="answers[4][answer_id]"
            value="{{ $question->answers[4]->id ?? 0 }}">
    </div>
</div>

@once

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    @endpush


    @push('js')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var editors = document.querySelectorAll('.quill-editor');
                editors.forEach(function(editor) {
                    var quill = new Quill(editor, {
                        theme: 'snow'
                    });
                    var hiddenInput = editor.nextElementSibling;
                    if (hiddenInput && hiddenInput.type === 'hidden' && hiddenInput.className !=
                        'quill_ignore') {
                        if (hiddenInput.value) {
                            quill.root.innerHTML = hiddenInput.value;
                        }
                        quill.on('text-change', function() {
                            hiddenInput.value = quill.root.innerHTML;
                        });
                    }
                });
            });
        </script>
    @endpush

    @push('js')
        <script>
            $('.modal').on('shown.bs.modal', function() {
                var modal = $(this);
                modal.find('#course_id').on('change', function() {
                    let course_id = $(this).val();
                    let url = "/admin/json/modules/:course_id";
                    url = url.replace(':course_id', course_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {
                            course_id: course_id
                        },
                        success: function(response) {
                            modal.find('#module_id').empty();
                            modal.find('#lesson_id').empty();
                            modal.find('#lesson_id').append(
                                '<option value="">Selecione o módulo</option>');
                            // se a resposta for vazia
                            if (response.length > 0) {
                                modal.find('#module_id').append(
                                    '<option value="">Selecione</option>');
                                response.forEach(element => {
                                    modal.find('#module_id').append('<option value="' +
                                        element
                                        .id + '">' + element
                                        .name + '</option>');
                                })
                            } else {
                                modal.find('#module_id').append(
                                    '<option value="">Cadastre um módulo para este curso</option>'
                                );
                            }
                        }
                    });
                });

                modal.find('#module_id').on('change', function() {
                    let module_id = $(this).val();
                    let url = "/admin/json/lessons/:module_id";
                    url = url.replace(':module_id', module_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {
                            module_id: module_id
                        },
                        success: function(response) {
                            modal.find('#lesson_id').empty();
                            // se a resposta for vazia
                            if (response.length > 0) {
                                modal.find('#lesson_id').append(
                                    '<option value="">Selecione</option>');
                                response.forEach(element => {
                                    modal.find('#lesson_id').append('<option value="' +
                                        element
                                        .id + '">' + element
                                        .name + '</option>');
                                })
                            } else {
                                modal.find('#lesson_id').append(
                                    '<option value="">Cadastre uma aula para este módulo</option>'
                                );
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce
