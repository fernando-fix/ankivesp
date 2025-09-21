{{-- Course:hidden --}}
<input type="hidden" name="course_id" value="{{ $course->id }}">

{{-- Module:hidden --}}
<input type="hidden" name="module_id" value="{{ $module->id }}">

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
            {{-- <option value="link" {{ old('type', $lesson->type ?? '') == 'link' ? 'selected' : '' }}>
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
            value="{{ old('url', $lesson->url ?? '') }}" autocomplete="off">
        @error('url')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Transcription --}}
<div class="form-row">
    <div class="form-group col-12">
        <label for="transcription">
            Transcrição
            @if (isset($lesson) && $lesson->video_id)
                <a type="button" href="https://ytscribe.com/pt/v/{{ $lesson->video_id }}" title="Visualizar"
                    target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    Transcrição
                </a>
            @endif
        </label>
        <textarea class="form-control js_transcript @error('transcription') is-invalid @enderror"
            id="transcription-{{ $lesson->id ?? '' }}" name="transcription" rows="3">{{ old('transcription', $lesson->transcription ?? '') }}</textarea>
        @error('transcription')
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
