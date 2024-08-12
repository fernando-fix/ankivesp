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

{{-- Module --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="module_id">Módulo</label>
        <select class="form-control @error('module_id') is-invalid @enderror" id="module_id" name="module_id"
            value="{{ old('module_id', $module->course ?? '') }}" required autocomplete="off">
            <option value="">Selecione</option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}"
                    {{ old('module_id', $module->course ?? '') == $module->id ? 'selected' : '' }}>{{ $module->name }}
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
            <option value="pdf" {{ old('type', $lesson->type ?? '') == 'pdf' ? 'selected' : '' }}>
                Arquivo PDF
            </option>
            <option value="link" {{ old('type', $lesson->type ?? '') == 'link' ? 'selected' : '' }}>
                Link externo
            </option>
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
<div class="form-row">
    <div class="form-group col-12">
        <label for="file">Arquivo (PDF)</label>
        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


@once
    @push('js')
        <script>
            $('.modal').on('shown.bs.modal', function() {
                var modal = $(this);
                // mostrar qual é o modal que está sendo aberto
                console.log(modal.attr('id'));
            });
        </script>
    @endpush
@endonce
