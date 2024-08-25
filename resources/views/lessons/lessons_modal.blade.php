<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#lessonsModal">
    <i class="fas fa-list"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="lessonsModal" tabindex="-1" aria-labelledby="lessonsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lessonsModalLabel">Aulas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($modules as $module)
                    @if ($module->lessons->count() > 0)
                        <h5 class="badge badge-primary">{{ $module->name }}</h5>
                        <ul class="list-group">
                            @foreach ($module->lessons as $lesson)
                                <a class="list-group-item" href="{{ route('lessons.show', $lesson) }}">
                                    <i class="fas fa-eye text-primary"></i>
                                    {{ $lesson->name }}
                                </a>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
