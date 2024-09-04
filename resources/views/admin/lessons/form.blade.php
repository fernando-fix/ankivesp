{{-- Name --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="name">Nome</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $lesson->name ?? '') }}" required autocomplete="off">
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

{{-- Module --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="module_id">Módulo</label>
        <select class="form-control @error('module_id') is-invalid @enderror" id="module_id" name="module_id"
            value="{{ old('module_id', $module->course ?? '') }}" required autocomplete="off">
            @if (!isset($lesson))
                <option value="">Escolha o curso primeiro</option>
            @endif
            @if (isset($lesson))
                <option value="">Selecione</option>
                @php
                    $modules = $lesson->course->modules;
                @endphp
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}"
                        @if (old('module_id')) @if (old('module_id') == $module->id)
                            selected @endif
                    @elseif (isset($lesson->module_id) && $lesson->module_id == $module->id) selected @endif>
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

{{-- Type --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="type">Tipo</label>
        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type"
            value="{{ old('type', $lesson->type ?? '') }}" required autocomplete="off">
            <option value="">Selecione</option>
            <option value="youtube" {{ old('type', $lesson->type ?? '') == 'youtube' ? 'selected' : '' }}>
                Vídeo do Youtube
            </option>
            {{-- <option value="pdf" {{ old('type', $lesson->type ?? '') == 'pdf' ? 'selected' : '' }}>
                Arquivo PDF
            </option>
            <option value="link" {{ old('type', $lesson->type ?? '') == 'link' ? 'selected' : '' }}>
                Link externo
            </option> --}}
        </select>
        @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- URL --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="url">URL (Youtube ou Link do questionário)</label>
        <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url"
            value="{{ old('url', $lesson->url ?? '') }}" required autocomplete="off">
        @error('url')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- File (PDF) --}}
{{-- <div class="form-row">
    <div class="form-group col-12">
        <label for="file">Arquivo (PDF)</label>
        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div> --}}


@once
    @push('js')
        <script>
            $('.modal').on('shown.bs.modal', function() {
                var modal = $(this);
                modal.find('#course_id').on('change', function() {
                    let course_id = $(this).val();
                    let url = "/admin/api/modules/:course_id";
                    url = url.replace(':course_id', course_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {
                            course_id: course_id
                        },
                        success: function(response) {
                            modal.find('#module_id').empty();
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
            });
        </script>
    @endpush
@endonce
